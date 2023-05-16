<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Billing extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('billings');
      $this->load->helper('file_upload');
      $this->load->helper('excel_data_validate');
    }

    public function get_prepaidusers()
    {
        $result=$this->billing_model->get_prepaiduser($this->input->post('id'));
        if($result!='0')
            echo $result['user_id']."#".$result['fullname']."#".$result['business_name']."#".$result['main_balance']."#".$result['promo_balance']."#".$result['total_balance'];
        else
           echo '0';
    }

    /* For UserBalances  */
    public function manage_balances()
    {
        $txn_ref="";
        $main_amt=$this->input->post('main_bal');
        $promo_amt=$this->input->post('promo_bal');
        $user_id=$this->input->post('user_id');
        $this->form_validation->set_rules('user_id', 'Username', 'required|trim');
        $this->form_validation->set_rules('balance_type', 'Balance', 'required');
        $this->form_validation->set_rules('action_type', 'Action', 'required');
        $this->form_validation->set_rules('transaction_amount', 'Amount', 'required|trim');
        $this->form_validation->set_rules('transaction_remark', 'Remark', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            if($this->input->post('action_type')=='credit')
            {
                $txn_ref=$this->input->post('user_id').now().'C'.rand(999,100000);
                $txn_type='1001';

                if($this->input->post('balance_type')=='main')
                    $main_amt+=$this->input->post('transaction_amount');
                else if($this->input->post('balance_type')=='promo')
                    $promo_amt+=$this->input->post('transaction_amount');
            }
            else if($this->input->post('action_type')=='debit')
            {
                $txn_ref=$this->input->post('user_id').now().'D'.rand(999,100000);
                $txn_type='1006';

                if($this->input->post('balance_type')=='main')
                    $main_amt-=$this->input->post('transaction_amount');
                else if($this->input->post('balance_type')=='promo')
                    $promo_amt-=$this->input->post('transaction_amount');
            }
            
            $form_data_txn = array(
                'user_id' => $this->input->post('user_id'),
                'balance_type' => $this->input->post('balance_type'),
                'action_type' => $this->input->post('action_type'),
                'transaction_reference_id' => $txn_ref,
                'transaction_type' => $txn_type,
                'transaction_status' => '551',
                'transaction_amount' => $this->input->post('transaction_amount'),
                'opening_balance' => $this->input->post('total_balance'),
                'closing_balance' => $main_amt+$promo_amt,
                'transaction_remark' => $this->input->post('transaction_remark'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $form_data_bal = array(
                'user_id' => $this->input->post('user_id'),
                'main_balance' => $main_amt,
                'promo_balance' => $promo_amt,
                'total_balance' => $main_amt+$promo_amt,
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "manage_balance",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->billing_model->manage_balance($form_data_txn,$form_data_bal,$user_id) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'User balance '.$this->input->post('action_type').'ed successfully.';
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = 'Some Error occurred, Try again.';
            }
            echo json_encode($output);
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = validation_errors();
            echo json_encode($output);
        }
    }

    //To Change Status Manually
    public function change_status()
    {        
        $date = date('Y-m-d',strtotime($this->input->post('status_date')));
        $del_date = date('d',strtotime($this->input->post('status_date')));
        $awb = $this->input->post('awb_num');
        $cod_data = array();
        $order_details = $this->billing_model->get_orderdetails_invoice($awb);
        // print_r($order_details);

        if(!empty($order_details))
        {
            if($order_details['billing_eligibility']=='0')
            {
                $invoice_data = array (
                    'user_id'          => $order_details['user_id'],
                    'invoice_date'     => get_billingdate($order_details['billing_cycle_dates'],$del_date),
                    'invoice_amount'   => $order_details['charges_total'],
                    'gst_amount'       => $order_details['gst_amount'],
                    'total_amount'     => $order_details['total_amount'],
                    'shipments_count'  => '1',
                    'paid_amount'      => $order_details['paid_amount'],
                    'due_amount'       => $order_details['total_amount']-$order_details['paid_amount'],
                );

                if($this->input->post('order_status')=='226') // If Delivered
                {
                    // Update shipment status to Delivered
                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";
                    //Calculate COD Eligible Date
                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                    //$cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                    
                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='0')
                    {
                        $sb_data = array(
                            'billing_eligibility'   => '1',
                            'billing_eligible_date' => $date,
                            'cod_status'            => '1',
                            'cod_date'              => $date,
                            'cod_eligible_date'     => $cod_edate,
                            'cod_cycle_date'        => $cod_cdate,
                            'updated_by'            => 'system'
                        );

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => $order_details['cod_amount'],
                        );
                    }
                    else
                        $sb_data = array(
                            'billing_eligibility'   => '1',
                            'billing_eligible_date' => $date,
                            'updated_by'            => 'system'
                        );
                    
                    //Insert Data invoice_accrue_ondel
                    if($this->billing_model->invoice_accrue_ondel($query_s,$sb_data,$awb,$invoice_data,$cod_data))
                    {
                        //Inserting Billing Logs
                        $shipments_billing_logs = array(
                            'waybill_number'    => $awb,
                            'billing_status'    => '226',
                            'billing_date'      => $date,
                            'billing_remark'    => 'D',
                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                        );
                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else if($this->input->post('order_status')=='225') //If RTO
                {
                    // Update shipment status to RTO
                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate RTO Charges & Update Amounts
                    $sb_data = $this->getdata_model->get_rtocharges($awb);

                    $sb_data['billing_eligibility']='1';
                    $sb_data['billing_eligible_date']=$date;
                    $sb_data['cod_date']  = $date;
                    $sb_data['cod_status']='3';
                    $sb_data['updated_by']='system';

                    //Insert Data invoice_accrue_onrto
                    if($this->billing_model->invoice_accrue_onrto($query_s,$sb_data,$awb,$invoice_data,$order_details['billing_type']))
                    {
                        //Inserting Billing Logs
                        $shipments_billing_logs = array(
                            'waybill_number'    => $awb,
                            'billing_status'    => '225',
                            'billing_date'      => $date,
                            'billing_remark'    => 'R',
                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                        );
                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
            }
            else if($order_details['billing_eligibility']=='1')
            {
                if($this->input->post('order_status')=='226' && $order_details['user_status'] != '226') // If Delivered from RTO
                {
                    // Update shipment status to Delivered
                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate Forward Charges
                    $sb_data = $this->getdata_model->get_fwdcharges($awb);

                    //Calculate COD Eligible Date
                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                    // $cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                    
                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='3')
                    {
                        $sb_data['cod_status']        = '1';
                        $sb_data['cod_eligible_date'] = $cod_edate;
                        $sb_data['cod_cycle_date']    = $cod_cdate;
                        $sb_data['cod_date']          = $date;

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => $order_details['cod_amount'],
                        );
                    }
                    
                    // print_r($sb_data);

                    $invoice_data_diff = array(
                        'user_id'        => $order_details['user_id'],
                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                    );               
    
                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                    {
                        //Inserting Billing Logs
                        $shipments_billing_logs = array(
                            'waybill_number'    => $awb,
                            'billing_status'    => '226',
                            'billing_date'      => $date,
                            'billing_remark'    => 'RD',
                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                        );
                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else if($this->input->post('order_status')=='225' && $order_details['user_status'] != '225') // If RTO from Delivered
                {
                    // Update shipment status to RTO
                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate RTO Charges & Update Amounts
                    $sb_data = $this->getdata_model->get_rtocharges($awb);
                    $sb_data['cod_status']        = '3';

                     //Calculate COD Eligible & Cycle Date
                     $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                     $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);

                    // if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='1')
                    if($order_details['payment_mode']=='COD')
                    {
                        $sb_data['cod_eligible_date'] = '';
                        $sb_data['cod_cycle_date']    = '';
                        // $sb_data['cod_trn']        = '';
                        $sb_data['cod_date']          = $date;

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => '-'.$order_details['cod_amount'],
                        );
                    }

                    $invoice_data_diff = array(
                        'user_id'        => $order_details['user_id'],
                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                    );               
    
                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                    {
                        //Inserting Billing Logs
                        $shipments_billing_logs = array(
                            'waybill_number'    => $awb,
                            'billing_status'    => '225',
                            'billing_date'      => $date,
                            'billing_remark'    => 'DR',
                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                        );
                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Status uptodate.';
                }
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Invalid waybill number';
        }

        echo json_encode($output);
    }

    //To Change Status via webhook
    public function change_status_webhook()
    {
        $_POST = (array) json_decode(file_get_contents('php://input'), TRUE);
        // echo "\nIn Portal > Change Status\n";
        // print_r($_POST);
        // die();
        
        $date = date('Y-m-d',strtotime($_POST['status_date']));
        $del_date = date('d',strtotime($_POST['status_date']));
        $awb = $_POST['awb_num'];
        $cod_data = array();
        $order_details = $this->billing_model->get_orderdetails_invoice($awb);
        // print_r($order_details);

        if(!empty($order_details))
        {
            if($order_details['billing_eligibility']=='0')
            {
                $invoice_data = array (
                    'user_id'          => $order_details['user_id'],
                    'invoice_date'     => get_billingdate($order_details['billing_cycle_dates'],$del_date),
                    'invoice_amount'   => $order_details['charges_total'],
                    'gst_amount'       => $order_details['gst_amount'],
                    'total_amount'     => $order_details['total_amount'],
                    'shipments_count'  => '1',
                    'paid_amount'      => $order_details['paid_amount'],
                    'due_amount'       => $order_details['total_amount']-$order_details['paid_amount'],
                );

                if($_POST['order_status']=='226') // If Delivered
                {
                    // Update shipment status to Delivered
                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";
                    //Calculate COD Eligible Date
                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                    //$cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                    
                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='0')
                    {
                        $sb_data = array(
                            'billing_eligibility'   => '1',
                            'billing_eligible_date' => $date,
                            'cod_status'            => '1',
                            'cod_date'              => $date,
                            'cod_eligible_date'     => $cod_edate,
                            'cod_cycle_date'        => $cod_cdate,
                            'updated_by'            => 'system'
                        );

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => $order_details['cod_amount'],
                        );
                    }
                    else
                        $sb_data = array(
                            'billing_eligibility'   => '1',
                            'billing_eligible_date' => $date,
                            'updated_by'            => 'system'
                        );
                    
                    //Insert Data invoice_accrue_ondel
                    if($this->billing_model->invoice_accrue_ondel($query_s,$sb_data,$awb,$invoice_data,$cod_data))
                    {
                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else if($_POST['order_status']=='225') //If RTO
                {
                    // Update shipment status to RTO
                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate RTO Charges & Update Amounts
                    $sb_data = $this->getdata_model->get_rtocharges($awb);

                    $sb_data['billing_eligibility']='1';
                    $sb_data['billing_eligible_date']=$date;
                    $sb_data['cod_date']  = $date;
                    $sb_data['cod_status']='3';
                    $sb_data['updated_by']='system';

                    //Insert Data invoice_accrue_onrto
                    if($this->billing_model->invoice_accrue_onrto($query_s,$sb_data,$awb,$invoice_data,$order_details['billing_type']))
                    {
                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
            }
            else if($order_details['billing_eligibility']=='1')
            {
                if($_POST['order_status']=='226' && $order_details['user_status'] != '226') // If Delivered from RTO
                {
                    // Update shipment status to Delivered
                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate Forward Charges
                    $sb_data = $this->getdata_model->get_fwdcharges($awb);

                    //Calculate COD Eligible Date
                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                    //$cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                    
                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='3')
                    {
                        $sb_data['cod_status']        = '1';
                        $sb_data['cod_eligible_date'] = $cod_edate;
                        $sb_data['cod_cycle_date']    = $cod_cdate;
                        $sb_data['cod_date']          = $date;

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => $order_details['cod_amount'],
                        );
                    }
                    
                    // print_r($sb_data);

                    $invoice_data_diff = array(
                        'user_id'        => $order_details['user_id'],
                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                    );               
    
                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                    {
                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else if($_POST['order_status']=='225' && $order_details['user_status'] != '225') // If RTO from Delivered
                {
                    // Update shipment status to RTO
                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                    //Calculate RTO Charges & Update Amounts
                    $sb_data = $this->getdata_model->get_rtocharges($awb);
                    $sb_data['cod_status']        = '3';

                    //Calculate COD Eligible & Cycle Date
                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);

                    // if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='1')
                    if($order_details['payment_mode']=='COD')
                    {
                        $sb_data['cod_eligible_date'] = '';
                        $sb_data['cod_cycle_date']    = '';
                        // $sb_data['cod_trn']        = '';
                        $sb_data['cod_date']          = $date;

                        $cod_data = array(
                            'user_id'          => $order_details['user_id'],
                            'cod_cycle_date'   => $cod_cdate,
                            'cod_amount'       => '-'.$order_details['cod_amount'],
                        );
                    }

                    $invoice_data_diff = array(
                        'user_id'        => $order_details['user_id'],
                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                    );               
    
                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                    {
                        $output['title'] = 'Congrats';
                        $output['message'] = 'Status Updated Successfully.';
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['title'] = 'Error';
                        $output['message'] = 'Some Error occurred, Try again.';
                    }
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Status uptodate.';
                }
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Invalid waybill number';
        }

        echo json_encode($output);
    }

    // For Weight Update Data Preview 
    public function preview_weightupdate()
    {
        $fileupload_res['weightupdate'] = excel_upload('weight_file','weight_update');

        if($fileupload_res['weightupdate']['title']=="Success")
        {
            // print_r($fileupload_res['pinservices']);
            list($form_data, $error_data) = read_weightupdatedata($fileupload_res['weightupdate']['message']);
            $error_preview ='';
            if(!empty($error_data))
            {
                $error_preview .= '<table id="datatable-preview" class="table table-vcenter table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Waybill #</th>
                        <th class="text-center">New Weight</th>
                        <th class="text-center">Error</th>
                    </tr>
                </thead>
                <tbody>
                    <h5><b><span class="text-danger">Found: '.count($error_data). ' errors</span>.</b></h5>';

                    foreach ($error_data as $errors)
                    {
                        $error_preview .='<tr>
                            <td class="text-center">'. $errors['waybill_number'].'</td>
                            <td class="text-center">'. $errors['billing_weight'].'</td>
                            <td class="text-center">'. $errors['error'].'</td>
                        </tr>';
                    }

                    $error_preview .='</tbody></table><form method="post" id="form_weightupdateanyway" style="display:none;" onsubmit="return false;">';
                    foreach ($form_data as $data => $data_value)
                    {
                        $error_preview .='<input type="hidden" name="data['.$data.'][waybill_number]" value="'.$data_value['waybill_number'].'" />
                        <input type="hidden" name="data['.$data.'][billing_weight]" value="'.$data_value['billing_weight'].'" />
                        <input type="hidden" name="data['.$data.'][updated_by]" value="'.$data_value['updated_by'].'" />';
                    }
                    $error_preview .='<input type="hidden" name="tracking_data" value="'.$fileupload_res['weightupdate']['message'].'"/></form>';
                    $error_preview .='<div class="col-md-12" style="margin-top:15px;">
                    <button type="button" onclick="reupload();" class="btn btn-sm btn-primary" id="reuploadbtn"><i class="fa fa-repeat"></i> Reupload</button>
                    <button type="button" onclick="saveanyway();" class="btn btn-sm btn-success" id="continuebtn"><i class="fa fa-save"></i> Skip Error(s) & Continue</button></div>';

                echo json_encode(array('message' => $error_preview), JSON_HEX_QUOT | JSON_HEX_TAG);
            }
            else
            {
                list($success_count, $error_records) = $this->billing_model->update_weight($form_data);
                $tracking_data = array(
                    'activity_type' => "weight_reconciliation",
                    'log_data' => json_encode($fileupload_res['weightupdate']['message']."<br />\\n\\nUpdated ".$success_count." Records.<br />\\n\\nError Logs".json_encode($error_records)),
                    'admin_id' => $this->session->userdata['user_session']['admin_username'],
                );
                // print_r($tracking_data);
                if($this->insertions_model->activity_logs($tracking_data))
                {
                    $output['updated'] = $success_count;
                    $output['errors'] = $error_records;
                    $output['title'] = 'Success';
                    $output['action'] = 'WeightUpdate';
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Some Error occurred, Try again.';
                }
                echo json_encode($output);
            }
        }
        else
            echo json_encode($fileupload_res['weightupdate']);
    }

    /* For Update weight excluding errors  */
    public function weightupdate()
    {
        list($success_count, $error_records) = $this->billing_model->update_weight($this->input->post('data'));
        $tracking_data = array(
            'activity_type' => "weight_reconciliation",
            'log_data' => json_encode($this->input->post('tracking_data')."<br />\\n\\nUpdated ".$success_count." Records.<br />\\n\\nError Logs".json_encode($error_records)),
            'admin_id' => $this->session->userdata['user_session']['admin_username'],
        );
        // print_r($tracking_data);
        if($this->insertions_model->activity_logs($tracking_data))
        {
            $output['updated'] = $success_count;
            $output['errors'] = $error_records;
            $output['title'] = 'Success';
            $output['action'] = 'WeightUpdate';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    //For Invoice Generation
    public function generate_invoice()
    {
        $post_data =  $this->input->post();
        if(!empty($post_data['billing_date'])) //==date('Y-m-d', strtotime("-1 day")))
        {
            $validate_billing = $this->db->where('invoice_date',$post_data['billing_date'])->where('invoice_status','2')->get('shipments_invoices')->num_rows();
            if($validate_billing > 0)
            {
                $tracking_data = array(
                    'activity_type' => "generate_invoice",
                    'log_data' => json_encode($post_data),
                    'admin_id' => $this->session->userdata['user_session']['admin_username'],
                );

                if($this->billing_model->generate_invoice($post_data['billing_date']) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = 'Invoice Generated Successfully.';
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Some Error occurred, Try again.';
                }
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = 'Invoice already generated or <b>No</b> billing for given billing date.';
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Invalid billing date.';
        }
        
        echo json_encode($output);        
    }

    /* For AddingPayment against invoice  */
    public function add_invoicepayments()
    {
        $post_data =  $this->input->post();
        $due_amt = $this->db->select('due_amount')->where('px_invoice_number',$post_data['invoice_number'])
        ->where('user_id',$post_data['user_id'])->get('shipments_invoices')->row();

        // echo $due_amt->due_amount;

        $this->form_validation->set_rules('invoice_number', 'Invoice #', 'required|trim');
        $this->form_validation->set_rules('payment_amount', 'Payment Amount', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/i]|less_than_equal_to['.$due_amt->due_amount.']');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required');
        $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');

        $this->form_validation->set_message('less_than_equal_to', 'The %s should be less than or equal to due amount.');

        switch($post_data['payment_mode'])
        {
            case "cheque":
                $this->form_validation->set_rules('transaction_id', 'Cheque number', 'required|trim');
                break;
            case "cod_adjustment":
                $this->form_validation->set_rules('transaction_id', 'COD TRN', 'required|trim');
                break;
            case "creditnote":
                $this->form_validation->set_rules('transaction_id', 'CN number', 'required|trim');
                break;
            case "netbanking":
                $this->form_validation->set_rules('transaction_id', 'UTR Number', 'required|trim');
                break;
            case "tds":
                $this->form_validation->set_rules('transaction_id', 'TAN', 'required|trim');
                break;
        }

        if($this->form_validation->run() == TRUE)
        {
            // print_r($post_data);
            $user_tan = "";
            $form_data_pay = array(
                'user_id'           => $post_data['user_id'],
                'invoice_number'    => $post_data['invoice_number'],
                'payment_date'      => date('Y-m-d',strtotime($post_data['payment_date'])),
                'payment_amount'    => $post_data['payment_amount'],
                'payment_mode'      => strtoupper(str_replace('_',' ',$post_data['payment_mode'])),
                'payment_remark'    => $post_data['payment_remark'],
                'added_by' => $this->session->userdata['user_session']['admin_username'],
            );

            if($post_data['payment_mode'] == "tds" && empty($post_data['tan_number']))
                $user_tan = $post_data['transaction_id'];
            else if($post_data['payment_mode'] != "tds")
                $form_data_pay['transaction_id'] = 	$post_data['transaction_id'];

            $tracking_data = array(
                'activity_type' => "add_payment",
                'log_data' => json_encode($post_data),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->billing_model->add_invoicepayment($form_data_pay,$user_tan) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Payment added successfully.';
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = 'Some Error occurred, Try again.';
            }
            echo json_encode($output);
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = validation_errors();
            echo json_encode($output);
        }
    }

    //For COD Generation
    public function generate_cod()
    {
        $post_data =  $this->input->post();
        if(!empty($post_data['cod_cycle_date'])) //==date('Y-m-d', strtotime("-1 day")))
        {
            $validate_cod = $this->db->where('cod_cycle_date',$post_data['cod_cycle_date'])->where('cod_status','3')->get('shipments_cods')->num_rows();
            if($validate_cod > 0)
            {
                $tracking_data = array(
                    'activity_type' => "generate_cod",
                    'log_data' => json_encode($post_data),
                    'admin_id' => $this->session->userdata['user_session']['admin_username'],
                );

                if($this->billing_model->generate_cod($post_data['cod_cycle_date']) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = 'COD Generated Successfully.';
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Some Error occurred, Try again.';
                }
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = 'COD already generated or <b>No</b> COD for given date.';
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Invalid COD date.';
        }
        
        echo json_encode($output);        
    }

    public function reset_postpaidbalance()
    {
        if(strtoupper($this->session->userdata('user_session')['role_name']) == 'SUPERADMIN' || $this->permissions_model->check_permission('reset_postpaidbalance'))
        {
            // print_r($this->input->post());
            $tracking_data = array(
                'activity_type' => "rectify_postpaid_balance",
                'log_data'      => json_encode($this->input->post()),
                'admin_id'      => $this->session->userdata['user_session']['admin_username'],
            );

            $result=$this->db->select('main_balance,total_balance')->where('user_id',$this->input->post('record_id'))->get('users_balances')->row();
            
            if($result->total_balance < 0)
            {
                if($this->billing_model->reset_postpaidbalance($this->input->post('record_id')) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['message'] = 'Balance rectified successfully.';
                    $output['title'] = 'Congrats';
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Some Error occurred, Try again.';
                }
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = "Balance is up-to-date.";
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Oops, you dont have access for this.';
        }
        echo json_encode($output);
    }

    public function manualinvoice()
    {
        // _print_r($_POST,1);
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
        $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'required|numeric|trim');
        $this->form_validation->set_rules('gst', 'GST', 'trim');
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'user_id'           => $this->input->post('username'),
                'invoice_date'      => date('Y-m-d', strtotime($this->input->post('invoice_date'))),
                'invoice_amount'    => $this->input->post('invoice_amount'),
                'gst_amount'        => $this->input->post('gst'),
                'total_amount'      => $this->input->post('total_amount'),
                'shipments_count'   => '0',
                'paid_amount'       => '0',
                'due_amount'        => $this->input->post('total_amount'),
                'invoice_status'    => '0',
            );

            // _print_r($form_data,1);

            $tracking_data = array(
                'activity_type' => "manual_invoice",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );

            if($this->billing_model->manualinvoice($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Manual invoice saved successfully.';
            }
            else
            {
                $output['error'] = true;
                $output['title'] = 'Error';
                $output['message'] = 'Some Error occurred, Try again.';
            }
            echo json_encode($output);
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = validation_errors();
            echo json_encode($output);
        }
    }

    public function change_status_bulk()
    {
        // $ExcelReportData=[];
        $fileupload_res['billingStatus'] = excel_upload('awb_file','billing_status');
        if($fileupload_res['billingStatus']['title']=="Success")
        {
            try
            {
                // $object = PHPExcel_IOFactory::load($fileupload_res['billingStatus']['message']);

                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fileupload_res['billingStatus']['message']);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $object = $reader->load($fileupload_res['billingStatus']['message']);
                foreach($object->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestDataRow();
                    for($row=2; $row<=min($highestRow,202); $row++)
                    {
                        $date = date('Y-m-d');
                        $del_date = date('d');
                        $awb = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $order_status = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $cod_data = [];
                        $order_details = $this->billing_model->get_orderdetails_invoice($awb);

                        if(!empty($order_details))
                        {
                            if($order_details['billing_eligibility']=='0')
                            {
                                // _print_r($order_details,1);
                                $invoice_data = array (
                                    'user_id'          => $order_details['user_id'],
                                    'invoice_date'     => get_billingdate($order_details['billing_cycle_dates'],$del_date),
                                    'invoice_amount'   => $order_details['charges_total'],
                                    'gst_amount'       => $order_details['gst_amount'],
                                    'total_amount'     => $order_details['total_amount'],
                                    'shipments_count'  => '1',
                                    'paid_amount'      => $order_details['paid_amount'],
                                    'due_amount'       => $order_details['total_amount']-$order_details['paid_amount'],
                                );

                                if($order_status=='D') // If Delivered
                                {
                                    // Update shipment status to Delivered
                                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";
                                    //Calculate COD Eligible Date
                                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                                    //$cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                                    
                                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='0')
                                    {
                                        $sb_data = array(
                                            'billing_eligibility'   => '1',
                                            'billing_eligible_date' => $date,
                                            'cod_status'            => '1',
                                            'cod_date'              => $date,
                                            'cod_eligible_date'     => $cod_edate,
                                            'cod_cycle_date'        => $cod_cdate,
                                            'updated_by'            => 'system'
                                        );

                                        $cod_data = array(
                                            'user_id'          => $order_details['user_id'],
                                            'cod_cycle_date'   => $cod_cdate,
                                            'cod_amount'       => $order_details['cod_amount'],
                                        );
                                    }
                                    else
                                        $sb_data = array(
                                            'billing_eligibility'   => '1',
                                            'billing_eligible_date' => $date,
                                            'updated_by'            => 'system'
                                        );
                                    
                                    //Insert Data invoice_accrue_ondel
                                    if($this->billing_model->invoice_accrue_ondel($query_s,$sb_data,$awb,$invoice_data,$cod_data))
                                    {
                                        //Inserting Billing Logs
                                        $shipments_billing_logs = array(
                                            'waybill_number'    => $awb,
                                            'billing_status'    => '226',
                                            'billing_date'      => $date,
                                            'billing_remark'    => 'D',
                                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                                        );
                                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Status Updated Successfully.';
                                    }
                                    else
                                    {
                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Some Error occurred, Try again.';
                                    }
                                }
                                else if($order_status=='R') //If RTO
                                {
                                    // Update shipment status to RTO
                                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                                    //Calculate RTO Charges & Update Amounts
                                    $sb_data = $this->getdata_model->get_rtocharges($awb);

                                    $sb_data['billing_eligibility']='1';
                                    $sb_data['billing_eligible_date']=$date;
                                    $sb_data['cod_date']  = $date;
                                    $sb_data['cod_status']='3';
                                    $sb_data['updated_by']='system';

                                    //Insert Data invoice_accrue_onrto
                                    if($this->billing_model->invoice_accrue_onrto($query_s,$sb_data,$awb,$invoice_data,$order_details['billing_type']))
                                    {
                                        //Inserting Billing Logs
                                        $shipments_billing_logs = array(
                                            'waybill_number'    => $awb,
                                            'billing_status'    => '225',
                                            'billing_date'      => $date,
                                            'billing_remark'    => 'R',
                                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                                        );
                                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Status Updated Successfully.';
                                    }
                                    else
                                    {
                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Some Error occurred, Try again.';
                                    }
                                }
                                else
                                {
                                    $output['waybill'] = $awb;
                                    $output['message'] = 'Incorrect Billing Status {'.$order_status.'}. Pls Enter correct value';
                                }
                            }
                            else if($order_details['billing_eligibility']=='1')
                            {
                                if($order_status=='D' && $order_details['user_status'] != '226') // If Delivered from RTO
                                {
                                    // Update shipment status to Delivered
                                    $query_s = "Update shipments set system_status ='106',user_status='226',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                                    //Calculate Forward Charges
                                    $sb_data = $this->getdata_model->get_fwdcharges($awb);

                                    //Calculate COD Eligible Date
                                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                                    // $cod_cdate = get_codcycledate($order_details['cod_cycle_dates'],date('d',strtotime($cod_edate)));
                                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);
                                    
                                    if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='3')
                                    {
                                        $sb_data['cod_status']        = '1';
                                        $sb_data['cod_eligible_date'] = $cod_edate;
                                        $sb_data['cod_cycle_date']    = $cod_cdate;
                                        $sb_data['cod_date']          = $date;

                                        $cod_data = array(
                                            'user_id'          => $order_details['user_id'],
                                            'cod_cycle_date'   => $cod_cdate,
                                            'cod_amount'       => $order_details['cod_amount'],
                                        );
                                    }
                                    
                                    // print_r($sb_data);

                                    $invoice_data_diff = array(
                                        'user_id'        => $order_details['user_id'],
                                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                                    );               
                    
                                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                                    {
                                        //Inserting Billing Logs
                                        $shipments_billing_logs = array(
                                            'waybill_number'    => $awb,
                                            'billing_status'    => '226',
                                            'billing_date'      => $date,
                                            'billing_remark'    => 'RD',
                                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                                        );
                                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);


                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Status Updated Successfully.';
                                    }
                                    else
                                    {
                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Some Error occurred, Try again.';
                                    }
                                }
                                else if($order_status=='R' && $order_details['user_status'] != '225') // If RTO from Delivered
                                {
                                    // Update shipment status to RTO
                                    $query_s = "Update shipments set system_status = '115',user_status='225',updated_by='system' where system_status<>'107' AND waybill_number = '$awb'";

                                    //Calculate RTO Charges & Update Amounts
                                    $sb_data = $this->getdata_model->get_rtocharges($awb);
                                    $sb_data['cod_status']        = '3';

                                    //Calculate COD Eligible & Cycle Date
                                    $cod_edate = date('Y-m-d', strtotime($date. ' + '.$order_details['cod_gap'].'days'));
                                    $cod_cdate = get_codcycledate_alt($order_details['cod_cycle_dates'],$cod_edate);

                                    // if($order_details['payment_mode']=='COD' && $order_details['cod_status']=='1')
                                    if($order_details['payment_mode']=='COD')
                                    {
                                        $sb_data['cod_eligible_date'] = '';
                                        $sb_data['cod_cycle_date']    = '';
                                        // $sb_data['cod_trn']           = '';
                                        $sb_data['cod_date']          = $date;

                                        $cod_data = array(
                                            'user_id'          => $order_details['user_id'],
                                            'cod_cycle_date'   => $cod_cdate,
                                            'cod_amount'       => '-'.$order_details['cod_amount'],
                                        );
                                    }

                                    $invoice_data_diff = array(
                                        'user_id'        => $order_details['user_id'],
                                        'difference_amt' => $sb_data['charges_total'] - $order_details['charges_total'],
                                        'difference_gst' => $sb_data['gst_amount'] - $order_details['gst_amount'],
                                        'difference_tot' => $sb_data['total_amount'] - $order_details['total_amount'],
                                    );               
                    
                                    if($this->billing_model->status_update_delrto($query_s,$sb_data,$awb,$invoice_data_diff,$cod_data,$order_details['billing_type']))
                                    {
                                        //Inserting Billing Logs
                                        $shipments_billing_logs = array(
                                            'waybill_number'    => $awb,
                                            'billing_status'    => '225',
                                            'billing_date'      => $date,
                                            'billing_remark'    => 'DR',
                                            'billed_by'         => $this->session->userdata['user_session']['admin_username']
                                        );
                                        $this->db->insert('shipments_billing_logs', $shipments_billing_logs);

                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Status Updated Successfully.';
                                    }
                                    else
                                    {
                                        $output['waybill'] = $awb;
                                        $output['message'] = 'Some Error occurred, Try again.';
                                    }
                                }
                                else if($order_status == 'R' || $order_status == 'D')
                                {
                                    $output['waybill'] = $awb;
                                    $output['message'] = 'Status already uptodate.';
                                }
                                else
                                {
                                    $output['waybill'] = $awb;
                                    $output['message'] = 'Incorrect Billing Status {'.$order_status.'}. Enter correct value';
                                }
                            }
                        }
                        else
                        {
                            $output['waybill'] = $awb;
                            $output['message'] = 'Invalid waybill number';
                        }

                        $ExcelReportData[] = $output;
                    }
                }
            }
            catch(Exception $e)
            {
                $output['waybill'] = 'Error importing file';
                $output['message']  = pathinfo($fileupload_res['billingStatus']['message'], PATHINFO_BASENAME).'": '.$e->getMessage();

                $ExcelReportData[] = $output;
            }

            $filename = 'ChangeStatusReport.xlsx';
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $table_columns = array("Waybill Number","Remark");
            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($ExcelReportData as $data)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount,$data['waybill']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $data['message']);
                $rowCount++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
        }
        else
        {
            $filename = 'Error.xlsx';
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $fileupload_res['billingStatus']['message']);
        }

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        //Clear the buffer, to avoid garbled 
        if (ob_get_contents())
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

}
?>