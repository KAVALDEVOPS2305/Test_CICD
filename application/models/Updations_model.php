<?php
class Updations_model extends CI_Model
{
    public function updt_admin_role($formdata,$rec_id)
    {
        return $this->db->where('admin_role_id',$rec_id)
                        ->update('administrator_roles',$formdata);
    }

    public function updt_admin_module($formdata,$rec_id)
    {
        return $this->db->where('admin_module_id',$rec_id)
                        ->update('administrator_modules',$formdata);
    }

    public function updt_admin_user($formdata,$rec_id)
    {
        return $this->db->where('admin_uid',$rec_id)
                        ->update('admin_users',$formdata);
    }

    public function updt_master_billingcycle($formdata,$rec_id)
    {
        return $this->db->where('billing_cycle_id',$rec_id)
                        ->update('master_billing_cycle',$formdata);
    }

    public function updt_master_codcycle($formdata,$rec_id)
    {
        return $this->db->where('cod_cycle_id',$rec_id)
                        ->update('master_cod_cycle',$formdata);
    }


    public function updt_master_transitpartner($formdata,$rec_id)
    {
        return $this->db->where('transitpartner_id',$rec_id)
                        ->update('master_transit_partners',$formdata);
    }

    public function updt_master_transitpartner_account($formdata,$rec_id)
    {
        return $this->db->where('account_id',$rec_id)
                        ->update('master_transitpartners_accounts',$formdata);
    }

    public function updt_master_weightslab($formdata,$rec_id)
    {
        return $this->db->where('weightslab_id',$rec_id)
                        ->update('master_weightslab',$formdata);
    }

    public function updt_master_pincode($formdata,$rec_id)
    {
        return $this->db->where('pincode_id',$rec_id)
                        ->update('tbl_pincodes',$formdata);
    }

    public function updt_master_zone($formdata,$rec_id)
    {
        return $this->db->where('zone_id',$rec_id)
                        ->update('tbl_zone',$formdata);
    }

    public function activity_logs($activity,$log)
    {
        $tracking_data = array(
                'activity_type' => $activity,
                'log_data' => $log,
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );

        return $this->db->insert('admin_activity_logs',$tracking_data);
    }

    public function update($table, $where,$data) {
        $this->db->where($where);
        $update = $this->db->update($table, $data); 
        return $update;
    }

    public function user_update($form_data_user,$form_data_kyc,$form_data_poc,$uid)
    {
        $this->db->trans_start();
            $this->db->where('user_id',$uid)->update('users',$form_data_user);
            $this->db->where('user_id',$uid)->update('users_kyc',$form_data_kyc);
            $this->db->where('user_id',$uid)->update('users_poc',$form_data_poc);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    public function convert_billingtype($biling_type_data)
    {
        return $this->db->set('billing_type',$biling_type_data['new_status'])
                    ->set('updated_by',$this->session->userdata['user_session']['admin_username'])
                    ->where('user_id',$biling_type_data['record_id'])
                    ->update('users');
            // print_r($this->db->last_query());
    }

    public function ins_user_completeregis($form_data_user,$form_data_wtslab,$form_data_balances,$form_data_kyc,$form_data_poc,$uid, $users_temp)
    {

        $this->db->trans_start();
        $this->db->insert('users',$form_data_user);
        $user_id=$this->db->insert_id();

        $this->db->where('tmp_userid',$uid)->update('users_temp',$users_temp);

        $form_data_balances['user_id']=$user_id;
        $form_data_kyc['user_id']=$user_id;
        $form_data_poc['user_id']=$user_id;

        for($i=0; $i<count($form_data_wtslab); $i++)
        {
            $form_data_wtslab[$i]['user_id'] = $user_id;
        }

        $this->db->insert_batch('users_weightslabs',$form_data_wtslab);
        $this->db->insert('users_balances',$form_data_balances);
        $this->db->insert('users_kyc',$form_data_kyc);
        $this->db->insert('users_poc',$form_data_poc);
        // print_r($this->db->last_query());
        $this->db->trans_complete();

        return ($this->db->trans_status() === TRUE ? '1'  : FALSE);
    }

    public function update_warehouse($formdata,$addr_id)
    {
        // _print_r($addr_id,1);
        return $this->db->where('user_address_id',$addr_id)
                        ->update('users_address',$formdata);
    }

     public function update_batch_data($table_name,$data,$id){
        return $this->db->update_batch($table_name,$data, $id);
    }

    public function updt_users_module($formdata,$rec_id)
    {
        return $this->db->where('user_module_id',$rec_id)
                        ->update('userpanel_modules',$formdata);
    }

    public function update_request($data,$where,$table)
    {
        return $this->db->set($data)
                        ->where($where)
                        ->update($table);
    }
}

?>