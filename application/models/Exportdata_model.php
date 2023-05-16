<?php
class Exportdata_model extends CI_Model
{
    public function searched_invoices($fields)
    {
        if(!empty($fields["px_invoice_number"]))
            $this->db->where('px_invoice_number', $fields["px_invoice_number"]);
        if(!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if(!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if(!empty($fields["billing_type"]))
            $this->db->where('billing_type', $fields["billing_type"]);
        if(!empty($fields["invoice_status"]) || $fields["invoice_status"] == '0')
            $this->db->where('shipments_invoices.invoice_status', $fields["invoice_status"]);
        if(!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("shipments_invoices.invoice_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");

        $this->db->select("shipments_invoices.*, email_id,contact,alt_contact,username, business_name,billing_type,billing_state,kyc_gst_reg,kyc_doc_number,credit_period");
        $this->db->join('users','users.user_id=shipments_invoices.user_id','LEFT');
        $this->db->join('users_kyc','users_kyc.user_id=shipments_invoices.user_id','LEFT');
        $query = $this->db->get('shipments_invoices');
        
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function download_invoice_awbs($invoice_number)
    {
        if($invoice_number != "")
            $query = $this->db->select('S.shipment_id,S.shipment_type,S.waybill_number,payment_mode,consignee_name,consignee_city,consignee_state,consignee_pincode,order_date,S.total_amount as order_amt,S.cod_amount,shipment_length,shipment_width,shipment_height,express_type,user_status,address_title,addressee,pincode,SB.*,SS.status_title')
                        ->where('SB.invoice_number',$invoice_number)
                        ->join('shipments_billing SB','SB.shipment_id=S.shipment_id','LEFT')
                        ->join('users_address UA','S.pick_address_id=UA.user_address_id','LEFT')
                        ->join('shipments_status SS','S.user_status=SS.status_id','LEFT')
                        ->order_by('S.shipment_id', 'ASC')
                        ->get('shipments S');
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function download_cod_awbs($cod_id)
    {
        if(!empty($cod_id))
            $query = $this->db->select('SB.shipment_id, SB.waybill_number, SB.invoice_number, billing_date, SB.cod_amount, cod_gap, cod_status, cod_date, cod_eligible_date, cod_cycle_date, cod_trn,previous_codtrn,account_name')
                        ->where('cod_trn',$cod_id)
                        ->join('shipments S','S.shipment_id=SB.shipment_id','LEFT')
                        ->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account','LEFT')
                        ->get('shipments_billing SB');
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function searched_cods($fields)
    {
        if(!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if(!empty($fields["cod_id"]))
            $this->db->where('cod_id', $fields["cod_id"]);
        if(!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if(!empty($fields["codadjust"]))
            $this->db->where('codadjust', $fields["codadjust"]);
        if(!empty($fields["billing_type"]))
            $this->db->where('billing_type', $fields["billing_type"]);
        if(!empty($fields["cod_status"]) || $fields["cod_status"] == '0')
            $this->db->where('cod_status', $fields["cod_status"]);
        if(!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("shipments_cods.cod_cycle_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");

        $this->db->select("shipments_cods.*, codadjust,email_id,contact,alt_contact, business_name,billing_type,beneficiary_name, account_number, ifsc_code, bank_name, branch_name, credit_period");
        $this->db->join('users','users.user_id=shipments_cods.user_id','LEFT');
        $query = $this->db->get('shipments_cods');
        
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function reports_shipments($fields)
    {
        $this->db->select('username,fullname,business_name,contact,shipment_type,shipment_id,waybill_number,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,order_date,shipment_length,shipment_width,shipment_height,shipment_weight,express_type,fulfilled_by,user_status,status_title,cod_amount,remark_1,account_name');
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if (!empty($fields["shipment_type"]))
            $this->db->where('shipment_type', $fields["shipment_type"]);
        if (!empty($fields["shipment_id"]))
            $this->db->where('shipment_id', $fields["shipment_id"]);
        if (!empty($fields["waybill_number"]))
            $this->db->where('waybill_number', $fields["waybill_number"]);
        if (!empty($fields["payment_mode"]))
            $this->db->where('payment_mode', $fields["payment_mode"]);
        if (!empty($fields["express_type"]))
            $this->db->where('express_type', $fields["express_type"]);
        if (!empty($fields["fulfilled_account"]))
            $this->db->where('fulfilled_account', $fields["fulfilled_account"]);
        if (!empty($fields["user_status"]))
            $this->db->where_in('user_status', $fields["user_status"]);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("order_date BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
        
        $this->db->join('shipments_status SS','SS.status_id=S.user_status');
        $this->db->join('users U','U.user_id=S.user_id');
        $this->db->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account');
        $this->db->order_by('S.shipment_id', 'DESC');
        $query = $this->db->get('shipments S');
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function reports_mis($action,$fields=null,$file_type=null)
    {
        if(isset($fields["from_date"]) && isset($fields["to_date"]))
        {
            $to_date = new DateTime($fields["to_date"]);
            $from_date = new DateTime($fields["from_date"]);
        }
        
        if($action=='single')
        {
            if(!empty($fields["from_date"]) && !empty($fields["to_date"]) && $to_date->diff($from_date)->format("%a") <= 31)
            {
                $this->db->select('username,business_name,fullname,contact,shipment_type,S.shipment_id,S.waybill_number,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,S.order_date,shipment_length,shipment_width,shipment_height,shipment_weight,express_type,fulfilled_by,user_status,status_title,S.cod_amount,remark_1,account_name,address_title,S.invoice_number,product_name,product_quantity,SP.product_value,zone,UA.phone, UA.full_address,UA.pincode, UA.address_city,UA.address_state,ssl.ofd1_on,ssl.ofd2_on,ssl.ofd3_on,ssl.ofd_all,ssl.pod,ssl.picked_on,ssl.last_scan_on,ssl.last_scan_location,ssl.last_scan_remark,ssl.ofd_attempts,sb.billing_weight');
                if (!empty($fields["username"]))
                    $this->db->like('username', $fields["username"]);
                if (!empty($fields["waybill_number"]))
                    $this->db->like('SP.waybill_number', $fields["waybill_number"]);      
                if (!empty($fields["shipment_id"]))
                    $this->db->where('SP.shipment_id', $fields["shipment_id"]); 
                if (!empty($fields["address_title"]))
                    $this->db->where('address_title', $fields["address_title"]); 
                if (!empty($fields["user_status"]))
                    $this->db->where_in('user_status', $fields["user_status"]);
                if (!empty($fields["shipment_type"]))
                    $this->db->where('shipment_type', $fields["shipment_type"]);
                if (!empty($fields["fulfilled_account"]))
                    $this->db->where('fulfilled_account', $fields["fulfilled_account"]);
                if (!empty($fields["from_date"]) && !empty($fields["to_date"]) && !empty($fields["order_date"]))
                {
                    if($fields['order_date'] == 'picked')
                        $this->db->where("ssl.picked_on BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
                    elseif($fields['order_date'] == 'placed')
                        $this->db->where("S.order_date BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
                }
                
                $this->db->join('shipments_status SS','SS.status_id=S.user_status','left');
                $this->db->join('users U','U.user_id=S.user_id','left');
                $this->db->join('users_address UA','UA.user_address_id=S.pick_address_id AND UA.user_id=S.user_id','inner');
                $this->db->join('shipments_products SP','SP.shipment_id=S.shipment_id AND SP.waybill_number=S.waybill_number AND SP.user_id=S.user_id','inner');
                $this->db->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account','left');
                $this->db->join('shipments_statuses_logs ssl','S.waybill_number=ssl.waybill_number AND ssl.shipment_id=S.shipment_id','left');
                $this->db->join('shipments_billing sb','S.shipment_id=sb.shipment_id AND sb.waybill_number=S.waybill_number AND sb.user_id=S.user_id','inner');
                $this->db->where_not_in('user_status','200,220,229', false);
                $this->db->where('S.is_mps','0');
                $query = $this->db->get('shipments S');
                return $query->result();
            }
        }
        elseif($action=='bulk')
        {
            $returns=array();
            $handle=fopen($fields, 'r');
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                if($file_type=='waybill_number'){
                    $this->db->where('S.waybill_number',$data[0]);
                }elseif($file_type=='shipment_id'){
                    $this->db->where('S.shipment_id',$data[0]);
                }else{
                    $this->db->where('S.invoice_number',$data[0]);
                }
                $this->db->select('username,business_name,fullname,contact,shipment_type,S.shipment_id,S.waybill_number,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,S.order_date,shipment_length,shipment_width,shipment_height,shipment_weight,express_type,fulfilled_by,user_status,status_title,S.cod_amount,remark_1,account_name,address_title,S.invoice_number,product_name,product_quantity,SP.product_value,zone,UA.phone, UA.full_address,UA.pincode, UA.address_city,UA.address_state,ssl.ofd1_on,ssl.ofd2_on,ssl.ofd3_on,ssl.ofd_all,ssl.pod,ssl.picked_on,ssl.last_scan_on,ssl.last_scan_location,ssl.last_scan_remark,ssl.ofd_attempts,sb.billing_weight');
                $this->db->join('shipments_status SS','SS.status_id=S.user_status','left');
                $this->db->join('users U','U.user_id=S.user_id','left');
                $this->db->join('users_address UA','UA.user_address_id=S.pick_address_id AND UA.user_id=S.user_id','inner');
                $this->db->join('shipments_products SP','SP.shipment_id=S.shipment_id AND SP.waybill_number=S.waybill_number AND SP.user_id=S.user_id','inner');
                $this->db->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account','left');
                $this->db->join('shipments_statuses_logs ssl','S.waybill_number=ssl.waybill_number AND ssl.shipment_id=S.shipment_id','left');
                $this->db->join('shipments_billing sb','S.shipment_id=sb.shipment_id AND sb.waybill_number=S.waybill_number AND sb.user_id=S.user_id','inner');
                $this->db->where_not_in('user_status','200,220,229', false);
                $this->db->where('S.is_mps','0');
                $query = $this->db->get('shipments S');
                $returns[]= $query->result();
            }
            return $returns;
        }
        elseif($action=='mpssingle')
        {
            if(!empty($fields["from_date"]) && !empty($fields["to_date"]) && $to_date->diff($from_date)->format("%a") <= 31)
            {
                $this->db->select('username,business_name,fullname,contact,shipment_type,SP.shipment_id,SP.waybill_number,S.waybill_number as parent_id,(CASE WHEN SP.waybill_number = S.waybill_number THEN S.shipment_count ELSE 0 END) as shipment_count,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,S.order_date,product_length,product_width,product_height,product_weight as box_weight,product_weight,product_vol_weight,express_type,fulfilled_by,user_status,status_title,(CASE WHEN SP.waybill_number = S.waybill_number AND payment_mode="COD" THEN S.cod_amount ELSE 0 END) as cod_amount,remark_1,account_name,address_title,S.invoice_number,product_name,product_quantity,SP.product_value,zone,UA.phone, UA.full_address,UA.pincode, UA.address_city,UA.address_state,ssl.ofd1_on,ssl.ofd2_on,ssl.ofd3_on,ssl.ofd_all,ssl.pod,ssl.picked_on,ssl.last_scan_on,ssl.last_scan_location,ssl.last_scan_remark,ssl.ofd_attempts,(CASE WHEN SP.waybill_number = S.waybill_number THEN sb.billing_weight ELSE 0 END) as billing_weight');
                if (!empty($fields["username"]))
                    $this->db->like('username', $fields["username"]);
                if (!empty($fields["waybill_number"]))
                    $this->db->like('SP.waybill_number', $fields["waybill_number"]);      
                if (!empty($fields["shipment_id"]))
                    $this->db->where('SP.shipment_id', $fields["shipment_id"]); 
                if (!empty($fields["address_title"]))
                    $this->db->where('address_title', $fields["address_title"]); 
                if (!empty($fields["user_status"]))
                    $this->db->where_in('user_status', $fields["user_status"]);
                if (!empty($fields["shipment_type"]))
                    $this->db->where('shipment_type', $fields["shipment_type"]);
                if (!empty($fields["fulfilled_account"]))
                    $this->db->where('fulfilled_account', $fields["fulfilled_account"]);
                if (!empty($fields["from_date"]) && !empty($fields["to_date"]) && !empty($fields["order_date"]))
                {
                    if($fields['order_date'] == 'picked')
                        $this->db->where("ssl.picked_on BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
                    elseif($fields['order_date'] == 'placed')
                        $this->db->where("S.order_date BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
                }
                
                $this->db->join('shipments_status SS','SS.status_id=S.user_status','left');
                $this->db->join('users U','U.user_id=S.user_id','left');
                $this->db->join('users_address UA','UA.user_address_id=S.pick_address_id AND UA.user_id=S.user_id','inner');
                $this->db->join('shipments_products SP','SP.shipment_id=S.shipment_id AND SP.user_id=S.user_id','inner');
                $this->db->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account','left');
                $this->db->join('shipments_statuses_logs ssl','S.waybill_number=ssl.waybill_number AND ssl.shipment_id=S.shipment_id','left');
                $this->db->join('shipments_billing sb','S.shipment_id=sb.shipment_id AND sb.waybill_number=S.waybill_number AND sb.user_id=S.user_id','inner');
                $this->db->where_not_in('user_status','200,220,229', false);
                $this->db->where('S.is_mps','1');
                $query = $this->db->get('shipments S');
                return $query->result();
            }
        }
    }

    public function export_all_invoices_awbs($fields)
    {
        $this->db->select('SB.*, U.username, S.zone, MTPA.account_name,S.user_status');

        if(!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("SB.billing_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");

        $this->db->join('users U','U.user_id=SB.user_id','LEFT');
        $this->db->join('shipments S','S.waybill_number=SB.waybill_number AND S.shipment_id=SB.shipment_id', 'LEFT');
        $this->db->join('master_transitpartners_accounts MTPA','S.fulfilled_account=MTPA.account_id', 'LEFT');
        $this->db->where('SB.invoice_number !=',null);
        $query = $this->db->get('shipments_billing SB');
        return $query->result();
    }

    public function export_all_cods_awbs($fields)
    {
        $this->db->select('SB.*, U.username,MTPA.account_name,SS.status_title');

        if(!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("SB.cod_cycle_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");

        $this->db->join('users U','U.user_id=SB.user_id','LEFT');
        $this->db->join('shipments S','S.waybill_number=SB.waybill_number AND S.shipment_id=SB.shipment_id', 'LEFT');
        $this->db->join('master_transitpartners_accounts MTPA','S.fulfilled_account=MTPA.account_id', 'LEFT');
        $this->db->join('shipments_status SS','SS.status_id=S.user_status', 'LEFT');
        $this->db->where('SB.cod_trn !=','');
        $query = $this->db->get('shipments_billing SB');
        return $query->result();
    }

    public function status_logs($fields)
    {
        // _print_r($fields);
        $returns=array();
        $handle=fopen($fields, 'r');
        $cnt = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($cnt > 0 && $cnt <= 50 && !empty($data[0]))
            {
                // Check AWB exists
                $checkAWB= $this->db->where('waybill_number',$data[0])->get('shipments_products')->result();
                if($checkAWB)
                {
                    //Check& Get in Logs
                    $this->db->select("SSL.*, SS.status_title");
                    $this->db->where('SS.status_for', 'User');
                    $this->db->where('SSL.waybill_number',$data[0]);
                    $this->db->join('shipments_status SS','SS.status_id=SSL.px_statuscode');
                    $query = $this->db->get('shipments_status_logs SSL');
                    $result= $query->result();
                    // print_r($this->db->last_query());
                    if(!empty($result))
                        $returns[]= $query->result();
                    else{
                        $returns[]= [
                            (object)[
                            'waybill_number'=>$data[0],
                            "shipment_id"=>'Log(s) for this waybill are not available at this time. ',
                        ]];
                    }
                }
                else{
                    $returns[]= [
                        (object)[
                        'waybill_number'=>$data[0],
                        "shipment_id"=>'Waybill number does not exists in our records.',
                    ]];
                }
            }
            $cnt++;
        }
        return $returns;
    }

    public function shipments_billing_reports($fields)
    {
        $returns=array();
        $handle=fopen($fields, 'r');
        $cnt = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($cnt > 0 && !empty($data[0]))
            {
                $this->db->select("SB.*, username");
                $this->db->where('waybill_number',$data[0]);
                $this->db->join('users U','SB.user_id=U.user_id');
                $query = $this->db->get('shipments_billing SB');
                $result= $query->result();
                if(!empty($result)){
                    $returns[]= $query->result();
                }else{
                    $returns[]= [
                        (object)[
                        'waybill_number'=>$data[0],
                        "username"=>'Invalid Waybill number'
                    ]];
                }
            }
            $cnt++;
        }
        return $returns;
    }

    public function user_agreement_accept($fields)
    {
        // _print_r($fields,1);
        $this->db->select('U.username,UA.agreement_id,UA.accepted_on,TA.agreement_title');
        $this->db->join('tbl_agreements TA','TA.agreement_id=UA.agreement_id', 'LEFT');
        $this->db->join('users U','U.user_id=UA.user_id','LEFT');
        $this->db->where('UA.agreement_id =',$fields['id']);
        $this->db->where('TA.agreement_status !=','2');
        $query = $this->db->get('users_agreements UA');
        // _print_r($this->db->last_query(),1);
        return $query->result();
    }

}
?>