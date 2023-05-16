<?php
class Getdata_model extends CI_Model
{
    public function get_admin_role($record_id)
    {
        $query=$this->db->select('admin_role_id, role_name, role_description')
                        ->where('admin_role_id',$record_id)
                        ->get('administrator_roles');
        //print_r($this->db->last_query());
        //print_r($query->row_array());
        return $query->row_array();
    }

    public function get_admin_module($record_id)
    {
        $query=$this->db->select('admin_module_id, parent_menu, module_name,module_route,module_description')
                        ->where('admin_module_id',$record_id)
                        ->get('administrator_modules');
        //print_r($this->db->last_query());
        //print_r($query->row_array());
        return $query->row_array();
    }

    public function get_admin_user($record_id)
    {
        $query=$this->db->select('admin_uid, admin_name, admin_phone, admin_email, admin_username, admin_password, admin_role')
                        ->where('admin_uid',$record_id)
                        ->get('admin_users');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_billingcycle($record_id)
    {
        $query=$this->db->select('billing_cycle_id, billing_cycle_title, billing_cycle_dates')
                        ->where('billing_cycle_id',$record_id)
                        ->get('master_billing_cycle');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_codcycle($record_id)
    {
        $query=$this->db->select('cod_cycle_id, cod_cycle_title, cod_cycle_dates')
                        ->where('cod_cycle_id',$record_id)
                        ->get('master_cod_cycle');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_billingdates($record_id)
    {
        $query=$this->db->select('billing_cycle_dates')
                        ->where('billing_cycle_id',$record_id)
                        ->get('master_billing_cycle');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_coddates($record_id)
    {
        $query=$this->db->select('cod_cycle_dates')
                        ->where('cod_cycle_id',$record_id)
                        ->get('master_cod_cycle');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_transitpartner($record_id)
    {
        $query=$this->db->select('transitpartner_id, transitpartner_name,transitpartner_logo ,transitpartner_description')
                        ->where('transitpartner_id',$record_id)
                        ->get('master_transit_partners');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_transitpartner_account($record_id)
    {
        $query=$this->db->select('account_id, parent_id,account_name ,account_description,account_key,account_username,account_password,base_weight')
                        ->where('account_id',$record_id)
                        ->get('master_transitpartners_accounts');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_weightslab($record_id)
    {
        $query=$this->db->select('weightslab_id, slab_title, base_weight, additional_weight')
                        ->where('weightslab_id',$record_id)
                        ->get('master_weightslab');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_pincode($record_id)
    {
        $query=$this->db->select('pincode_id, pincode, pin_city,pin_state')
                        ->where('pincode_id',$record_id)
                        ->get('tbl_pincodes');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_master_zone($record_id)
    {
        $query=$this->db->select('zone_id, source_city, destination_pin,zone')
                        ->where('zone_id',$record_id)
                        ->get('tbl_zone');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_pocdetails($record_id)
    {
        $query=$this->db->select('admin_email,admin_phone')
                        ->where('admin_uid',$record_id)
                        ->get('admin_users');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_fwdcharges($awbn,$new_wt=0)
    {
        $query_user = $this->db->select('S.user_id,S.payment_mode,S.cod_amount,S.total_amount,S.is_ndd,billing_weight')
                            ->join('shipments_billing SB', 'S.waybill_number=SB.waybill_number')
                            ->where('S.waybill_number',$awbn)
                            ->where('system_status<>','107')
                            ->get('shipments S');
        $charges_data['user'] = $query_user->row();

        $query_user_rates = $this->db->select('ndd_charges, insurance_charges, cod_fees_amt, cod_fees_per, awb_charges, fsc_rate, surcharge_3, surcharge_4, liability_amount')
                            ->where('user_id',$charges_data['user']->user_id)
                            ->limit(1)
                            ->get('users');
        $charges_data['user_rates'] = $query_user_rates->row();

        $query_shipments_rates = $this->db->select('fwd_base, fwd_addon, rto_base, rto_addon, surcharge, surcharge_2')
                            ->join('shipments S', 'S.rate_id=UR.user_rates_id')
                            ->where('UR.user_id',$charges_data['user']->user_id)
                            ->where('S.waybill_number',$awbn)
                            ->where('S.system_status<>','107')
                            ->limit(1)
                            ->get('users_rates UR');
        $charges_data['shipments_rates'] = $query_shipments_rates->row();

        $query_wtslab = $this->db->select('base_weight, additional_weight')
                    ->join('shipments S', 'S.weightslab_id=MWS.weightslab_id')
                    ->where('S.user_id',$charges_data['user']->user_id)
                    ->where('S.waybill_number',$awbn)
                    ->where('S.system_status<>','107')
                    ->limit(1)
                    ->get('master_weightslab MWS');
        $charges_data['shipments_weightslab'] = $query_wtslab->row();

        // print_r($charges_data);

        $billing_wt = $charges_data['user']->billing_weight > $new_wt ? $charges_data['user']->billing_weight : $new_wt;
       
        //Calculating Forward Charges & Units
        $fwd_base_charge=$charges_data['shipments_rates']->fwd_base;
        $additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $fwd_additional_charge= $additional_unit>0 ? $additional_unit*$charges_data['shipments_rates']->fwd_addon: 0 ;
        $forward_charges=$fwd_base_charge+$fwd_additional_charge;

        //Calculating RTO Charges & Units
        // $rto_base_charge=$charges_data['shipments_rates']->rto_base;
        // $rev_additional_unit=ceil(($charges_data['user']->billing_weight - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        // $rto_additional_charge= $rev_additional_unit>0 ? $rev_additional_unit*$charges_data['shipments_rates']->rto_addon: 0 ;
        // $rto_charges=$rto_base_charge+$rto_additional_charge;
        $rto_charges=0;

        $shipment_charges['forward_charges']=$forward_charges;
        $shipment_charges['rto_charges']=$rto_charges;
        $shipment_charges['cod_charges']=0;
        if($charges_data['user']->payment_mode=='COD')
        {
            $cod_fees_amt=$charges_data['user_rates']->cod_fees_amt;
            $cod_per_amount=($charges_data['user']->cod_amount*$charges_data['user_rates']->cod_fees_per)/100;
            $shipment_charges['cod_charges']=($cod_fees_amt>$cod_per_amount)?$cod_fees_amt:$cod_per_amount;
        }
            
        //Calculation of all other charges
        $shipment_charges['fov_charges']=($charges_data['user']->total_amount>$charges_data['user_rates']->liability_amount)?($charges_data['user']->total_amount*$charges_data['user_rates']->insurance_charges)/100:0;
        $shipment_charges['fsc_charges']=(($forward_charges+$rto_charges)*$charges_data['user_rates']->fsc_rate)/100;
        $shipment_charges['surcharge_1']=$charges_data['shipments_rates']->surcharge;
        $shipment_charges['surcharge_2 ']=$charges_data['shipments_rates']->surcharge_2;
        $shipment_charges['surcharge_3']=$charges_data['user_rates']->surcharge_3;
        $shipment_charges['surcharge_4']=$charges_data['user_rates']->surcharge_4;
        $shipment_charges['ndd_charges']=$charges_data['user']->is_ndd=='1' ? $charges_data['user_rates']->ndd_charges:0;
        $shipment_charges['awb_charges']=$charges_data['user_rates']->awb_charges;

        //Calculating total charges
        $shipment_charges['charges_total']=$shipment_charges['forward_charges']+$shipment_charges['rto_charges']+$shipment_charges['cod_charges']+$shipment_charges['fov_charges']+$shipment_charges['fsc_charges']+$shipment_charges['surcharge_1']+$shipment_charges['surcharge_2 ']+$shipment_charges['surcharge_3']+$shipment_charges['surcharge_4']+$shipment_charges['ndd_charges']+$shipment_charges['awb_charges'];
        
        $shipment_charges['gst_amount']=($shipment_charges['charges_total']*18)/100;
        $shipment_charges['total_amount']=$shipment_charges['charges_total']+$shipment_charges['gst_amount'];

        // print_r($shipment_charges);
        return $shipment_charges;
        
    }

    public function get_rtocharges($awbn,$new_wt=0)
    {
        $query_user = $this->db->select('S.user_id,S.payment_mode,S.cod_amount,S.total_amount,S.is_ndd,billing_weight')
                            ->join('shipments_billing SB', 'S.waybill_number=SB.waybill_number')
                            ->where('S.waybill_number',$awbn)
                            ->where('system_status<>','107')
                            ->get('shipments S');
        $charges_data['user'] = $query_user->row();

        $query_user_rates = $this->db->select('ndd_charges, insurance_charges, cod_fees_amt, cod_fees_per, awb_charges, fsc_rate, surcharge_3, surcharge_4, liability_amount')
                            ->where('user_id',$charges_data['user']->user_id)
                            ->limit(1)
                            ->get('users');
        $charges_data['user_rates'] = $query_user_rates->row();

        $query_shipments_rates = $this->db->select('fwd_base, fwd_addon, rto_base, rto_addon, surcharge, surcharge_2')
                            ->join('shipments S', 'S.rate_id=UR.user_rates_id')
                            ->where('UR.user_id',$charges_data['user']->user_id)
                            ->where('S.waybill_number',$awbn)
                            ->where('S.system_status<>','107')
                            ->limit(1)
                            ->get('users_rates UR');
        $charges_data['shipments_rates'] = $query_shipments_rates->row();

        $query_wtslab = $this->db->select('base_weight, additional_weight')
                    ->join('shipments S', 'S.weightslab_id=MWS.weightslab_id')
                    ->where('S.user_id',$charges_data['user']->user_id)
                    ->where('S.waybill_number',$awbn)
                    ->where('S.system_status<>','107')
                    ->limit(1)
                    ->get('master_weightslab MWS');
        $charges_data['shipments_weightslab'] = $query_wtslab->row();

        // print_r($charges_data);

        $billing_wt = $charges_data['user']->billing_weight > $new_wt ? $charges_data['user']->billing_weight : $new_wt;
       
        //Calculating Forward Charges & Units
        $fwd_base_charge=$charges_data['shipments_rates']->fwd_base;
        $additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $fwd_additional_charge= $additional_unit>0 ? $additional_unit*$charges_data['shipments_rates']->fwd_addon: 0 ;
        $forward_charges=$fwd_base_charge+$fwd_additional_charge;

        //Calculating RTO Charges & Units
        $rto_base_charge=$charges_data['shipments_rates']->rto_base;
        $rev_additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $rto_additional_charge= $rev_additional_unit>0 ? $rev_additional_unit*$charges_data['shipments_rates']->rto_addon: 0 ;
        $rto_charges=$rto_base_charge+$rto_additional_charge;

        $shipment_charges['forward_charges']=$forward_charges;
        $shipment_charges['rto_charges']=$rto_charges;
        $shipment_charges['cod_charges']=0;
        // if($charges_data['user']->payment_mode=='COD')
        // {
        //     $cod_fees_amt=$charges_data['user_rates']->cod_fees_amt;
        //     $cod_per_amount=($charges_data['user']->cod_amount*$charges_data['user_rates']->cod_fees_per)/100;
        //     $shipment_charges['cod_charges']=($cod_fees_amt>$cod_per_amount)?$cod_fees_amt:$cod_per_amount;
        // }
            
        //Calculation of all other charges
        $shipment_charges['fov_charges']=($charges_data['user']->total_amount>$charges_data['user_rates']->liability_amount)?($charges_data['user']->total_amount*$charges_data['user_rates']->insurance_charges)/100:0;
        $shipment_charges['fsc_charges']=(($forward_charges+$rto_charges)*$charges_data['user_rates']->fsc_rate)/100;
        $shipment_charges['surcharge_1']=$charges_data['shipments_rates']->surcharge;
        $shipment_charges['surcharge_2 ']=$charges_data['shipments_rates']->surcharge_2;
        $shipment_charges['surcharge_3']=$charges_data['user_rates']->surcharge_3;
        $shipment_charges['surcharge_4']=$charges_data['user_rates']->surcharge_4;
        $shipment_charges['ndd_charges']=$charges_data['user']->is_ndd=='1' ? $charges_data['user_rates']->ndd_charges:0;
        $shipment_charges['awb_charges']=$charges_data['user_rates']->awb_charges;

        //Calculating total charges
        $shipment_charges['charges_total']=$shipment_charges['forward_charges']+$shipment_charges['rto_charges']+$shipment_charges['cod_charges']+$shipment_charges['fov_charges']+$shipment_charges['fsc_charges']+$shipment_charges['surcharge_1']+$shipment_charges['surcharge_2 ']+$shipment_charges['surcharge_3']+$shipment_charges['surcharge_4']+$shipment_charges['ndd_charges']+$shipment_charges['awb_charges'];
        
        $shipment_charges['gst_amount']=($shipment_charges['charges_total']*18)/100;
        $shipment_charges['total_amount']=$shipment_charges['charges_total']+$shipment_charges['gst_amount'];

        // print_r($shipment_charges);
        return $shipment_charges;
        
    }

    public function get_invoicedata($record_id)
    {
        $query=$this->db->select('SI.*,business_name,username,tan_number')
                        ->join('users U','SI.user_id = U.user_id')
                        ->join('users_kyc UK','SI.user_id = UK.user_id')
                        ->where('px_invoice_number',$record_id)
                        ->where('invoice_status<>','2')
                        ->where('billing_type','postpaid')
                        ->get('shipments_invoices SI');
        // print_r($this->db->last_query());
        return $query->row_array();
    }

    public function get_coddata($postData)
    {
        return $this->db->get_where("shipments_cods",$postData)->row_array();
    }

    public function pincodelookup($record_id)
    {
        $query=$this->db->select('pin_city,pin_state')
                        ->where('pincode',$record_id)
                        ->limit(1)
                        ->get('tbl_pincodes');
        return $query->row_array();
    }

    public function get_allusers()
    {
        return $this->db->select('user_id')->get("users")->result_array();
    }

    public function get_users_module($record_id)
    {
        $query=$this->db->select('user_module_id, parent_menu, module_name,module_route,module_description')
                        ->where('user_module_id',$record_id)
                        ->get('userpanel_modules');
        //print_r($this->db->last_query());
        //print_r($query->row_array());
        return $query->row_array();
    }

    public function get_request_fwdcharges($awbn,$new_wt=0)
    {
        $query_user = $this->db->select('S.user_id,S.payment_mode,S.cod_amount,S.total_amount,S.is_ndd,billing_weight')
                            ->join('shipments_billing SB', 'S.waybill_number=SB.waybill_number')
                            ->where('S.waybill_number',$awbn)
                            ->where('system_status<>','107')
                            ->get('shipments S');
        $charges_data['user'] = $query_user->row();

        $query_user_rates = $this->db->select('ndd_charges, insurance_charges, cod_fees_amt, cod_fees_per, awb_charges, fsc_rate, surcharge_3, surcharge_4, liability_amount')
                            ->where('user_id',$charges_data['user']->user_id)
                            ->limit(1)
                            ->get('users');
        $charges_data['user_rates'] = $query_user_rates->row();

        $query_shipments_rates = $this->db->select('fwd_base, fwd_addon, rto_base, rto_addon, surcharge, surcharge_2')
                            ->join('shipments S', 'S.rate_id=UR.user_rates_id')
                            ->where('UR.user_id',$charges_data['user']->user_id)
                            ->where('S.waybill_number',$awbn)
                            ->where('S.system_status<>','107')
                            ->limit(1)
                            ->get('users_rates UR');
        $charges_data['shipments_rates'] = $query_shipments_rates->row();

        $query_wtslab = $this->db->select('base_weight, additional_weight')
                    ->join('shipments S', 'S.weightslab_id=MWS.weightslab_id')
                    ->where('S.user_id',$charges_data['user']->user_id)
                    ->where('S.waybill_number',$awbn)
                    ->where('S.system_status<>','107')
                    ->limit(1)
                    ->get('master_weightslab MWS');
        $charges_data['shipments_weightslab'] = $query_wtslab->row();

        // print_r($charges_data);

        $billing_wt = $new_wt;//$charges_data['user']->billing_weight > $new_wt ? $charges_data['user']->billing_weight : $new_wt;

        //Calculating Forward Charges & Units
        $fwd_base_charge=$charges_data['shipments_rates']->fwd_base;
        $additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $fwd_additional_charge= $additional_unit>0 ? $additional_unit*$charges_data['shipments_rates']->fwd_addon: 0 ;
        $forward_charges=$fwd_base_charge+$fwd_additional_charge;

        //Calculating RTO Charges & Units
        // $rto_base_charge=$charges_data['shipments_rates']->rto_base;
        // $rev_additional_unit=ceil(($charges_data['user']->billing_weight - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        // $rto_additional_charge= $rev_additional_unit>0 ? $rev_additional_unit*$charges_data['shipments_rates']->rto_addon: 0 ;
        // $rto_charges=$rto_base_charge+$rto_additional_charge;
        $rto_charges=0;

        $shipment_charges['forward_charges']=$forward_charges;
        $shipment_charges['rto_charges']=$rto_charges;
        $shipment_charges['cod_charges']=0;
        if($charges_data['user']->payment_mode=='COD')
        {
            $cod_fees_amt=$charges_data['user_rates']->cod_fees_amt;
            $cod_per_amount=($charges_data['user']->cod_amount*$charges_data['user_rates']->cod_fees_per)/100;
            $shipment_charges['cod_charges']=($cod_fees_amt>$cod_per_amount)?$cod_fees_amt:$cod_per_amount;
        }

        //Calculation of all other charges
        $shipment_charges['fov_charges']=($charges_data['user']->total_amount>$charges_data['user_rates']->liability_amount)?($charges_data['user']->total_amount*$charges_data['user_rates']->insurance_charges)/100:0;
        $shipment_charges['fsc_charges']=(($forward_charges+$rto_charges)*$charges_data['user_rates']->fsc_rate)/100;
        $shipment_charges['surcharge_1']=$charges_data['shipments_rates']->surcharge;
        $shipment_charges['surcharge_2 ']=$charges_data['shipments_rates']->surcharge_2;
        $shipment_charges['surcharge_3']=$charges_data['user_rates']->surcharge_3;
        $shipment_charges['surcharge_4']=$charges_data['user_rates']->surcharge_4;
        $shipment_charges['ndd_charges']=$charges_data['user']->is_ndd=='1' ? $charges_data['user_rates']->ndd_charges:0;
        $shipment_charges['awb_charges']=$charges_data['user_rates']->awb_charges;

        //Calculating total charges
        $shipment_charges['charges_total']=$shipment_charges['forward_charges']+$shipment_charges['rto_charges']+$shipment_charges['cod_charges']+$shipment_charges['fov_charges']+$shipment_charges['fsc_charges']+$shipment_charges['surcharge_1']+$shipment_charges['surcharge_2 ']+$shipment_charges['surcharge_3']+$shipment_charges['surcharge_4']+$shipment_charges['ndd_charges']+$shipment_charges['awb_charges'];

        $shipment_charges['gst_amount']=($shipment_charges['charges_total']*18)/100;
        $shipment_charges['total_amount']=$shipment_charges['charges_total']+$shipment_charges['gst_amount'];

        // print_r($shipment_charges);
        return $shipment_charges;

    }

    public function get_request_rtocharges($awbn,$new_wt=0)
    {
        $query_user = $this->db->select('S.user_id,S.payment_mode,S.cod_amount,S.total_amount,S.is_ndd,billing_weight')
                            ->join('shipments_billing SB', 'S.waybill_number=SB.waybill_number')
                            ->where('S.waybill_number',$awbn)
                            ->where('system_status<>','107')
                            ->get('shipments S');
        $charges_data['user'] = $query_user->row();

        $query_user_rates = $this->db->select('ndd_charges, insurance_charges, cod_fees_amt, cod_fees_per, awb_charges, fsc_rate, surcharge_3, surcharge_4, liability_amount')
                            ->where('user_id',$charges_data['user']->user_id)
                            ->limit(1)
                            ->get('users');
        $charges_data['user_rates'] = $query_user_rates->row();

        $query_shipments_rates = $this->db->select('fwd_base, fwd_addon, rto_base, rto_addon, surcharge, surcharge_2')
                            ->join('shipments S', 'S.rate_id=UR.user_rates_id')
                            ->where('UR.user_id',$charges_data['user']->user_id)
                            ->where('S.waybill_number',$awbn)
                            ->where('S.system_status<>','107')
                            ->limit(1)
                            ->get('users_rates UR');
        $charges_data['shipments_rates'] = $query_shipments_rates->row();

        $query_wtslab = $this->db->select('base_weight, additional_weight')
                    ->join('shipments S', 'S.weightslab_id=MWS.weightslab_id')
                    ->where('S.user_id',$charges_data['user']->user_id)
                    ->where('S.waybill_number',$awbn)
                    ->where('S.system_status<>','107')
                    ->limit(1)
                    ->get('master_weightslab MWS');
        $charges_data['shipments_weightslab'] = $query_wtslab->row();

        // print_r($charges_data);

        $billing_wt = $new_wt;//$charges_data['user']->billing_weight > $new_wt ? $charges_data['user']->billing_weight : $new_wt;

        //Calculating Forward Charges & Units
        $fwd_base_charge=$charges_data['shipments_rates']->fwd_base;
        $additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $fwd_additional_charge= $additional_unit>0 ? $additional_unit*$charges_data['shipments_rates']->fwd_addon: 0 ;
        $forward_charges=$fwd_base_charge+$fwd_additional_charge;

        //Calculating RTO Charges & Units
        $rto_base_charge=$charges_data['shipments_rates']->rto_base;
        $rev_additional_unit=ceil(($billing_wt - $charges_data['shipments_weightslab']->base_weight)/$charges_data['shipments_weightslab']->additional_weight);
        $rto_additional_charge= $rev_additional_unit>0 ? $rev_additional_unit*$charges_data['shipments_rates']->rto_addon: 0 ;
        $rto_charges=$rto_base_charge+$rto_additional_charge;

        $shipment_charges['forward_charges']=$forward_charges;
        $shipment_charges['rto_charges']=$rto_charges;
        $shipment_charges['cod_charges']=0;
        // if($charges_data['user']->payment_mode=='COD')
        // {
        //     $cod_fees_amt=$charges_data['user_rates']->cod_fees_amt;
        //     $cod_per_amount=($charges_data['user']->cod_amount*$charges_data['user_rates']->cod_fees_per)/100;
        //     $shipment_charges['cod_charges']=($cod_fees_amt>$cod_per_amount)?$cod_fees_amt:$cod_per_amount;
        // }

        //Calculation of all other charges
        $shipment_charges['fov_charges']=($charges_data['user']->total_amount>$charges_data['user_rates']->liability_amount)?($charges_data['user']->total_amount*$charges_data['user_rates']->insurance_charges)/100:0;
        $shipment_charges['fsc_charges']=(($forward_charges+$rto_charges)*$charges_data['user_rates']->fsc_rate)/100;
        $shipment_charges['surcharge_1']=$charges_data['shipments_rates']->surcharge;
        $shipment_charges['surcharge_2 ']=$charges_data['shipments_rates']->surcharge_2;
        $shipment_charges['surcharge_3']=$charges_data['user_rates']->surcharge_3;
        $shipment_charges['surcharge_4']=$charges_data['user_rates']->surcharge_4;
        $shipment_charges['ndd_charges']=$charges_data['user']->is_ndd=='1' ? $charges_data['user_rates']->ndd_charges:0;
        $shipment_charges['awb_charges']=$charges_data['user_rates']->awb_charges;

        //Calculating total charges
        $shipment_charges['charges_total']=$shipment_charges['forward_charges']+$shipment_charges['rto_charges']+$shipment_charges['cod_charges']+$shipment_charges['fov_charges']+$shipment_charges['fsc_charges']+$shipment_charges['surcharge_1']+$shipment_charges['surcharge_2 ']+$shipment_charges['surcharge_3']+$shipment_charges['surcharge_4']+$shipment_charges['ndd_charges']+$shipment_charges['awb_charges'];

        $shipment_charges['gst_amount']=($shipment_charges['charges_total']*18)/100;
        $shipment_charges['total_amount']=$shipment_charges['charges_total']+$shipment_charges['gst_amount'];

        // print_r($shipment_charges);
        return $shipment_charges;

    }
}
?>