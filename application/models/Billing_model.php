<?php
class Billing_model extends CI_Model
{
    // For Prepaid User Details from admin
    public function get_prepaiduser($record_id)
    {
        $query=$this->db->select('U.user_id,fullname,business_name,main_balance,promo_balance,total_balance')
                        ->JOIN('users_balances UB', 'U.user_id=UB.user_id')
                        ->where('billing_type','prepaid')
                        ->where('username',$record_id)
                        ->get('users U');
        // print_r($this->db->last_query());
        if($query->num_rows())
            return $query->row_array();
        else
            return '0';
    }

    /* For Adding/Deducting UserBalance from admin*/
    public function manage_balance($formdata_txn,$formdata_bal,$userid)
    {
        $this->db->trans_start();
        $this->db->insert('users_transactions',$formdata_txn);
        $this->db->where('user_id',$userid)->update('users_balances',$formdata_bal);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    // For gettng balance details for Manage Balance in Admin
    public function get_balance_order_details($awb)
    {
        $query=$this->db->select('S.user_id,waybill_number,shipment_id,main_balance,promo_balance,total_balance')
                        ->JOIN('users_balances UB', 'S.user_id=UB.user_id')
                        ->where('waybill_number',$awb)
                        ->get('shipments S');
        // print_r($this->db->last_query());
        if($query->num_rows())
            return $query->row_array();
        else
            return $query->result_array();
    }

    //For getting order details on status change
    public function get_orderdetails_invoice($awb)
    {
        $query_order = $this->db->select('S.user_id,billing_type,billing_cycle_dates,cod_cycle_dates,payment_mode,billing_eligibility,SB.cod_amount,cod_status,cod_gap,SB.charges_total,SB.gst_amount,SB.total_amount,SB.paid_amount,U.billing_type,S.user_status')
        ->JOIN('shipments_billing SB','S.waybill_number=SB.waybill_number','LEFT')
        ->JOIN('users U','S.user_id=U.user_id','LEFT')
        ->JOIN('master_billing_cycle MBC','U.billing_cycle_id=MBC.billing_cycle_id','LEFT')
        ->JOIN('master_cod_cycle MCC','U.cod_cycle_id=MCC.cod_cycle_id','LEFT')
        ->where('S.waybill_number',$awb)->where('SB.billing_eligibility<>','2')->where('S.system_status<>','107')->get('shipments S');

        if($query_order->num_rows()>0)
            return $query_order->row_array();
        else
            return $query_order->result_array();
    }

    public function change_status($shipment_query,$sbilling_data,$awbn,$invoice_data)
    {
        // echo "Query - ".$shipment_query."\nAWB".$awbn."\nBilling Data\n";
        // print_r($sbilling_data);

        die();

        


        $this->db->trans_start();
        
        $this->db->query($shipment_query);

        $check_invoice = $this->billing_model->check_invoice($invoice_data['user_id']);
        
        if(!empty($check_invoice))
            echo "Update Query";
            //Prepare Update query for Invoice & return invoice_number
        else //Prepare insert query for Invoice & return invoice_number
            $this->db->insert('shipments_invoices',$invoice_data);
        
        $invoice_number=$this->db->insert_id();
        $sbilling_data['invoice_number'] = $invoice_number;
        $sbilling_data['billing_date'] = $invoice_data['invoice_date'];

        if(!empty($cod_data))
            echo "Execute COD query";

        $this->db->where('waybill_number',$awbn)->update('shipments_billing',$sbilling_data);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    
    public function invoice_accrue_ondel($shipment_query,$sbilling_data,$awbn,$invoice_data,$cod_data)
    {
        $this->db->trans_start();
        $this->db->query($shipment_query);

        $check_invoice = $this->billing_model->check_invoice($invoice_data['user_id'],$invoice_data['invoice_date']);
        if(!empty($check_invoice))
        {
            $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['invoice_amount'],false)
            ->set('gst_amount','gst_amount + '.$invoice_data['gst_amount'],false)
            ->set('total_amount','total_amount + '.$invoice_data['total_amount'],false)
            ->set('shipments_count','shipments_count + '.$invoice_data['shipments_count'],false)
            ->set('paid_amount','paid_amount + '.$invoice_data['paid_amount'],false)
            ->set('due_amount','due_amount + '.$invoice_data['due_amount'],false)
            ->where('px_invoice_number',$check_invoice['px_invoice_number'])
            ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
            $sbilling_data['invoice_number'] = $check_invoice['px_invoice_number'];
            $sbilling_data['billing_date']   = $check_invoice['invoice_date'];
        }
        else //Prepare insert query for Invoice & return invoice_number
        {
            $this->db->insert('shipments_invoices',$invoice_data);
            $invoice_number=$this->db->insert_id();
            $sbilling_data['invoice_number'] = $invoice_number;
            $sbilling_data['billing_date'] = $invoice_data['invoice_date'];
        }
        
        if(!empty($cod_data))
        {
            $check_cod = $this->billing_model->check_cod($cod_data['user_id'],$cod_data['cod_cycle_date']);
            if(!empty($check_cod))
            {
                $this->db->set('cod_amount','cod_amount + '.$cod_data['cod_amount'],false)
                ->where('cod_id',$check_cod['cod_id'])
                ->where('user_id',$cod_data['user_id'])->update('shipments_cods');
                $sbilling_data['cod_trn'] = $check_cod['cod_id'];
                $sbilling_data['previous_codtrn'] = $check_cod['cod_id'];
            }
            else //Prepare insert query for COD & return cod_id
            {
                $this->db->insert('shipments_cods',$cod_data);
                $cod_id=$this->db->insert_id();
                $sbilling_data['cod_trn'] = $cod_id;
                $sbilling_data['previous_codtrn'] = $cod_id;
            }
        }

        $this->db->where('waybill_number',$awbn)->where('user_id',$invoice_data['user_id'])->update('shipments_billing',$sbilling_data);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    public function invoice_accrue_onrto($shipment_query,$sbilling_data,$awbn,$invoice_data,$client_type)
    {
        if($client_type=='prepaid')
        {
            $difference_tot = $sbilling_data['total_amount'] - $invoice_data['total_amount'];

            $invoice_data['invoice_amount'] = $sbilling_data['charges_total'];
            $invoice_data['gst_amount']     = $sbilling_data['gst_amount'];
            $invoice_data['total_amount']   = $sbilling_data['total_amount'];
            $invoice_data['paid_amount']    = $invoice_data['paid_amount']+$difference_tot;
            $sbilling_data['paid_amount']   = $invoice_data['paid_amount'];
            $invoice_data['due_amount']     = $invoice_data['total_amount']-$invoice_data['paid_amount'];
        }
        else
        {
            $invoice_data['invoice_amount'] = $sbilling_data['charges_total'];
            $invoice_data['gst_amount']     = $sbilling_data['gst_amount'];
            $invoice_data['total_amount']   = $sbilling_data['total_amount'];
            $invoice_data['due_amount']     = $sbilling_data['total_amount'] - $invoice_data['paid_amount'];
        }

        $this->db->trans_start();
        $this->db->query($shipment_query);
        $check_invoice = $this->billing_model->check_invoice($invoice_data['user_id'],$invoice_data['invoice_date']);
        if(!empty($check_invoice))
        {
            $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['invoice_amount'],false)
            ->set('gst_amount','gst_amount + '.$invoice_data['gst_amount'],false)
            ->set('total_amount','total_amount + '.$invoice_data['total_amount'],false)
            ->set('shipments_count','shipments_count + '.$invoice_data['shipments_count'],false)
            ->set('paid_amount','paid_amount + '.$invoice_data['paid_amount'],false)
            ->set('due_amount','due_amount + '.$invoice_data['due_amount'],false)
            ->where('px_invoice_number',$check_invoice['px_invoice_number'])
            ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
            $sbilling_data['invoice_number'] = $check_invoice['px_invoice_number'];
            $sbilling_data['billing_date']   = $check_invoice['invoice_date'];
        }
        else //Prepare insert query for Invoice & return invoice_number
        {
            $this->db->insert('shipments_invoices',$invoice_data);
            $invoice_number=$this->db->insert_id();
            $sbilling_data['invoice_number'] = $invoice_number;
            $sbilling_data['billing_date'] = $invoice_data['invoice_date'];
        }

        if($client_type=='prepaid')
        {
            $user_txn_data = user_transaction_data($awbn,$difference_tot,'rto_charges');
            $this->db->insert('users_transactions',$user_txn_data);
            $this->db->set('main_balance','main_balance -'.$difference_tot,false)
            ->set('total_balance','total_balance -'.$difference_tot,false)
            ->where('user_id',$invoice_data['user_id'])->update('users_balances');
        }

        $this->db->where('waybill_number',$awbn)->where('user_id',$invoice_data['user_id'])->update('shipments_billing',$sbilling_data);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);

        // echo "Query - ".$shipment_query."\nAWB".$awbn."\nClient\n".$client_type."\nBilling Data\n";
        // print_r($sbilling_data);
        // echo "\nInvoice Data\n";
        // print_r($invoice_data);
        // echo "Diff Amt;".$difference_tot;   
    }

