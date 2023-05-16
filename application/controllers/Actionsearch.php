<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actionsearch extends CI_Controller
{
    public function search_pincodes()
    {
        $config = array();
        $config["base_url"] = base_url() . "master_pincodes";
        $config["total_rows"] = count($this->searchdata_model->search_pincode($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['pincodes'] = $this->searchdata_model->search_pincode($_POST,$config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['pincodes']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Pincode</th>
                            <th class="text-center">City</th>
                            <th class="text-center">State</th>
                            <th class="text-center" style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['pincodes']).' of '.$data['row_count'].' records</b></h5>';

                        foreach ($data['pincodes'] as $pin)
                        {
                            $output .='<tr>
                                <td class="text-center">'. $pin->pincode.'</td>
                                <td class="text-center">'. $pin->pin_city.'</td>
                                <td class="text-center">'. $pin->pin_state.'</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#modal-add-edit" data-toggle="modal" title="Edit" class="btn btn-xs btn-default" data-id="'. $pin->pincode_id.'"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </td>
                            </tr>';
                        }

            $output .='</tbody></table>
                        <div class="text-right">'. $data['links'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_pinservices()
    {
        $config = array();
        $config["base_url"] = base_url() . "master_pinservices";
        $config["total_rows"] = count($this->searchdata_model->search_pinservices($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['pincodeservices'] = $this->searchdata_model->search_pinservices($_POST,$config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['pincodeservices']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Pincode</th>
                            <th class="text-center">Pickup</th>
                            <th class="text-center">Reverse</th>
                            <th class="text-center">Prepaid</th>
                            <th class="text-center">COD</th>
                            <th class="text-center">DG</th>
                            <th class="text-center">NDD</th>
                            <th class="text-center">Added On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['pincodeservices']).' of '.$data['row_count'].' records</b></h5>';

                        foreach ($data['pincodeservices'] as $pinservice)
                        {
                            $output .='<tr>
                                <td class="text-center">'. $pinservice->pincode.'</td>
                                <td class="text-center">'. $pinservice->pickup.'</td>
                                <td class="text-center">'. $pinservice->reverse.'</td>
                                <td class="text-center">'. $pinservice->prepaid.'</td>
                                <td class="text-center">'. $pinservice->cod.'</td>
                                <td class="text-center">'. $pinservice->dangerous_goods.'</td>
                                <td class="text-center">'. $pinservice->ndd.'</td>
                                <td class="text-center">'. $pinservice->added_on.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['links'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_zones()
    {
        $config = array();
        $config["base_url"] = base_url() . "master_zones";
        $config["total_rows"] = count($this->searchdata_model->search_zone($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['zones'] = $this->searchdata_model->search_zone($_POST,$config["per_page"], $page);
        $data["pages"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['zones']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Source City</th>
                            <th class="text-center">Destination Pin</th>
                            <th class="text-center">Zone</th>
                            <th class="text-center" style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['zones']).' of '.$data['row_count'].' records</b></h5>';

                        foreach ($data['zones'] as $zone)
                        {
                            $output .='<tr>
                                <td class="text-center">'. $zone->source_city.'</td>
                                <td class="text-center">'. $zone->destination_pin.'</td>
                                <td class="text-center">'. $zone->zone.'</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"   onclick="getedit_data('.$zone->zone_id.')"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </td>
                            </tr>';
                        }

            $output .='</tbody></table>
                        <div class="text-right">'. $data['pages'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_users()
    {
        $config = array();
        $config["base_url"] = base_url() . "users";
        $config["total_rows"] = count($this->searchdata_model->search_user($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['users'] = $this->searchdata_model->search_user($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['users']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Customer Details</th>
                            <th class="text-center">Register Details</th>
                            <th class="text-center">KYC Details</th>
                            <th class="text-center">Billing Type/State</th>
                            <th class="text-center">Account Status</th>
                        </tr>
                    </thead>
                    <tbody>';

                        foreach ($data['users'] as $user)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$user->fullname.'<br><a href="modifyuser?uid='.base64_encode($user->user_id).'" target="_blank"><b>'.$user->username.'</b></a><br/>'.$user->business_name.'</td>
                                <td class="text-center">'.$user->added_by.'<br/>'.date('d-m-Y H:i:s', strtotime($user->added_on)).'</td>
                                <td class="text-center">';
                                if($user->kyc_status=='0')
                                    $output .='<span class="label label-warning">Pending</span></br>'. date('d-m-Y H:i:s', strtotime($user->updated_on));
                                else
                                    $output .='<span class="label label-success">Approved</span></br>'. date('d-m-Y H:i:s', strtotime($user->updated_on));
                            $output .='</td>
                                <td class="text-center">';
                                if($user->billing_type=='prepaid')
                                    $output .='<span class="label label-warning">'.ucwords($user->billing_type).'</span></br>'.$user->billing_state;
                                else
                                    $output .='<span class="label label-info">'.ucwords($user->billing_type).'</span></br>'.$user->billing_state;
                            $output .='</td>
                                <td class="text-center">';
                                if($user->account_status=='1')
                                    $output .='<span class="label label-success">Active</span>';
                                else if($user->account_status=='2')
                                    $output .='<span class="label label-warning">Inactive</span>';
                                $output .='</td>';
                        }

                        // foreach ($data['users'] as $user)
                        // {
                        //     $output .='<tr>
                        //         <td class="text-center">'.$user->username.'<br/>'.$user->fullname.'</td>
                        //         <td class="text-center">'.$user->business_name.'<br/>'.$user->business_type.'</td>
                        //         <td class="text-center">'.$user->contact.'<br/>'.$user->alt_contact.'</td>
                        //         <td class="text-center">';
                        //             if($user->billing_type=='prepaid')
                        //                 $output .='<span class="label label-warning">'.ucwords($user->billing_type).'</span>';
                        //             else
                        //                 $output .='<span class="label label-info">'.ucwords($user->billing_type).'</span>';
                        //         $output .='</td>
                        //         <td class="text-center">'.$user->billing_state.'</td>
                        //         <td class="text-center">'.$user->added_on.'</td>
                        //         <td class="text-center">';
                        //             if($user->account_status==1)
                        //             {
                        //                 $output .='<a href="javascript:void(0);" onclick="changestatus('.$user->user_id.','.$user->account_status.')" class="label label-success">Active</a>';
                        //             }
                        //             else if($user->account_status==2)
                        //             {
                        //                $output .='<a href="javascript:void(0);" onclick="changestatus('.$user->user_id.','.$user->account_status.')" class="label label-danger">Blocked</a>';
                        //             }
                        //         $output .='</td>  

                        //         <td class="text-center">
                        //             <div class="btn-group-vertical btn-group-xs">
                        //                 <a href="users_ratechart?uid='.base64_encode($user->user_id).'" target="_blank" style="margin-top: 10px;" class="btn btn-xs btn-success"><i class="fa fa-money"></i> Manage Ratechart</a>

                        //                 <a href="users_courierpriority?uid='.base64_encode($user->user_id).'" target="_blank" class="btn btn-xs btn-info" style="margin-top: 5px;"><i class="gi gi-cargo"></i> Set Courier Priority</a>

                        //                 <a href="users_weightslab?uid='.base64_encode($user->user_id).'" target="_blank" class="btn btn-xs btn-warning" style="margin-top: 5px;"><i class="fa fa-balance-scale"></i> Add Weight Slabs</a>

                        //                 <a href="modifyuser?uid='.base64_encode($user->user_id).'" target="_blank" class="btn btn-xs btn-default" style="margin-top: 5px;"><i class="fa fa-pencil"></i> Modify User</a>';
                                        
                        //                 if($user->billing_type=='postpaid')
                        //                 {
                        //                     $output .='<a href="javascript:void(0);" onclick="rectify_balance('.$user->user_id.')" class="btn btn-xs btn-success" style="margin-top: 5px;"><i class="fa fa-inr"></i> Rectify Balance</a>
                                            
                        //                     <a href="javascript:void(0);" onclick="changebilling_type('.$user->user_id.','."'prepaid'".')" class="btn btn-xs btn-danger" style="margin-top: 5px; margin-bottom:10px;"><i class="fa fa-exchange"></i> Convert to Prepaid</a>';
                        //                 }
                        //                 else if($user->billing_type=='prepaid')
                        //                 {
                        //                     $output .='<a href="javascript:void(0);" onclick="changebilling_type('.$user->user_id.','."'postpaid'".')" class="btn btn-xs btn-danger" style="margin-top: 5px; margin-bottom:10px;"><i class="fa fa-exchange"></i> Covert to Postpaid</a>';
                        //                 }
                        //             $output .='</div>
                        //         </td>
                        //     </tr>';
                        // }

            $output .='</tbody></table>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_invoice()
    {
        $config = array();
        $config["base_url"] = base_url() . "view_invoice";
        $config["total_rows"] = count($this->searchdata_model->search_invoice($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['invoices'] = $this->searchdata_model->search_invoice($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];
        $output ='';
        if(!empty($data['invoices']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Invoice</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Business/Billing/GSTIN</th>
                            <th class="text-center">Account Details</th>
                            <th class="text-center">Counts</th>
                            <th class="text-center">Invoice Amt</th>
                            <th class="text-center">GST</th>
                            <th class="text-center">Total Amt</th>
                            <th class="text-center">Settlements</th>
                            <th class="text-center">Credit Period</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Modified</th>
                            <th class="text-center" style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total Record(s): <span class="text-danger">'.$config["total_rows"].'</span> | Invoice Amt.: <span class="text-success" id="invoice_sum">fff</span> | GST: <span class="text-success" id="invoice_gst_sum">fff</span> | Total Amt: <span class="text-success" id="total_invoice_sum">fff</span></b></h5>';

                        foreach ($data['invoices'] as $invdata)
                        {
                            $gst = $invdata->kyc_gst_reg == "yes"?$invdata->kyc_doc_number:"URP";
                            $output .='<tr>
                                <td class="text-center">
                                    <a href="invoice?invoice='.base64_encode($invdata->px_invoice_number).'"><u><b>'.$invdata->px_invoice_number.'</b></u></a>
                                </td>
                                <td class="text-center">'.date('d-m-Y', strtotime($invdata->invoice_date)).'</td>
                                <td class="text-center">'.$invdata->business_name.'<br/>('.ucwords($invdata->billing_type).')<br>'.$gst.'</td>
                                <td class="text-center">'.$invdata->username.'<br/>'.$invdata->contact.'<br/>'.$invdata->alt_contact.'</td>
                                <td class="text-center">
                                    <a href="'.base_url('Actionexport/download_invoice_awbs').'?inv='.$invdata->px_invoice_number.'"><u><b>'.$invdata->shipments_count.'</b></u></a>
                                </td>
                                <td class="text-center">'.$invdata->invoice_amount.'</td>
                                <td class="text-center">'.$invdata->gst_amount.'</td>
                                <td class="text-center">'.$invdata->total_amount.'</td>
                                <td class="text-center">Paid:'.$invdata->paid_amount.'<br/>Due:'.$invdata->due_amount.'</td>
                                <td class="text-center">'.$invdata->credit_period.'<br/>days</td>
                                <td class="text-center">';
                                    if($invdata->invoice_status=="1")
                                        $output .='<span class="label label-success">Paid</span>';
                                    else if($invdata->invoice_status=="0")
                                        $output .='<span class="label label-danger">Due</span>';
                                    else if($invdata->invoice_status=="2")
                                        $output .='<span class="label label-warning">Pending</span>';
                                $output .='</td>
                                <td class="text-center">'.$invdata->updated_on.'</td>
                                <td class="text-center">
                                    <div class="btn-group">';
                                        if($invdata->invoice_status=="0" && $invdata->billing_type=="postpaid")
                                        {
                                            $output .='<a href="add_payment?inv='.base64_encode($invdata->px_invoice_number).'" target="_blank" title="Add Payment" class="btn btn-xs btn-success"><i class="fa fa-money"></i></a>';
                                        }

                                        $output .='<a href="invoice?invoice='.base64_encode($invdata->px_invoice_number).'" target="_blank" title="View Invoice" class="btn btn-xs btn-info" style="margin-left: 5px;"><i class="fa fa-file-pdf-o"></i></a>

                                        <a href="'.base_url('Actionexport/download_invoice_awbs').'?inv='.$invdata->px_invoice_number.'" title="Download AWBs" class="btn btn-xs btn-default" style="margin-left: 5px;"><i class="fa fa-download"></i></a>
                                    </div>
                                </td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_invoicepayments()
    {
        $config = array();
        $config["base_url"] = base_url() . "add_payment";
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['payments'] = $this->searchdata_model->search_invoicepayments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $output ='';
        if(!empty($data['payments']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Paid On</th>
                            <th class="text-center">Paid Amount</th>
                            <th class="text-center">Payment Mode</th>
                            <th class="text-center">Transaction #/Id</th>
                            <th class="text-center">Remark</th>
                            <th class="text-center">Added By</th>
                            <th class="text-center">Added On</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach ($data['payments'] as $paydata)
                        {
                            $output .='<tr>
                                <td class="text-center">'.date('d-m-Y', strtotime($paydata->payment_date)).'</td>
                                <td class="text-center">'.$paydata->payment_amount.'</td>
                                <td class="text-center">'.$paydata->payment_mode.'</td>
                                <td class="text-center">'.$paydata->transaction_id.'</td>
                                <td class="text-center">'.$paydata->payment_remark.'</td>
                                <td class="text-center">'.$paydata->added_by.'</td>
                                <td class="text-center">'.$paydata->added_on.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No payments added for selected invoice number.</b></h5>';

        echo $output;
    }

    public function search_cods()
    {
        $config = array();
        $config["base_url"] = base_url() . "view_cods";
        $config["total_rows"] = count($this->searchdata_model->search_cods($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['cods'] = $this->searchdata_model->search_cods($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['cods']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">COD #</th>
                            <th class="text-center">COD_Date</th>
                            <th class="text-center">Business/Billing</th>
                            <th class="text-center">Profile Details</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Total Remitted</th>
                            <th class="text-center">Account Details</th>
                            <th class="text-center">Settlement Details</th>
                            <th class="text-center">Adjust COD</th>
                            <th class="text-center">Credit Period</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="block-options pull-right">
                            <a href="#modal-bulk" data-toggle="modal" title="Bulk COD" class="btn btn-sm btn-success" style="margin-top: -8px;"><i class="fa fa-file-excel-o"></i> Bulk Remit COD</a>
                        </div>
                        <h5><b>Total Record(s): <span class="text-danger">'.$config["total_rows"].'</span> | Total Amount: <span class="text-success" id="cods_sum">fff</span> INR</b></h5>';
                        foreach ($data['cods'] as $codData)
                        {
                            $output .='<tr>
                                <td class="text-center"><b>'.$codData->cod_id.'</b></td>
                                <td class="text-center">'.date('d-m-Y', strtotime($codData->cod_cycle_date)).'</td>
                                <td class="text-center">'.$codData->business_name.'<br/>('.ucwords($codData->billing_type).')</td>
                                <td class="text-center">'.$codData->email_id.'<br/>'.$codData->contact.'<br/>'.$codData->alt_contact.'</td>
                                <td class="text-center">'.$codData->cod_amount.'</td>
                                <td class="text-center">'.$codData->total_remitted.'</td>
                                <td class="text-center">Beneficary:'.$codData->beneficiary_name.'<br/>A/C #:'.$codData->account_number.'<br/>IFSC: '.$codData->ifsc_code.'<br/>Bank:'.$codData->bank_name.'</td>
                                <td class="text-center">'. $codData->action_against."<br/>".$codData->action_date.'</td>
                                <td class="text-center">'. ucwords($codData->codadjust).'</td>
                                <td class="text-center">'.$codData->credit_period.'<br/>days</td>
                                <td class="text-center">';
                                    if($codData->cod_status=="0")
                                        $output .='<span class="label label-default">Generated</span>';
                                    else if($codData->cod_status=="1")
                                        $output .='<span class="label label-success">Remitted</span>';
                                    else if($codData->cod_status=="2")
                                        $output .='<span class="label label-warning">Adjusted</span>';
                                    else if($codData->cod_status=="3")
                                        $output .='<span class="label label-info">Accruing</span>';
                                    else if($codData->cod_status=="4")
                                        $output .='<span class="label label-success">Remitted<br/>Adjusted</span>';
                                $output .='</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                       <a href="'.base_url('Actionexport/download_cod_awbs').'?cod_id='.$codData->cod_id.'" title="Download AWBs" class="btn btn-xs btn-info" style="margin-left: 5px;"><i class="fa fa-download"></i></a>
                                    </div>';
                                if($codData->cod_status!="3" && ($codData->total_remitted + $codData->total_adjusted) < $codData->cod_amount)
                                    $output .='<div class="btn-group">
                                        <a onclick="getcod_data('.$codData->cod_id.','.$codData->user_id.')" href="#modal-remit" data-toggle="modal" title="Remit COD" class="btn btn-xs btn-success" style="margin-left: 5px;"><i class="fa fa-money"></i></a>
                                    </div>';
                                $output .= '</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_shipments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/shipments";
        $config["total_rows"] = count($this->searchdata_model->search_shipments($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_shipments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Username</th>
                            <th class="text-center">UserDetails</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">OrderId</th>
                            <th class="text-center">AWB #</th>
                            <th class="text-center">Mode/Express</th>
                            <th class="text-center">COD Amount</th>
                            <th class="text-center">OrderDate</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Customer Details</th>
                            <th class="text-center">Customer Address</th>
                            <th class="text-center">FulfilledBy</th>
                            <th class="text-center">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total '.$config["total_rows"].' Records</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$records->username.'</td>
                                <td class="text-center">'.$records->fullname."<br/>".$records->business_name."<br/>".$records->contact.'</td>
                                <td class="text-center">'.ucwords($records->shipment_type).'</td>
                                <td class="text-center">'.$records->shipment_id.'</td>
                                <td class="text-center"> <b><u><a title="View Tracking" href="https://intargos.com/tracking?waybill_no='.$records->waybill_number.'" target="_blank">'.$records->waybill_number.'</u></b></a></td>
                                <td class="text-center">'.$records->payment_mode."<br/>".ucwords($records->express_type).'</td>
                                <td class="text-center">'.$records->cod_amount.'</td>
                                <td class="text-center">'.date('d-m-Y',strtotime($records->order_date)).'</td>
                                <td class="text-center">'.$records->status_title.'</td>
                                <td class="text-center">'.$records->consignee_name."<br/>".$records->consignee_mobile.'</td>
                                <td class="text-center">'.$records->consignee_address1.",".$records->consignee_address2."<br/>".$records->consignee_city.",".$records->consignee_state."-".$records->consignee_pincode.'</td>
                                <td class="text-center">'.$records->account_name.'</td>
                                <td class="text-center">'.$records->remark_1.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_failedshipments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/failedshipments";
        $config["total_rows"] = count($this->searchdata_model->search_failedshipments($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_failedshipments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Username</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">OrderId</th>
                            <th class="text-center">Mode/Express</th>
                            <th class="text-center">OrderDate</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Customer Details</th>
                            <th class="text-center">Customer Address</th>
                            <th class="text-center">Remark</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total '.$config["total_rows"].' Records</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$records->username.'</td>
                                <td class="text-center">'.ucwords($records->shipment_type).'</td>
                                <td class="text-center">'.$records->shipment_id.'</td>
                                <td class="text-center">'.$records->payment_mode."<br/>".ucwords($records->express_type).'</td>
                                <td class="text-center">'.date('d-m-Y',strtotime($records->order_date)).'</td>
                                <td class="text-center">'.$records->status_title.'</td>
                                <td class="text-center">'.$records->consignee_name."<br/>".$records->consignee_mobile.'</td>
                                <td class="text-center">'.$records->consignee_address1.",".$records->consignee_address2."<br/>".$records->consignee_city.",".$records->consignee_state."-".$records->consignee_pincode.'</td>
                                <td class="text-center">'.$records->remark_1.'</td>
                                <td class="text-center">';
                                    if($records->user_status == 229)
                                        $output .='<button title="Re-Order" class="btn btn-sm btn-success enable-tooltip" onclick="reorder('.$records->shipment_id.')"><i class="fa fa-undo"></i> Re-Order</button>';'
                                </td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_viewbalance()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/viewbalance";
        $config["total_rows"] = count($this->searchdata_model->search_viewbalance($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_viewbalance($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Username</th>
                            <th class="text-center">Customer Details</th>
                            <th class="text-center">Main Balance</th>
                            <th class="text-center">Promo Balance</th>
                            <th class="text-center">Total Wallet Balance</th>
                            <th class="text-center">Last Updated On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total '.$config["total_rows"].' Records</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$records->username."<br/>".$records->business_name.'</td>
                                <td class="text-center">'.$records->fullname."<br/>".$records->contact.'</td>
                                <td class="text-center">'.$records->main_balance.'</td>
                                <td class="text-center">'.$records->promo_balance.'</td>
                                <td class="text-center">'.$records->total_balance.'</td>
                                <td class="text-center">'.$records->updated_on.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_allpayments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/allpayments";
        $config["total_rows"] = count($this->searchdata_model->search_allpayments($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_allpayments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Username</th>
                            <th class="text-center">CustomerDetails</th>
                            <th class="text-center">Billing</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Txn Detail</th>
                            <th class="text-center">Transaction Ref. #</th>
                            <th class="text-center">Payment Id</th>
                            <th class="text-center">Transaction On</th>
                            <th class="text-center">Txn By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total '.$config["total_rows"].' Records,</b> <b>with Amount: <span class="text-success" id="allpayments_amt_sum">Amt</span> INR</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$records->username."<br/>".$records->business_name.'</td>
                                <td class="text-center">'.$records->fullname."<br/>".$records->contact.'</td>
                                <td class="text-center">'.ucwords($records->billing_type).'</td>
                                <td class="text-center">'.$records->transaction_amount.'</td>
                                <td class="text-center">'.$records->txn_rmk.'<br>'.$records->remark.'</td>
                                <td class="text-center">'.$records->transaction_reference_id.'</td>
                                <td class="text-center">'.$records->razorpay_payment_id.'</td>
                                <td class="text-center">'.$records->transaction_on.'</td>
                                <td class="text-center">'.$records->added_by.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_alltransactions()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/alltransactions";
        $config["total_rows"] = count($this->searchdata_model->search_alltransactions($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_alltransactions($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Username</th>
                            <th class="text-center">CustomerDetails</th>
                            <th class="text-center">OrderDetails</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Txn Detail</th>
                            <th class="text-center">Transaction Ref. #</th>
                            <th class="text-center">Action</th>
                            <th class="text-center">Transaction On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total Count: <span class="text-danger">'.$config["total_rows"].' Record(s)</span> |
                        Total Amount: <span class="text-success" id="amt_sum">fff</span> INR</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'.$records->username."<br/>".$records->business_name.'</td>
                                <td class="text-center">'.$records->fullname."<br/>".$records->contact.'</td>
                                <td class="text-center">'.$records->shipment_id."<br/>".$records->waybill_number.'</td>
                                <td class="text-center">'.$records->transaction_amount.'</td>
                                <td class="text-center">'.$records->txn_rmk.'<br>'.$records->remark.'</td>
                                <td class="text-center">'.$records->transaction_reference_id.'</td>
                                <td class="text-center">'.ucwords($records->action_type).'</td>
                                <td class="text-center">'.$records->transaction_on.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_userledger()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/userledger";
        $config["total_rows"] = count($this->searchdata_model->search_userledger($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_userledger($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction On</th>
                            <th class="text-center">Reference #</th>
                            <th class="text-center">Order #</th>
                            <th class="text-center">Waybill #</th>
                            <th class="text-center">Particulars</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Opening Balance</th>
                            <th class="text-center">Closing Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b>Total Count: <span class="text-danger">'.$config["total_rows"].' Record(s)</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $output .='<tr>
                                <td class="text-center">'. date('d-m-Y H:i:s',strtotime($records->transaction_on)).'</td>
                                <td class="text-center">'.$records->transaction_reference_id.'</td>
                                <td class="text-center">'.$records->shipment_id.'</td>
                                <td class="text-center">'.$records->waybill_number.'</td>
                                <td class="text-center">'.$records->txn_rmk.'<br>'.$records->remark.'</td>
                                <td class="text-center"><b>'.$records->transaction_amount.'</b></td>
                                <td class="text-center">'.$records->opening_balance.'</td>
                                <td class="text-center">'.$records->closing_balance.'</td>
                            </tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function address_user()
    {
        $config = array();
        $config["base_url"] = base_url() . "user_addresses";
        $config["total_rows"] = count($this->searchdata_model->address_user($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->address_user($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<table id="datatable-search" class="table table-vcenter table-condensed table-bordered dt-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">AddressId</th>
                            <th class="text-center">Username/Business Name</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Adressee/Full Address</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Pin</th>
                            <th class="text-center">City/State</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">API Response</th>';
                            if(strtoupper($this->session->userdata('user_session')['role_name']) == 'SUPERADMIN' || $this->permissions_model->check_permission('register_addresses'))
                                $output .= '<th class="text-center">Register</th>';
                        $output .= '</tr>
                    </thead>
                    <tbody>
                        <h5><b>Total '.$config["total_rows"].' Records</b></h5>';
                        foreach ($data['data'] as $address)
                        {
                            $output .='<tr>
                                <td class="text-center userAdd">'.$address->user_address_id.'</td>
                                <td class="text-center">'.$address->username.'<br/>'.$address->business_name.'</td>
                                <td class="text-center">'.$address->address_title.'</td>
                                <td class="text-center">'.$address->addressee.'<br/>'.$address->full_address.'</td>
                                <td class="text-center">'.$address->phone.'</td>
                                <td class="text-center">'.$address->pincode.'</td>
                                <td class="text-center">'.$address->address_city."<br/>".$address->address_state.'</td>
                                <td class="text-center">';
                                if($address->address_status==0)
                                {
                                    $output .='<a href="javascript:void(0);" class="label label-danger">Inactive</a>';
                                }
                                else if($address->address_status==1)
                                {
                                    $output .='<a href="javascript:void(0);" class="label label-success">Active</a>';
                                }
                            $output.='</td>
                                <td class="text-center">
                                    <a href="#ModalviewResponse" class="" data-toggle="modal" data-target="#ModalviewResponse" onclick="viewAPIResponse('.$address->user_address_id.')">View</a>
                                </td>';
                                if(strtoupper($this->session->userdata('user_session')['role_name']) == 'SUPERADMIN' || $this->permissions_model->check_permission('register_addresses'))
                                    $output.='<td class="text-center">
                                        <a href="'.($address->address_status == '1' ?'#modal-register':'').'" data-toggle="modal" title="Register Warehouse" data-original-title="Register Warehouse" class="btn btn-warning btn-xs" onclick="viewAddress('.$address->user_address_id.')"'.($address->address_status == '0' ?'disabled':'').' ><i class="fa fa-check"></i> Register</a>
                                    </td>';
                            $output.='</tr>';
                        }
            $output .='</tbody></table>
                        <div class="text-right">'. $data['paginate'].'</div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

     //user's seller
     public function search_users_seller()
     {
         $config = array();
         $config["base_url"] = base_url() . "sellers";
         $config["total_rows"] = count($this->searchdata_model->search_user_seller($_POST));
         $config["per_page"] = 100;
 
         $config["full_tag_open"] = '<ul class="pagination">';
         $config["full_tag_close"] = '</ul>';
 
         $config["next_tag_open"] = '<li>';
         $config["next_tag_close"] = '</li>';
         $config["prev_tag_open"] = '<li>';
         $config["prev_tag_close"] = '</li>';
 
         $config["num_tag_open"] = '<li>';
         $config["num_tag_close"] = '</li>';
 
         $config["first_tag_open"] = '<li>';
         $config["first_tag_close"] = '</li>';
         $config["last_tag_open"] = '<li>';
         $config["last_tag_close"] = '</li>';
 
         $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
         $config["cur_tag_close"] = '</a></li>';
 
         $this->pagination->initialize($config);
 
         $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
         
         $data['users'] = $this->searchdata_model->search_user_seller($_POST,$config["per_page"], $page);
         $data["paginate"] = $this->pagination->create_links();
         $data['row_count'] = $config["total_rows"];
         //print_r($data['users']);
         $output ='';
         if(!empty($data['users']))
         {
             $output .= '<div class="table-responsive" id="render_searchdata">
                 <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                     <thead>
                         <tr>
                            <th class="text-center">Seller Id#</th>
                             <th class="text-center">Username</th>
                             <th class="text-center">Seller</th>
                             <th class="text-center">Seller GST
                             </th>
                             <th class="text-center">Seller Address</th>        
                             <th class="text-center">Added on/Updated On</th>
                             <th class="text-center">Added By/Updated By</th>
                             <th class="text-center">Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         <h5><b><span class="text-success">Found: '.$data['row_count'].'</span> (filtered from '.$this->db->count_all('users').' records)</b></h5>';
 
                         foreach ($data['users'] as $user)
                         {
                             $output .='<tr>
                                 <td class="text-center">'.$user->seller_id.'</td>
                                 <td class="text-center">'.$user->username.'</td>
                                 <td class="text-center">'.$user->seller_name.'</td>
                                 <td class="text-center">'.$user->seller_gst.'</td>
                                 <td class="text-center">'.$user->seller_address.'</td>        
                                 <td class="text-center">'.$user->added_on.'<br/>'.$user->updated_on.'</td>
                                 <td class="text-center">'.$user->added_by.'<br/>'.$user->updated_by.'</td>
                                 <td class="text-center">';
                                 if($user->seller_status==1)
                                 {
                                     $output .='<a href="javascript:void(0);" class="label label-success">Active</a>';
                                 }
                                 else if($user->seller_status==2)
                                 {
                                    $output .='<a href="javascript:void(0);" class="label label-danger">Blocked</a>';
                                 }
                             $output .='</td>  
                             </tr>';
                         }
 
             $output .='</tbody></table>
                         <div class="text-right">'. $data['paginate'].'</div>
             </div>';
         }
         else
             $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';
 
        echo $output;
    }

    public function pregenerated_awbs()
    {
        $config = array();
        $config["base_url"] = base_url() . "pregenerated_awbs";
        $config["total_rows"] = count($this->searchdata_model->pregenerated_awbs($_POST));
        $config["per_page"] = 100;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['awb'] = $this->searchdata_model->pregenerated_awbs($_POST,$config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];

        $output ='';
        if(!empty($data['awb']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">AWB</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Mode</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <h5 style="font-weight: 400;">Showing:<b> '.count($data['awb']).' of '.$data['row_count'].' orders</b></h5>';

                        foreach ($data['awb'] as $awb)
                        {
                            $status = $awb->waybill_status == 1?"Used":"Unused";
                            
                            $output .='<tr>
                                <td class="text-center">'. $awb->waybill_num. '</td>
                                <td class="text-center">'. ucwords($awb->shipment_type). '</td>
                                <td class="text-center">'. $awb->pay_mode. '</td>
                                <td class="text-center">'. $status. '</td>
                            </tr>';
                        }

            $output .='</tbody></table>
                        <div class="text-right">'. $data['links'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_open_ndrshipments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/open_ndr";
        $config["total_rows"] = count($this->searchdata_model->report_ndr_shipments($_POST));
        $config["per_page"] = 1000;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->report_ndr_shipments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width=20%>Tracking Info</th>
                            <th class="text-center" width=20%>Customer Details</th>
                            <th class="text-center">First NDR</th>
                            <th class="text-center">Latest NDR</th>
                            <th class="text-center">OFD/Aging</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['data']).' of '.$data['row_count'].' orders</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $product_data='';
                            $order_details = $records->payment_mode == "PPD" ? '<span class="label label-info">Prepaid</span>':'<span class="label label-success">COD</span>: '.$records->cod_amount;

                            $current_status  = $records->user_status == "226" ? '<span class="label label-success">'.$records->status_title.'</span>' : ($records->user_status == "225" || $records->user_status == "224" ? '<span class="label label-danger">'.$records->status_title.'</span>' : '<span class="label label-warning">'.$records->status_title.'</span>');

                            $attempts = empty($records->ofd_attempts) ? '0' : $records->ofd_attempts;

                            $first_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->courier_timestamp)));
                            $last_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->latest_courier_timestamp)));
                            
                            $output .='<tr>
                                <td style="line-height:1.5em;">
                                    <b>Order Dt:</b>'.date('d-m-Y',strtotime($records->order_date)).'
                                    <br/><b>AWBN # <a data-placement="left" class="enable-tooltip" title="Click to view tracking history" href="https://intargos.com/tracking?waybill_no='.$records->waybill_number.'" target="_blank">'.$records->waybill_number."</a></b>
                                    <br/><b>Order #</b> ".$records->shipment_id.'
                                    <br/><b>FulfilledBy: </b>'.$records->account_name.'
                                    <br/><b>Current Status: </b>'.$current_status.'
                                    <br/>'.$order_details."<br/>Value: ".$records->invoice_value.'
                                </td>
                                <td>
                                    <b>Name:</b> '.$records->consignee_name."
                                    <br/><b>Contact: </b>".$records->consignee_mobile.",".$records->consignee_phone."<br/><b>Address: </b>".$records->consignee_address1.", ".$records->consignee_address2."<br/>".$records->consignee_city.",".$records->consignee_state."-".$records->consignee_pincode.'
                                </td>
                                
                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->courier_location.'
                                </td>
                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->latest_ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->latest_courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->latest_courier_location.'
                                </td>
                                <td class="text-center">Attempts: '.$attempts.'<br/>Aging: '.$first_ndr_dt->diff($last_ndr_dt)->format("%a").'</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical btn-group-xs">';
                                        $output .='<button title="Re-Attempt" id="RA'.$records->waybill_number.'" data-loading-text="Processing NDR..." class="btn btn-xs btn-success enable-tooltip" onclick="reattempt('.$records->waybill_number.')"><i class="fa fa-undo"></i> Re-Attempt</button>
                                        
                                        <a href="#modal-reschedule" data-toggle="modal" title="Re-Schedule" data-awbn="'.$records->waybill_number.'" data-loading-text="Processing NDR..." id="RS'.$records->waybill_number.'" class="btn btn-xs btn-primary enable-tooltip" style="margin-top:5px;"><i class="fa fa-calendar-check-o"></i> Re-Schedule</a>

                                        <a href="#modal-update" data-toggle="modal" title="Update Details" data-wbn="'.$records->waybill_number.'" data-name="'.$records->consignee_name.'" data-phone="'.$records->consignee_mobile.'" data-add="'.$records->consignee_address1.", ".$records->consignee_address2.'" data-pin="'.$records->consignee_pincode.'" id="ED'.$records->waybill_number.'" class="btn btn-xs btn-warning enable-tooltip" style="margin-top:5px;"><i class="fa fa-pencil-square-o"></i> Edit Details</a>

                                        <button title="Mark RTO" id="RT'.$records->waybill_number.'" data-loading-text="Processing NDR..." class="btn btn-xs btn-danger enable-tooltip" onclick="markrto('.$records->waybill_number.')" style="margin-top:5px;"><i class="fa fa-reply-all"></i> Mark RTO</button>
                                    </div>
                                </td>
                            </tr>';
                        }
        $output .='</tbody></table>
                <div class="text-right">'. $data['paginate'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_active_ndrshipments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/active_ndr";
        $config["total_rows"] = count($this->searchdata_model->report_ndr_shipments($_POST));
        $config["per_page"] = 1000;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->report_ndr_shipments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width=20%>Tracking Info</th>
                            <th class="text-center" width=20%>Customer Details</th>
                            <th class="text-center">First NDR</th>
                            <th class="text-center">Latest NDR</th>
                            <th class="text-center">OFD/Aging</th>
                            <th class="text-center">Last Action</th>
                            <th class="text-center">Last Action On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['data']).' of '.$data['row_count'].' orders</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $ndr_action = ($records->action_requested == 're_attempt' ? '<span class="label label-success">Re-Attempt</span>' : ($records->action_requested == 're_schedule' ? '<span class="label label-primary">Re-Scheduled</span>' : ($records->action_requested == 'mark_rto' ? '<span class="label label-danger">Marked RTO</span>' : '<span class="label label-warning">Details Updated</span>')));
                            $product_data='';
                            $order_details = $records->payment_mode == "PPD" ? '<span class="label label-info">Prepaid</span>':'<span class="label label-success">COD</span>: '.$records->cod_amount;

                            $current_status  = $records->user_status == "226" ? '<span class="label label-success">'.$records->status_title.'</span>' : ($records->user_status == "225" || $records->user_status == "224" ? '<span class="label label-danger">'.$records->status_title.'</span>' : '<span class="label label-warning">'.$records->status_title.'</span>');

                            $action_details = $records->action_requested == 're_schedule' ? $records->future_delivery : ($records->action_requested == 'update_details' ? $records->updated_details : '');

                            $attempts = empty($records->ofd_attempts) ? '0' : $records->ofd_attempts;

                            $first_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->courier_timestamp)));
                            $last_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->latest_courier_timestamp)));
                            
                            $output .='<tr>
                                <td style="line-height:1.5em;">
                                    <b>Order Dt:</b>'.date('d-m-Y',strtotime($records->order_date)).'
                                    <br/><b>AWBN # <a data-placement="left" class="enable-tooltip" title="Click to view tracking history" href="https://intargos.com/tracking?waybill_no='.$records->waybill_number.'" target="_blank">'.$records->waybill_number."</a></b>
                                    <br/><b>Order #</b> ".$records->shipment_id.'
                                    <br/><b>FulfilledBy: </b>'.$records->account_name.'
                                    <br/><b>Current Status: </b>'.$current_status.'
                                    <br/>'.$order_details."<br/>Value: ".$records->invoice_value.'
                                </td>
                                <td>
                                    <b>Name:</b> '.$records->consignee_name."
                                    <br/><b>Contact: </b>".$records->consignee_mobile.",".$records->consignee_phone."<br/><b>Address: </b>".$records->consignee_address1.", ".$records->consignee_address2."<br/>".$records->consignee_city.",".$records->consignee_state."-".$records->consignee_pincode.'
                                </td>
                                
                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->courier_location.'
                                </td>
                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->latest_ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->latest_courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->latest_courier_location.'
                                </td>
                                <td class="text-center">Attempts:'.$attempts.'<br/>Aging: '.$first_ndr_dt->diff($last_ndr_dt)->format("%a").'</td>
                                <td class="text-center">'.$ndr_action.'<br/>'.$action_details.'</td>
                                <td class="text-center">'.date('d-m-Y h:i:s A',strtotime($records->action_on)).'</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical btn-group-xs">';
                                        $output .='<button title="Re-Attempt" id="RA'.$records->waybill_number.'" data-loading-text="Processing NDR..." class="btn btn-xs btn-success enable-tooltip" onclick="reattempt('.$records->waybill_number.')"><i class="fa fa-undo"></i> Re-Attempt</button>
                                        
                                        <a href="#modal-reschedule" data-toggle="modal" title="Re-Schedule" data-awbn="'.$records->waybill_number.'" data-loading-text="Processing NDR..." id="RS'.$records->waybill_number.'" class="btn btn-xs btn-primary enable-tooltip" style="margin-top:5px;"><i class="fa fa-calendar-check-o"></i> Re-Schedule</a>

                                        <a href="#modal-update" data-toggle="modal" title="Update Details" data-wbn="'.$records->waybill_number.'" data-name="'.$records->consignee_name.'" data-phone="'.$records->consignee_mobile.'" data-add="'.$records->consignee_address1.", ".$records->consignee_address2.'" data-pin="'.$records->consignee_pincode.'" id="ED'.$records->waybill_number.'" class="btn btn-xs btn-warning enable-tooltip" style="margin-top:5px;"><i class="fa fa-pencil-square-o"></i> Edit Details</a>

                                        <button title="Mark RTO" id="RT'.$records->waybill_number.'" data-loading-text="Processing NDR..." class="btn btn-xs btn-danger enable-tooltip" onclick="markrto('.$records->waybill_number.')" style="margin-top:5px;"><i class="fa fa-reply-all"></i> Mark RTO</button>
                                    </div>
                                </td>
                            </tr>';
                        }
        $output .='</tbody></table>
                <div class="text-right">'. $data['paginate'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_closed_ndrshipments()
    {
        $config = array();
        $config["base_url"] = base_url() . "reports/closed_ndr";
        $config["total_rows"] = count($this->searchdata_model->report_ndr_shipments($_POST));
        $config["per_page"] = 1000;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->report_ndr_shipments($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];
        $output ='';
        if(!empty($data['data']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width=20%>Tracking Info</th>
                            <th class="text-center" width=20%>Customer Details</th>
                            <th class="text-center">First NDR</th>
                            <th class="text-center">Latest NDR</th>
                            <th class="text-center">OFD</th>
                            <th class="text-center">Closed Status</th>
                            <th class="text-center">Closed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5 style="font-weight: 400;">Showing:<b> '.count($data['data']).' of '.$data['row_count'].' orders</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $product_data='';
                            $order_details = $records->payment_mode == "PPD" ? '<span class="label label-info">Prepaid</span>':'<span class="label label-success">COD</span>: '.$records->cod_amount;

                            $attempts = empty($records->ofd_attempts) ? '0' : $records->ofd_attempts;

                            $first_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->courier_timestamp)));
                            $last_ndr_dt = new DateTime(date('Y-m-d',strtotime($records->latest_courier_timestamp)));

                            $final_status = $records->final_status == '1' ? '<span class="label label-success">Delivered</span>' : '<span class="label label-danger">RTO</span>';
                            
                            $output .='<tr>
                                <td style="line-height:1.5em;">
                                    <b>Order Dt:</b>'.date('d-m-Y',strtotime($records->order_date)).'
                                    <br/><b>AWBN # <a data-placement="left" class="enable-tooltip" title="Click to view tracking history" href="https://intargos.com/tracking?waybill_no='.$records->waybill_number.'" target="_blank">'.$records->waybill_number."</a></b>
                                    <br/><b>Order #</b> ".$records->shipment_id.'
                                    <br/><b>FulfilledBy: </b>'.$records->account_name.'
                                    <br/><b>Current Status: </b> <span class="label label-warning">'.$records->status_title.'</span>
                                    <br/>'.$order_details."<br/>Value: ".$records->invoice_value.'
                                </td>
                                <td>
                                    <b>Name:</b> '.$records->consignee_name."
                                    <br/><b>Contact: </b>".$records->consignee_mobile.",".$records->consignee_phone."<br/><b>Address: </b>".$records->consignee_address1.", ".$records->consignee_address2."<br/>".$records->consignee_city.",".$records->consignee_state."-".$records->consignee_pincode.'
                                </td>

                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->courier_location.'
                                </td>
                                <td style="line-height:1.5em;">
                                    <b>Reason: </b><span class="label label-danger">'.$records->latest_ndr_remark.'</span>
                                    <br/><b>NDR On: </b> '.date('d-m-Y h:i:s A',strtotime($records->latest_courier_timestamp))."
                                    <br/><b>Location: </b> ".$records->latest_courier_location.'
                                </td>
                                <td class="text-center">'.$attempts.'<br/>Aging: '.$first_ndr_dt->diff($last_ndr_dt)->format("%a").'</td>
                                <td class="text-center">'.$final_status.'</td>
                                <td class="text-center">'.date('d-m-Y h:i:s A',strtotime($records->final_status_on)).'</td>
                            </tr>';
                        }
        $output .='</tbody></table>
                <div class="text-right">'. $data['paginate'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }

    public function search_pickup_id()
    {
        $this->form_validation->set_rules('order_id', 'Order Id', 'required|trim|regex_match[/^([0-9,])+$/]');
        $this->form_validation->set_message('regex_match', 'Enter %s in correct format');
        if($this->form_validation->run() == TRUE)
        {
            $pickupids_data = $this->searchdata_model->report_pickup_id();
            $output ='';
            if(!empty($pickupids_data))
            {
                $output .= '<div class="table-responsive" id="render_searchdata">
                    <table id="datatable-search" class="table table-vcenter table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width=20%>Order Id</th>
                                <th class="text-center" width=20%>Pickup Id</th>
                                <th class="text-center">Remark</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach($pickupids_data as $pickupData)
                {
                    $responseData = json_decode($pickupData['response']);
                    if(!empty($responseData) && !empty($pickupData['event_id'])) {
                        if(isset($responseData->RegisterPickupResult)) {
                            $pickupid        = $responseData->RegisterPickupResult->TokenNumber;
                            $pickup_remark   = $responseData->RegisterPickupResult->Status[0]->StatusInformation;
                        }
                    } else {
                        $pickupid = '-';
                        $pickup_remark = 'No details in Logs or invalid response';
                    }

                    $output .='<tr>
                        <td class="text-center">'.$pickupData['event_id'].'</td>
                        <td class="text-center">'.$pickupid.'</td>
                        <td class="text-center">'.$pickup_remark.'</td>
                    </tr>';
                }
                $output .='</tbody></table></div>';
            }
            else
                $output = '<p style="font-size: 15px; text-align:center; margin-top: 15px;">No results available, please check and enter correct order id.</p>';
        }
        else
            $output = '<p style="font-size: 15px; text-align:center; margin-top: 15px;">'.validation_errors().'</p>';
            
        echo $output;
    }

    public function search_users_weight_request()
    {
        $config = array();
        $config["base_url"] = base_url() . "administrator/update_weight_request";
        //echo " hello ";print_r($this->searchdata_model->search_weightrequest($_POST)); die;
        $config["total_rows"] = count($this->searchdata_model->search_weightrequest($_POST));
        $config["per_page"] = 1000;

        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';

        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';

        $config["num_tag_open"] = '<li>';
        $config["num_tag_close"] = '</li>';

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';

        $config["cur_tag_open"] = '<li class="active"><a href="javascript:void(0)">';
        $config["cur_tag_close"] = '</a></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->searchdata_model->search_weightrequest($_POST,$config["per_page"], $page);
        $data["paginate"] = $this->pagination->create_links();
        $data['row_count'] = $config["total_rows"];
        $output ='';
        $url = base_url("Channels/channelsingle_process");

        if(!empty($data['data']))
        {
            $output .= '<div class="table-responsive" id="render_searchdata">
            <form method="post" id="form_bulkprocess">
                <table id="datatable-search" class="table table-vcenter table-condensed table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox"></th>
                            <th class="text-center">Username</th>
                            <th class="text-center">AWB</th>
                            <th class="text-center" width="5%">Given Wt</th>
                            <th class="text-center">Billed Wt</th>
                            <th class="text-center" width="15%">Requested Wt</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <h5 style="font-weight: 400;">Showing:<b> '.count($data['data']).' of '.$data['row_count'].' record(s)</b></h5>';
                        foreach ($data['data'] as $records)
                        {
                            $po_data='';
                            $output .='<tr class="order_data">
                            <td class="text-center"><input type="checkbox" value="'.$records->uwt_id.'" name="order_id[]"'.(($records->request_status != "0")?'disabled':'').'></td>
                            <td class="text-center">'.$records->username.'</td>
                            <td class="text-center">'.$records->waybill_number.'</td>
                            <td class="text-center">'.$records->given_weight.'</td>
                            <td class="text-center">'.$records->billing_weight.'</td>
                            <td class="text-center">'.$records->request_weight.'</td>
                            <td class="text-center">';
                                if($records->request_status == '0'){
                                    $output .= '<span class="label label-info">Pending</span>';
                                }
                                else if($records->request_status == '1'){
                                    $output .= '<span class="label label-success">Approved</span>';
                                }
                                else if($records->request_status == '2'){
                                    $output .= '<span class="label label-danger">Rejected</span>';
                                }
                                if($records->request_status == '0'){
                                    $output .='<td><a href="#modal-approve" data-toggle="modal" title="Approve" class="btn btn-xs btn-success enable-tooltip" data-id="'.$records->uwt_id.'" style="margin-left: 5px;"><i class="fa fa-check"></i></a>';
                                    $output .='<a href="#modal-confirm" data-toggle="modal" title="Reject" class="btn btn-xs btn-danger enable-tooltip" data-id="'.$records->uwt_id.'" style="margin-left: 5px;"><i class="fa fa-ban"></i></a>';
                                }
                                else{
                                    $output .= '<td> -- ';
                                }
                            '</td>
                        </tr>';
                        }
            $output .='</tbody></table></form>
                        <div class="text-right">'. $data['paginate'].'</div>
            </div>';
        }
        else
            $output .= '<h5 class="text-center"><b>No data available for selected filter(s).</b></h5>';

        echo $output;
    }
}
?>