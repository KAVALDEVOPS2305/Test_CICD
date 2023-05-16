<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actiongetdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('getdata_model');

    }


    public function administrator_roles()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_admin_role($this->input->post('id'));
        echo $result['admin_role_id']."#".$result['role_name']."#".$result['role_description'];
    }


    public function administrator_modules()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_admin_module($this->input->post('id'));
        echo $result['admin_module_id']."#".$result['parent_menu']."#".$result['module_name']."#".$result['module_route']."#".$result['module_description'];
    }


    public function administrator_users()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_admin_user($this->input->post('id'));
        echo $result['admin_uid']."#".$result['admin_name']."#".$result['admin_phone']."#".$result['admin_email']."#".$result['admin_username']."#".$result['admin_password']."#".$result['admin_role'];
    }


    public function master_billingcycles()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_billingcycle($this->input->post('id'));
        echo $result['billing_cycle_id']."#".$result['billing_cycle_title']."#".$result['billing_cycle_dates'];
    }


    public function master_codcycles()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_codcycle($this->input->post('id'));
        echo $result['cod_cycle_id']."#".$result['cod_cycle_title']."#".$result['cod_cycle_dates'];
    }


    public function get_billingdates()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_billingdates($this->input->post('id'));
        echo $result['billing_cycle_dates'];
    }

    public function get_coddates()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_coddates($this->input->post('id'));
        echo $result['cod_cycle_dates'];
    }


    public function master_transitpartners()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_transitpartner($this->input->post('id'));
        echo $result['transitpartner_id']."#".$result['transitpartner_name']."#".$result['transitpartner_logo']."#".$result['transitpartner_description'];
    }

    public function master_transitpartners_accounts()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_transitpartner_account($this->input->post('id'));
        echo $result['account_id']."#".$result['parent_id']."#".$result['account_name']."#".$result['account_description']."#".$result['account_key']."#".$result['account_username']."#".$result['account_password']."#".$result['base_weight'];
    }

    
    public function master_weightslabs()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_weightslab($this->input->post('id'));
        echo $result['weightslab_id']."#".$result['slab_title']."#".$result['base_weight']."#".$result['additional_weight'];
    }

    public function master_pincodes()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_pincode($this->input->post('id'));
        echo $result['pincode_id']."#".$result['pincode']."#".$result['pin_city']."#".$result['pin_state'];
    }

    public function master_zones()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_master_zone($this->input->post('id'));
        echo $result['zone_id']."#".$result['source_city']."#".$result['destination_pin']."#".$result['zone'];
    }


    public function get_pocdetails()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_pocdetails($this->input->post('id'));
        echo $result['admin_email']."#".$result['admin_phone'];
    }

    public function get_invoicedata()
    {
        $result=$this->getdata_model->get_invoicedata($this->input->post('id'));
        echo json_encode($result);
    }

    public function get_coddata()
    {
        echo json_encode($this->getdata_model->get_coddata($this->input->post()));
    }
    
    public function generate_apikey()
    {
        $form_data = array(
            'token_key'    => strtoupper(random_string('alnum', 30))
        );

        $tracking_data = array(
            'activity_type' => "update_user_apitoken",
            'log_data' => json_encode(array($this->input->post(),$form_data)),
            'admin_id' => $this->session->userdata['user_session']['admin_username'],
        );
        
        if($this->updations_model->update('users',['user_id' => $this->input->post('userid')],$form_data) && $this->insertions_model->activity_logs($tracking_data))
        {
            $output['token_key'] =$form_data['token_key'];
            $output['title'] = 'Congrats';
            $output['message'] = 'User API Token Updated Successfully.';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['token_key'] ='';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function get_permission()
    {
		$keys = array_keys($this->input->post());
		$where[$keys[0]] = $this->input->post($keys[0]);
		$table = $this->input->post('table');
		$result = $this->permissions_model->getPermission($where,$table);
		echo json_encode($result);
	}

    public function get_address_response()
    {
        $result = $this->db->select('api_response')->where('user_address_id',$this->input->post('address_id'))->get('users_address')->row();
        echo str_replace('..!','<br/>',$result->api_response);
    }

    public function get_addressdetails()
    {
        $result = $this->db->where('user_address_id',$this->input->post('address_id'))->get('users_address')->row();
        echo $result->address_title."@".$result->addressee."@".$result->full_address."@".$result->phone."@".$result->pincode."@".$result->address_city."@".$result->address_state;
    }
    
    public function pincodelookup()
    {
        $result=$this->getdata_model->pincodelookup($this->input->post('pincode'));
        if(!empty($result))
            echo $result['pin_city']."#".$result['pin_state'];
    }

    public function users_modules()
    {
        //$record_id=$this->input->post('id');
        $result=$this->getdata_model->get_users_module($this->input->post('id'));
        echo $result['user_module_id']."#".$result['parent_menu']."#".$result['module_name']."#".$result['module_route']."#".$result['module_description'];
    }
}
?>