    public function status_update_delrto($shipment_query,$sbilling_data,$awbn,$invoice_data,$cod_data,$client_type)
    {
        $this->db->trans_start();
        $this->db->query($shipment_query);
        //Update Invoice - Add Difference Amounts
        $check_invoice = $this->billing_model->check_invoice($invoice_data['user_id']);

        if($client_type == "prepaid")
        {
            $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
            ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
            ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
            ->set('paid_amount','paid_amount + '.$invoice_data['difference_tot'],false)
            ->where('px_invoice_number',$check_invoice['px_invoice_number'])
            ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
            
            $sbilling_data['paid_amount'] = $sbilling_data['total_amount'];

            $user_txn_data = user_transaction_data($awbn,$invoice_data['difference_tot'],'rto_charges');
            $this->db->insert('users_transactions',$user_txn_data);
            $this->db->set('main_balance','main_balance -'.$invoice_data['difference_tot'],false)
            ->set('total_balance','total_balance -'.$invoice_data['difference_tot'],false)
            ->where('user_id',$invoice_data['user_id'])->update('users_balances');
        }
        else
        {
            $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
            ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
            ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
            ->set('due_amount','due_amount + '.$invoice_data['difference_tot'],false)
            ->where('px_invoice_number',$check_invoice['px_invoice_number'])
            ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
        }
        
        if(!empty($cod_data))
        {
            $accrue_cod = $this->db->select('cod_trn')->where('waybill_number',$awbn)->where('SB.user_id',$cod_data['user_id'])->where('SC.cod_status','3')->join('shipments_cods SC','SB.cod_trn = SC.cod_id')->get('shipments_billing SB')->row_array();

            if(!empty($accrue_cod['cod_trn']))
            {
                $this->db->set('cod_amount','cod_amount + '.$cod_data['cod_amount'],false)
                ->where('cod_id',$accrue_cod['cod_trn'])
                ->where('user_id',$cod_data['user_id'])->update('shipments_cods');
                // $sbilling_data['cod_trn'] = $cod_data['cod_amount'] > 0 ? $accrue_cod['cod_trn'] : '';
                $sbilling_data['cod_trn'] = $accrue_cod['cod_trn'];
            }
            else
            {
                $check_cod = $this->billing_model->check_cod($cod_data['user_id'],$sbilling_data['cod_cycle_date']);
                if(!empty($check_cod))
                {
                    $this->db->set('cod_amount','cod_amount + '.$cod_data['cod_amount'],false)
                    ->where('cod_id',$check_cod['cod_id'])
                    ->where('user_id',$cod_data['user_id'])->update('shipments_cods');
                    $sbilling_data['cod_trn'] = $check_cod['cod_id'];
                    // $sbilling_data['cod_trn'] = $cod_data['cod_amount'] > 0 ? $check_cod['cod_id'] : '';
                }
                else //Prepare insert query for COD & return cod_id
                {
                    $this->db->insert('shipments_cods',$cod_data);
                    $cod_id=$this->db->insert_id();
                    $sbilling_data['cod_trn'] = $cod_id;
                }
            }
        }

        $this->db->where('waybill_number',$awbn)->where('user_id',$invoice_data['user_id'])->update('shipments_billing',$sbilling_data);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    public function check_invoice($user_id,$invoice_date='')
    {
        // $query_invoice = $this->db->select('px_invoice_number,invoice_date')->where('user_id',$user_id)->where('invoice_date',$invoice_date)->where('invoice_status','2')->get('shipments_invoices');

        if(!empty($invoice_date))
        {
            $query_invoice = $this->db->select('px_invoice_number,invoice_date')->where('user_id',$user_id)->where('invoice_date',$invoice_date)->where('invoice_status','2')->get('shipments_invoices');
            if($query_invoice->num_rows()>0)
                return $query_invoice->row_array();
            else
                return $query_invoice->result_array();
        }
        else
        {
            $query_invoice = $this->db->select('px_invoice_number,invoice_date')->where('user_id',$user_id)->where('invoice_status','2')->get('shipments_invoices');
            if($query_invoice->num_rows()>0)
                return $query_invoice->row_array();
            else
                return $query_invoice->result_array();
        }
    }

    public function check_cod($user_id,$cod_cdate='')
    {
        // $query_cod = $this->db->select('cod_id')->where('user_id',$user_id)->where('cod_cycle_date',$cod_cdate)->where('cod_status','3')->get('shipments_cods');

        if(!empty($cod_cdate))
        {
            $query_cod = $this->db->select('cod_id')->where('user_id',$user_id)->where('cod_cycle_date',$cod_cdate)->where('cod_status','3')->get('shipments_cods');
            if($query_cod->num_rows()>0)
                return $query_cod->row_array();
            else
                return $query_cod->result_array();
        }
        else
        {
            $query_cod = $this->db->select('cod_id')->where('user_id',$user_id)->where('cod_status','3')->get('shipments_cods');
            if($query_cod->num_rows()>0)
                return $query_cod->row_array();
            else
                return $query_cod->result_array();
        }
    }

    public function update_weight($form_data)
    {
        $success_count=0;
        $error_data = array();
        $invoice_data = array();

        foreach($form_data as $record)
        {
            //Resetting Invoice Data for every AWB
            $invoice_data = array(
                'user_id'           => '',
                'difference_amt'    => '0',
                'difference_gst'    => '0',
                'difference_tot'    => '0',
            );
            
            //Query to get AWB is valid & not billed
            $query_shipment = $this->db->query("SELECT EXISTS(SELECT * FROM shipments where waybill_number='".$record['waybill_number']."' AND system_status <>'107') as s_data")->row_array();

            $query_shipmentbill = $this->db->query("SELECT EXISTS(SELECT * FROM shipments_billing where waybill_number='".$record['waybill_number']."' AND billing_eligibility <>'2') as sb_data")->row_array();

            if($query_shipment['s_data'] && $query_shipmentbill['sb_data']) // Checking if AWB is valid
            {
                $query_wt = $this->db->select('invoice_number,billing_date,billing_eligibility,billing_weight,weight_fixed')->where('waybill_number',$record['waybill_number'])->get('shipments_billing')->row_array();

                if($query_wt['weight_fixed']=='0') // Check if submitting weight is fixed or not.
                {
                    // Check if submitting weight more than current wweight
                    if($record['billing_weight'] > $query_wt['billing_weight'] && !empty($record['billing_weight']))
                    {
                        $query_status = $this->db->select('system_status')->where('waybill_number',$record['waybill_number'])->get('shipments')->row_array();

                        $order_details = $this->billing_model->get_orderdetails_invoice($record['waybill_number']);

                        if($query_status['system_status']!='115')
                        {
                            //Get Forward Charges
                            $update_data = $this->getdata_model->get_fwdcharges($record['waybill_number'],$record['billing_weight']);
                            $update_data['billing_weight']=$record['billing_weight'];
                            if($order_details['billing_type'] == "prepaid")
                                $update_data['paid_amount'] = $update_data['total_amount'];
                            $update_data['updated_by']=$this->session->userdata['user_session']['admin_username'];                            
                        }
                        else if($query_status['system_status']=='115')
                        {
                            //Get RTO Charges
                            $update_data = $this->getdata_model->get_rtocharges($record['waybill_number'],$record['billing_weight']);
                            $update_data['billing_weight']=$record['billing_weight'];
                            if($order_details['billing_type'] == "prepaid")
                                $update_data['paid_amount'] = $update_data['total_amount'];
                            $update_data['updated_by']=$this->session->userdata['user_session']['admin_username'];
                        }
                        

                        if(!empty($query_wt['invoice_number']) && !empty($query_wt['billing_date']) && $query_wt['billing_eligibility'] == '1')
                        {
                            $invoice_data['user_id']        = $order_details['user_id'];
                            $invoice_data['difference_amt'] = $update_data['charges_total'] - $order_details['charges_total'];
                            $invoice_data['difference_gst'] = $update_data['gst_amount'] - $order_details['gst_amount'];
                            $invoice_data['difference_tot'] = $update_data['total_amount'] - $order_details['total_amount'];
                        }

                        $this->db->trans_start();
                        if($invoice_data['difference_tot'] != 0)
                        {
                            if($order_details['billing_type'] == "prepaid")
                            {
                                $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
                                ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
                                ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
                                ->set('paid_amount','paid_amount + '.$invoice_data['difference_tot'],false)
                                ->where('px_invoice_number',$query_wt['invoice_number'])
                                ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');

                                $user_txn_data = user_transaction_data($record['waybill_number'],$invoice_data['difference_tot'],'wtupdate_charges');
                                $this->db->insert('users_transactions',$user_txn_data);
                                $this->db->set('main_balance','main_balance -'.$invoice_data['difference_tot'],false)
                                ->set('total_balance','total_balance -'.$invoice_data['difference_tot'],false)
                                ->where('user_id',$invoice_data['user_id'])->update('users_balances');
                            }
                            else
                            {
                                $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
                                ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
                                ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
                                ->set('due_amount','due_amount + '.$invoice_data['difference_tot'],false)
                                ->where('px_invoice_number',$query_wt['invoice_number'])
                                ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
                            }
                        }
                        $this->db->where('waybill_number',$record['waybill_number'])->update('shipments_billing',$update_data);
                        $this->db->trans_complete();
                        // $this->db->trans_status() === TRUE ? $success_count++  : '';
                        $success_count++;
                    }
                    else
                        $error_data[] = array(
                            'waybill' => $record['waybill_number'],
                            'weight'  => $record['billing_weight'],
                            'error'   => 'New weight is less than/equal to set weight or invalid.'
                        );
                }
                else
                    $error_data[] = array(
                        'waybill' => $record['waybill_number'],
                        'weight'  => $record['billing_weight'],
                        'error'   => 'Weight is fixed & cannot be updated.'
                    );
            }
            else
                $error_data[] = array(
                    'waybill' => $record['waybill_number'],
                    'weight'  => $record['billing_weight'],
                    'error'   => 'AWB is billed or invalid'
                );
        }
        return array($success_count, $error_data);
    }

    public function generate_invoice($invoice_date)
    {
        $query_sinvoice_update = "UPDATE shipments_invoices SET invoice_status = '0' WHERE invoice_date = '$invoice_date' AND invoice_status = '2'";

        $query_sbilling_update = "UPDATE shipments_billing SET billing_eligibility = '2' WHERE invoice_number IN (SELECT px_invoice_number FROM shipments_invoices WHERE invoice_status = '0' AND `invoice_date`='$invoice_date') AND billing_date = '$invoice_date'";

        // $query_shipment_update = "UPDATE shipments SET system_status = '107' WHERE waybill_number IN (SELECT waybill_number FROM shipments_billing WHERE invoice_number IN (SELECT px_invoice_number FROM shipments_invoices WHERE invoice_status = '0' AND invoice_date='$invoice_date')) AND shipment_id IN (SELECT shipment_id from shipments_billing WHERE billing_eligibility = '2')";

        $query_shipment_update = "UPDATE shipments SET system_status = '107' WHERE shipment_id IN (SELECT shipment_id from shipments_billing WHERE billing_eligibility = '2' AND billing_date='$invoice_date')";

        //Mark prepaid users invoice to paid, if balance > 0
        $query_ppdinv_paid = "UPDATE shipments_invoices SI JOIN users U on SI.user_id=U.user_id JOIN users_balances UB ON SI.user_id=UB.user_id SET `invoice_status` = '1' WHERE invoice_status='0' AND billing_type='prepaid' AND total_balance > '0'";

        // echo $query_sinvoice_update."\n".$query_sbilling_update."\n".$query_shipment_update;
        $this->db->trans_start();
            $this->db->query($query_sinvoice_update);
            $sinvoice = $this->db->affected_rows();
            $this->db->query($query_sbilling_update);
            $sbilling = $this->db->affected_rows();
            $this->db->query($query_shipment_update);
            $shipment = $this->db->affected_rows();
            $this->db->query($query_ppdinv_paid);
            $mark_ppdinvoice_paid = $this->db->affected_rows();
        // $this->db->trans_complete();
            
        // echo "InvoiceRows= ".$sinvoice."Sbilling Rows= ".$sbilling."Shipment Rows= ".$shipment."Invoices Paid= ".$mark_ppdinvoice_paid;
        if ($this->db->trans_status() === FALSE || $sinvoice == 0 || $sbilling==0 || $shipment==0 || $sbilling != $shipment)
        {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
        // return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    /* For AddingPayment against invoice*/
    public function add_invoicepayment($form_data_pay,$user_tan="")
    {
        $this->db->trans_start();
            $this->db->insert('invoice_payments',$form_data_pay);

            $this->db->set('paid_amount','paid_amount + '.$form_data_pay['payment_amount'],false)
            ->set('due_amount','due_amount - '.$form_data_pay['payment_amount'],false)
            ->set('invoice_status',"IF(due_amount='0','1','0')",false)
            ->where('px_invoice_number',$form_data_pay['invoice_number'])
            ->where('user_id',$form_data_pay['user_id'])->update('shipments_invoices');

            if($user_tan!="")
                $this->db->set('tan_number',$user_tan)->where('user_id',$form_data_pay['user_id'])->update('users_kyc');

        if ($this->db->trans_status() === FALSE)
        {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function generate_cod($cod_date)
    {
        $query_scods_update = "UPDATE shipments_cods SET cod_status = '0' WHERE cod_cycle_date = '$cod_date' AND cod_status = '3'";

        $query_sbilling_update = "UPDATE shipments_billing SET cod_status = '2' WHERE cod_trn IN (SELECT cod_id FROM shipments_cods WHERE cod_status = '0' AND `cod_cycle_date`='$cod_date') AND cod_cycle_date = '$cod_date'";

        // echo $query_sinvoice_update."\n".$query_sbilling_update."\n".$query_shipment_update;
        $this->db->trans_start();
            $this->db->query($query_scods_update);
            $scods = $this->db->affected_rows();
            $this->db->query($query_sbilling_update);
            $sbilling = $this->db->affected_rows();
        // $this->db->trans_complete();

        // echo "InvoiceRows= ".$sinvoice."Sbilling Rows= ".$sbilling."Shipment Rows= ".$shipment;
        if ($this->db->trans_status() === FALSE || $scods == 0 || $sbilling==0)
        {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
        // return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    public function reset_postpaidbalance($user_id)
    {
        $userBalance = array(
            'main_balance'   => '0',
            'total_balance'  => '0',
            'updated_by'     => $this->session->userdata['user_session']['admin_username']
        );

        return $this->db->where('user_id',$user_id)->update('users_balances',$userBalance);
    }

    public function manualinvoice($form_data)
    {
        // _print_r($_POST,1);
        return $this->db->insert('shipments_invoices',$form_data);
    }

    public function update_weight_request($form_data)
    {
        $success_count=0;
        $error_data = array();
        $invoice_data = array();
        $invoice_data = array(
            'user_id'           => '',
            'difference_amt'    => '0',
            'difference_gst'    => '0',
            'difference_tot'    => '0',
        );

        foreach($form_data as $record)
        {
            //Query to get AWB is valid & not billed
            $query_shipment = $this->db->query("SELECT EXISTS(SELECT * FROM shipments where waybill_number='".$record['waybill_number']."' AND system_status <>'107') as s_data")->row_array();

            $query_shipmentbill = $this->db->query("SELECT EXISTS(SELECT * FROM shipments_billing where waybill_number='".$record['waybill_number']."' AND billing_eligibility <>'2') as sb_data")->row_array();

            if($query_shipment['s_data'] && $query_shipmentbill['sb_data']) // Checking if AWB is valid
            {
                $query_wt = $this->db->select('invoice_number,billing_date,billing_eligibility,billing_weight,weight_fixed')->where('waybill_number',$record['waybill_number'])->get('shipments_billing')->row_array();

                if($query_wt['weight_fixed']=='0') // Check if submitting weight is fixed or not.
                {
                    // Check if submitting weight more than current wweight
                    //if($record['billing_weight'] > $query_wt['billing_weight'] && !empty($record['billing_weight']))
                    if(!empty($record['billing_weight']))
                    {
                        $query_status = $this->db->select('system_status')->where('waybill_number',$record['waybill_number'])->get('shipments')->row_array();

                        $order_details = $this->billing_model->get_orderdetails_invoice($record['waybill_number']);

                        if($query_status['system_status']!='115')
                        {
                            //Get Forward Charges
                            $update_data = $this->getdata_model->get_request_fwdcharges($record['waybill_number'],$record['billing_weight']);
                            $update_data['billing_weight']=$record['billing_weight'];
                            if($order_details['billing_type'] == "prepaid")
                                $update_data['paid_amount'] = $update_data['total_amount'];
                            $update_data['updated_by']=$this->session->userdata['user_session']['admin_username'];
                        }
                        else if($query_status['system_status']=='115')
                        {
                            //Get RTO Charges
                            $update_data = $this->getdata_model->get_request_rtocharges($record['waybill_number'],$record['billing_weight']);
                            $update_data['billing_weight']=$record['billing_weight'];
                            if($order_details['billing_type'] == "prepaid")
                                $update_data['paid_amount'] = $update_data['total_amount'];
                            $update_data['updated_by']=$this->session->userdata['user_session']['admin_username'];
                        }


                        if(!empty($query_wt['invoice_number']) && !empty($query_wt['billing_date']) && $query_wt['billing_eligibility'] == '1')
                        {
                            $invoice_data['user_id']        = $order_details['user_id'];
                            $invoice_data['difference_amt'] = $update_data['charges_total'] - $order_details['charges_total'];
                            $invoice_data['difference_gst'] = $update_data['gst_amount'] - $order_details['gst_amount'];
                            $invoice_data['difference_tot'] = $update_data['total_amount'] - $order_details['total_amount'];
                        }

                        $this->db->trans_start();
                        if($invoice_data['difference_tot'] != 0)
                        {
                            if($order_details['billing_type'] == "prepaid")
                            {
                                $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
                                ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
                                ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
                                ->set('paid_amount','paid_amount + '.$invoice_data['difference_tot'],false)
                                ->where('px_invoice_number',$query_wt['invoice_number'])
                                ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');

                                $user_txn_data = user_transaction_data($record['waybill_number'],$invoice_data['difference_tot'],'wtupdate_charges');
                                $this->db->insert('users_transactions',$user_txn_data);
                                $this->db->set('main_balance','main_balance -'.$invoice_data['difference_tot'],false)
                                ->set('total_balance','total_balance -'.$invoice_data['difference_tot'],false)
                                ->where('user_id',$invoice_data['user_id'])->update('users_balances');
                            }
                            else
                            {
                                $this->db->set('invoice_amount','invoice_amount + '.$invoice_data['difference_amt'],false)
                                ->set('gst_amount','gst_amount + '.$invoice_data['difference_gst'],false)
                                ->set('total_amount','total_amount + '.$invoice_data['difference_tot'],false)
                                ->set('due_amount','due_amount + '.$invoice_data['difference_tot'],false)
                                ->where('px_invoice_number',$query_wt['invoice_number'])
                                ->where('user_id',$invoice_data['user_id'])->update('shipments_invoices');
                            }
                        }
                        $this->db->where('waybill_number',$record['waybill_number'])->update('shipments_billing',$update_data);
                        $this->db->trans_complete();
                        // $this->db->trans_status() === TRUE ? $success_count++  : '';
                        $success_count++;
                    }
                    else
                        $error_data[] = array(
                            'waybill_number' => $record['waybill_number'],
                            'weight'  => $record['billing_weight'],
                            //'error'   => 'New weight is less than/equal to set weight or invalid.'
                            'error'   => 'invalid billing weight.'
                        );
                }
                else
                    $error_data[] = array(
                        'waybill_number' => $record['waybill_number'],
                        'weight'  => $record['billing_weight'],
                        'error'   => 'Weight is fixed & cannot be updated.'
                    );
            }
            else
                $error_data[] = array(
                    'waybill_number' => $record['waybill_number'],
                    'weight'  => $record['billing_weight'],
                    'error'   => 'AWB is billed or invalid'
                );
        }
        return array($success_count, $error_data);
    }

}
?>