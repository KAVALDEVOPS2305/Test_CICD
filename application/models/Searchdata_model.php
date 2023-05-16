<?php
class Searchdata_model extends CI_Model
{
    public function search_pincode($fields,$limit='', $start='')
    {
        if (!empty($fields["pincode"]))
            $this->db->like('pincode', $fields["pincode"]);
        if (!empty($fields["pin_city"]))
            $this->db->like('pin_city', $fields["pin_city"]);
        if (!empty($fields["pin_state"]))
            $this->db->where('pin_state', $fields["pin_state"]);

        $query = $this->db->get('tbl_pincodes',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_pinservices($fields,$limit='', $start='')
    {
        if (!empty($fields["account_id"]))
            $this->db->where('account_id', $fields["account_id"]);
        if (!empty($fields["pincode"]))
            $this->db->like('pincode', $fields["pincode"]);

        $query = $this->db->get('master_pincodeserviceability',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_zone($fields,$limit='', $start='')
    {
        if (!empty($fields["source_city"]))
            $this->db->like('source_city', $fields["source_city"]);
        if (!empty($fields["destination_pin"]))
            $this->db->like('destination_pin', $fields["destination_pin"]);

        $query = $this->db->get('tbl_zone',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_user($fields,$limit='', $start='')
    {
        if (!empty($fields["username"]))
            $this->db->like('username', $fields["username"]);
        // if (!empty($fields["business_name"]))
        //     $this->db->like('business_name', $fields["business_name"]);
        // if (!empty($fields["billing_type"]))
        //     $this->db->where('billing_type', $fields["billing_type"]);
        // if (!empty($fields["billing_state"]))
        //     $this->db->where('billing_state', $fields["billing_state"]);

        $query = $this->db->where('account_status !=','0')->order_by('1','DESC')->get('users',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_invoice($fields,$limit='', $start='')
    {
        $this->db->select("SI.*, email_id,contact,alt_contact,username, business_name,billing_type,kyc_gst_reg,kyc_doc_number,credit_period");

        if(!empty($fields["px_invoice_number"]))
            $this->db->where('px_invoice_number', $fields["px_invoice_number"]);
        if(!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if(!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if(!empty($fields["billing_type"]))
            $this->db->where('billing_type', $fields["billing_type"]);
        if(!empty($fields["invoice_status"]) || $fields["invoice_status"] == '0')
            $this->db->where('SI.invoice_status', $fields["invoice_status"]);
        if(!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("SI.invoice_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");

        $this->db->join('users','users.user_id=SI.user_id','LEFT');
        $this->db->join('users_kyc','users_kyc.user_id=SI.user_id','LEFT');
        $query = $this->db->get('shipments_invoices SI',$limit, $start);
        
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_invoicepayments($sql,$limit, $start)
    {
        $query = $this->db->where('invoice_number',$sql['invoice_number'])->where('user_id',$sql['user_id'])->get('invoice_payments',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_cods($fields,$limit='', $start='')
    {
        $this->db->select("SC.*,SCT.action_against,SCT.action_date,users.user_id, email_id,contact,alt_contact,username, business_name,billing_type,beneficiary_name,account_number,ifsc_code,bank_name,codadjust,credit_period");

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
            $this->db->where("SC.cod_cycle_date BETWEEN '".date('Y-m-d', strtotime($fields["from_date"])). "' AND '".date('Y-m-d', strtotime($fields["to_date"]))."'");
            
        $this->db->join('users','users.user_id=SC.user_id','LEFT');
        $this->db->join('shipments_cods_transactions SCT','SC.cod_id=SCT.cod_id','LEFT');
        $query = $this->db->get('shipments_cods SC',$limit, $start);
        
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_shipments($fields,$limit='', $start='')
    {
        $this->db->select('username,fullname,business_name,contact,shipment_type,shipment_id,waybill_number,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,order_date,express_type,fulfilled_by,user_status,status_title,cod_amount,remark_1,account_name');
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
        $query = $this->db->get('shipments S',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_failedshipments($fields,$limit='', $start='')
    {
        $this->db->select('username,shipment_type,shipment_id,payment_mode,consignee_name,consignee_mobile, consignee_address1, consignee_address2, consignee_pincode, consignee_city,consignee_state,order_date,express_type,user_status,status_title,remark_1');
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if (!empty($fields["shipment_type"]))
            $this->db->where('shipment_type', $fields["shipment_type"]);
        if (!empty($fields["express_type"]))
            $this->db->where('express_type', $fields["express_type"]);
        if (!empty($fields["payment_mode"]))
            $this->db->where('payment_mode', $fields["payment_mode"]);
        if (!empty($fields["user_status"]))
            $this->db->where_in('user_status', $fields["user_status"]);
        if (empty($fields["user_status"]))
            $this->db->where_in('user_status', '200,220,229', false);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("order_date BETWEEN '".date('Y-m-d',strtotime($fields["from_date"])). "' AND '".date('Y-m-d',strtotime($fields["to_date"]))."'");
        
        $this->db->join('shipments_status SS','SS.status_id=S.user_status');
        $this->db->join('users U','U.user_id=S.user_id');
        $this->db->order_by('S.shipment_id', 'DESC');
        $query = $this->db->get('shipments S',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_viewbalance($fields,$limit='', $start='')
    {
        $this->db->select('username,business_name,fullname,contact,main_balance,promo_balance,total_balance,UB.updated_on');
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if (!empty($fields["amount_from"]) && !empty($fields["amount_to"]))
            $this->db->where("total_balance BETWEEN '".$fields["amount_from"]. "' AND '".$fields["amount_to"]."'");
        
        $this->db->where('billing_type','prepaid');
        $this->db->join('users U','U.user_id=UB.user_id');
        $this->db->order_by('username');
        $query = $this->db->get('users_balances UB',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function search_allpayments($fields,$limit='', $start='')
    {
        $this->db->select('username,business_name,fullname,contact,billing_type,UTXN.transaction_amount,transaction_type,TXNTYPE.transaction_remark as txn_rmk,UTXN.transaction_remark as remark,transaction_reference_id,razorpay_payment_id,razorpay_order_id,UTXN.transaction_on,UTXN.added_by');
        
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if (!empty($fields["billing_type"]))
            $this->db->where('billing_type', $fields["billing_type"]);
        if (empty($fields["transaction_type"]))
            $this->db->where_in('transaction_type', '1001,1011,1013', false);
        if (!empty($fields["transaction_type"]))
            $this->db->where_in('transaction_type', $fields["transaction_type"]);
        if (!empty($fields["transaction_reference_id"]))
            $this->db->where('transaction_reference_id', $fields["transaction_reference_id"]);
        if (!empty($fields["gateway_order_id"]))
            $this->db->where('razorpay_order_id', $fields["gateway_order_id"]);
        if (!empty($fields["amount_from"]) && !empty($fields["amount_to"]))
            $this->db->where("UTXN.transaction_amount BETWEEN '".$fields["amount_from"]. "' AND '".$fields["amount_to"]."'");
        if (!empty($fields["gateway_payment_id"]))
            $this->db->where('razorpay_payment_id', $fields["gateway_payment_id"]);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("UTXN.transaction_on BETWEEN '".date('Y-m-d H:i:s',strtotime($fields["from_date"])). "' AND '".date('Y-m-d H:i:s',strtotime($fields["to_date"]))."'");
        
        $this->db->join('transactions_razorpay TXNRZP','TXNRZP.internal_order_id=UTXN.transaction_reference_id','LEFT');
        $this->db->join('transaction_types TXNTYPE','TXNTYPE.transaction_type_id=UTXN.transaction_type');
        $this->db->join('users U','U.user_id=UTXN.user_id');
        $this->db->order_by('transaction_on','DESC');
        $query = $this->db->get('users_transactions UTXN',$limit, $start);
        // print_r("<br/><br/>".$this->db->last_query());
        return $query->result();
    }

    public function search_alltransactions($fields,$limit='', $start='')
    {
        $this->db->select('username,business_name,fullname,contact,UTXN.*,TXNTYPE.transaction_remark as txn_rmk,UTXN.transaction_remark as remark');
        
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["business_name"]))
            $this->db->where('business_name', $fields["business_name"]);
        if (!empty($fields["shipment_id"]))
            $this->db->where('shipment_id', $fields["shipment_id"]);
        if (!empty($fields["waybill_number"]))
            $this->db->where('waybill_number', $fields["waybill_number"]);
        // if (empty($fields["transaction_type"]))
        //     $this->db->where_in('transaction_type', '1001,1011,1013', false);
        if (!empty($fields["transaction_type"]))
            $this->db->where_in('transaction_type', $fields["transaction_type"]);
        if (!empty($fields["transaction_reference_id"]))
            $this->db->where('transaction_reference_id', $fields["transaction_reference_id"]);
        if (!empty($fields["action_type"]))
            $this->db->where('action_type', $fields["action_type"]);
        if (!empty($fields["balance_type"]))
            $this->db->where('balance_type', $fields["balance_type"]);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("transaction_on BETWEEN '".date('Y-m-d H:i:s',strtotime($fields["from_date"])). "' AND '".date('Y-m-d H:i:s',strtotime($fields["to_date"]))."'");
        
        $this->db->join('transaction_types TXNTYPE','TXNTYPE.transaction_type_id=UTXN.transaction_type');
        $this->db->join('users U','U.user_id=UTXN.user_id');
        $this->db->order_by('transaction_on','DESC');
        $query = $this->db->get('users_transactions UTXN',$limit, $start);
        // print_r("<br/><br/>".$this->db->last_query());
        return $query->result();
    }

    public function search_userledger($fields,$limit='', $start='')
    {
        $this->db->select('username,business_name,fullname,contact,UTXN.*,UTXN.transaction_remark as remark,TXNTYPE.transaction_remark as txn_rmk');
        
        if (!empty($fields["username"]))
            $this->db->where('username', $fields["username"]);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("transaction_on BETWEEN '".date('Y-m-d H:i:s',strtotime($fields["from_date"])). "' AND '".date('Y-m-d H:i:s',strtotime($fields["to_date"]))."'");
        
        $this->db->join('transaction_types TXNTYPE','TXNTYPE.transaction_type_id=UTXN.transaction_type');
        $this->db->join('users U','U.user_id=UTXN.user_id');
        $this->db->order_by('transaction_on','DESC');
        $query = $this->db->get('users_transactions UTXN',$limit, $start);
        // print_r("<br/><br/>".$this->db->last_query());
        return $query->result();
    }

    public function address_user($fields,$limit='', $start='')
    {
        // print_r($fields);
        $this->db->select('UA.*,business_name, username');
        if (!empty($fields["username"]))
            $this->db->like('username', $fields["username"]);
        if (!empty($fields["address_title"]))
            $this->db->like('address_title', $fields["address_title"]);
        if ($fields["address_status"]!='')
            $this->db->where('address_status', $fields["address_status"]);
        if (!empty($fields["pincode"]))
            $this->db->where('pincode', $fields["pincode"]);
        if (!empty($fields["address_city"]))
            $this->db->like('address_city', $fields["address_city"]);
        if (!empty($fields["address_state"]))
            $this->db->where('address_state', $fields["address_state"]);

        $this->db->where('address_status!=','2');
        $this->db->join('users U','UA.user_id=U.user_id');
        $query = $this->db->get('users_address UA',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }
     //user's seller model
    public function search_user_seller($fields,$limit='', $start='')
    {
        $this->db->select('US.*,username');
        $this->db->where('seller_status !=','0');
        if (!empty($fields["username"]))
            $this->db->like('username', $fields["username"]);
        if (!empty($fields["seller_name"]))
            $this->db->like('seller_name', $fields["seller_name"]);
        
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("US.added_on BETWEEN '".date('Y-m-d h-i-s',strtotime($fields["from_date"])). "' AND '".date('Y-m-d h-i-s',strtotime($fields["to_date"]))."'");
        
        $this->db->join('users U','U.user_id=US.user_id');
        $this->db->order_by('US.seller_id', 'ASC');
        $query = $this->db->get('users_seller US',$limit, $start);

        //print_r($this->db->last_query());
        return $query->result();
    }

    public function pregenerated_awbs($fields,$limit='', $start='')
    {
        if (!empty($fields["transit_partner"]))
            $this->db->where('transit_partner', $fields["transit_partner"]);
        if (!empty($fields["shipment_type"]))
            $this->db->where('shipment_type', $fields["shipment_type"]);
        if (!empty($fields["pay_mode"]))
            $this->db->where('pay_mode', $fields["pay_mode"]);
        if (!empty($fields["waybill_status"]) || $fields["waybill_status"] == '0')
            $this->db->where('waybill_status', $fields["waybill_status"]);

        $query = $this->db->get('pregenerated_awbs',$limit, $start);
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function report_ndr_shipments($fields,$limit='', $start='')
    {
        $this->db->select('NDR.*,SS.status_title,S.consignee_name, S.consignee_address1,S.consignee_address2,S.consignee_mobile,S.consignee_phone,S.consignee_pincode, S.consignee_city, S.consignee_state,S.payment_mode,S.cod_amount,S.invoice_value,S.user_status,S.order_date,S.express_type,S.shipment_type,S.invoice_number,SSL.ofd_attempts,SSL.ofd_all,UA.*,MTPA.account_name');

        if (!empty($fields["user_id"]))
            $this->db->where_in('U.user_id', $fields["user_id"]);
        if (!empty($fields["waybill_number"]))
            $this->db->like('NDR.waybill_number', $fields["waybill_number"]);
        if (!empty($fields["shipment_id"]))
            $this->db->where('NDR.shipment_id', $fields["shipment_id"]);
        if (!empty($fields["payment_mode"]))
            $this->db->where('payment_mode', $fields["payment_mode"]);
        if (!empty($fields["fulfilled_by"]))
            $this->db->where_in('S.fulfilled_by', $fields["fulfilled_by"]);
        if (!empty($fields["fulfilled_account"]))
            $this->db->where_in('MTPA.account_id', $fields["fulfilled_account"]);
        if (!empty($fields["ndr_status_id"]))
            $this->db->where_in('latest_ndr_code', $fields["ndr_status_id"]);
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("latest_courier_timestamp BETWEEN '".date('Y-m-d H:i:s', strtotime($fields["from_date"])). "' AND '".date('Y-m-d H:i:s', strtotime($fields["to_date"]))."'");
        
        $this->db->where('NDR.ndr_status',$fields["ndr_status"]);
        $this->db->where_not_in('user_status','200,220,229', false);
        $this->db->join('shipments S','NDR.shipment_id=S.shipment_id AND NDR.waybill_number=S.waybill_number');
        $this->db->join('shipments_status SS','SS.status_id=S.user_status');
        $this->db->join('users U','NDR.user_id=U.user_id','LEFT');
        $this->db->join('shipments_statuses_logs SSL','SSL.waybill_number=NDR.waybill_number AND SSL.shipment_id=NDR.shipment_id','LEFT');
        $this->db->join('users_address UA','UA.user_address_id=S.pick_address_id','LEFT');
        $this->db->join('master_transitpartners_accounts MTPA','MTPA.account_id=S.fulfilled_account','left');
        $query = $this->db->get('ndr_logs NDR',$limit, $start);
        // print_r("<br/><br/>".$this->db->last_query());
        return $query->result();
    }

    public function report_pickup_id()
    {
        $orderIds = array_filter(explode(",",$this->input->post('order_id')));
        $query=$this->db->select('event_id,response')
            ->where('event_name','PickupRequest')
            ->where_in('event_id',$orderIds)
            ->get('tbl_pushedapilogs');
        if($query->num_rows()>0)
            return $query->result_array();
        else
            return [];
    }

    public function select_result_array($select_data,$where,$table_name){
        return $this->db->select($select_data)->where($where)->get($table_name)->result_array();
    }

    public function search_weightrequest($fields,$limit='', $start='')
    {
        $this->db->select('uwu.uwt_id,U.username,uwu.waybill_number,sb.given_weight,sb.billing_weight,uwu.request_weight,uwu.request_status');
        if (!empty($fields["username"]))
            $this->db->like('username', trim($fields["username"]));
        if (!empty($fields["waybill_number"]))
            $this->db->where('uwu.waybill_number', $fields["waybill_number"]);
        if (!empty($fields["request_status"]))
            $this->db->where_in('request_status', $fields["request_status"]);
        // if (empty($fields["request_status"]))
        //     $this->db->where_in('request_status', '0');
        if (!empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("uwu.added_on BETWEEN '".date('Y-m-d H:i:s',strtotime($fields["from_date"])). "' AND '".date('Y-m-d H:i:s',strtotime($fields["to_date"]))."'");
        if (!empty($fields["from_date"]) && empty($fields["to_date"]))
            $this->db->where("uwu.added_on >=",date('Y-m-d H:i:s',strtotime($fields["from_date"])));
        if (empty($fields["from_date"]) && !empty($fields["to_date"]))
            $this->db->where("uwu.added_on <=",date('Y-m-d H:i:s',strtotime($fields["to_date"])));

        $this->db->join('shipments_billing sb','sb.waybill_number = uwu.waybill_number and sb.user_id = uwu.user_id');
        $this->db->join('users U','uwu.user_id=U.user_id');
        $this->db->order_by("uwt_id", "desc");
        $query = $this->db->get('users_weight_update uwu');
        return $query->result();
    }
}
?>