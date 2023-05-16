<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		$this->session_role = !empty($this->session->userdata('user_session')['role_name'])?strtoupper($this->session->userdata('user_session')['role_name']):'';
	}
		
	public function index()
	{
		if($this->session->has_userdata('user_session'))
			redirect('dashboard');
		else
			$this->load->view('login');
	}

	public function unauthorised()
	{
		if($this->session->has_userdata('user_session'))
			$this->load->view('unauthorised');
		else
			redirect('/');
	}

	public function dashboard()
	{
		if($this->session->has_userdata('user_session'))
			$this->load->view('dashboard');
		else
			redirect('/');
	}

	/* START Tech Admin Modules  */
	public function admin_roles()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN')
				$this->load->view('admin_roles');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function admin_modules()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN')
				$this->load->view('admin_modules');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function manage_permissions()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN')
				$this->load->view('permissions');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function admin_users()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('admin_users'))
				$this->load->view('admin_users');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function master_transit_partners()
	{		
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_transit_partners'))
				$this->load->view('master_transit_partners');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function awb_generation()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('awb_generation'))
				$this->load->view('awb_generation');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}
	/* END Tech Admin Modules  */

	public function master_billing_cycle()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_billing_cycle'))
				$this->load->view('master_billing_cycle');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function master_cod_cycle()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_cod_cycle'))
				$this->load->view('master_cod_cycle');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function master_weightslab()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_weightslab'))
				$this->load->view('master_weightslab');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function master_pincodes()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_pincodes'))
				$this->load->view('master_pincodes');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function master_pinservices()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_pinservices'))
				$this->load->view('master_pinservices');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}	

	public function master_zones()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('master_zones'))
				$this->load->view('master_zones');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_manage()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users'))
				$this->load->view('users_manage');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_ratechart()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users_ratechart'))
				$this->load->view('users_ratechart');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_courierpriority()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users_courierpriority'))
				$this->load->view('users_courierpriority');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_weightslab()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users_weightslab'))
				$this->load->view('users_weightslab');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_update()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('modifyuser'))
				// $this->load->view('users_update');
				$this->load->view('users_profile_manage.php');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function complete_registration()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('complete_registration'))
				$this->load->view('complete_registration');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_registration()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users_registration'))
				$this->load->view('users_registration');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function view_addresses()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('user_addresses'))
				$this->load->view('address');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}
	
	public function users_seller()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('sellers'))
				$this->load->view('users_seller');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function update_tracking()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('update_tracking'))
				$this->load->view('tracking_update');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function change_status()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('change_status'))
				$this->load->view('change_status');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function weight_update()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('weight_update'))
				$this->load->view('weight_update');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function generate_invoice()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('generate_invoice'))
				$this->load->view('generate_invoice');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function view_invoice()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('view_invoice'))
				$this->load->view('view_invoice');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function invoice()
	{
		if($this->session->has_userdata('user_session'))
			$this->load->view('invoice');
		else
			redirect('/');
	}

	public function add_payment()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('add_payment'))
				$this->load->view('add_payment');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function generate_cod()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('generate_cod'))
				$this->load->view('generate_cod');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function view_cods()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('view_cods'))
				$this->load->view('view_cods');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function add_balance()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('manage_balance'))
				$this->load->view('add_balance');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function register_address()
	{
		if($this->session->has_userdata('user_session'))
		{
			// print_r($this->input->post());

			if(!empty($this->input->post()))
			{
				$this->load->model('Warehousemanagement_model','warehouse');

				$tracking_data = array(
					'activity_type' => "bulk_register_address",
					'log_data' => json_encode($this->input->post()),
					'admin_id' => $this->session->userdata['user_session']['admin_username'],
				);
				$warehouse_data = $this->warehouse->BulkRegisterwarehouse($this->input->post('accountid'));
				if($warehouse_data['status']=='success' && $this->insertions_model->activity_logs($tracking_data))
				{
					$output['title'] = 'Congrats';
					$output['message'] = $warehouse_data['reg_add'].' warehouse registered out of '.$warehouse_data['tot_add'];
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
                $output['message'] = 'Invalid account id, please try again';
			}
            echo json_encode($output);
		}
		else
			redirect('/');
	}

	public function users_self_registration()
	{
		if($this->session->has_userdata('user_session'))
			$this->load->view('users_self_registration');
		else
			redirect('/');
	}

	public function manual_invoice()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('manual_invoice'))
				$this->load->view('manual_invoice');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function users_module()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN')
				$this->load->view('users_modules.php');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function update_weight_request()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('user_weight_request'))
				$this->load->view('weight_update_requests');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function default_weightslab()
    {
        if($this->session->has_userdata('user_session'))
            if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('default_weightslab'))
                $this->load->view('default_weightslab');
            else
                redirect('unauthorised');
        else
            redirect('/');
    }

    public function default_ratechart()
    {
        if($this->session->has_userdata('user_session'))
            if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('default_ratechart'))
                $this->load->view('default_ratechart');
            else
                redirect('unauthorised');
        else
            redirect('/');
    }

    public function default_courier_priority()
    {
        if($this->session->has_userdata('user_session'))
            if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('default_courier_priority'))
                $this->load->view('default_courier_priority');
            else
                redirect('unauthorised');
        else
            redirect('/');
    }

	public function users_agreement()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('users_agreement'))
				$this->load->view('users_agreement');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function portal_settings()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('manual_invoice'))
				$this->load->view('site_management.php');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}
}
?>