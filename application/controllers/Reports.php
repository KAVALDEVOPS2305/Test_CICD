<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public function __construct()
    {
      	parent::__construct();
      	if(!$this->session->has_userdata('user_session'))
			exit();
		$this->session_role = strtoupper($this->session->userdata('user_session')['role_name']);
    }

	public function shipments()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/shipments'))
				$this->load->view('reports_shipments');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function failedshipments()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/failedshipments'))
				$this->load->view('reports_failedshipments');
			else
			redirect('unauthorised');
		else
			redirect('/');
    }

	public function mis()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/mis'))
				$this->load->view('reports_mis');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function viewbalance()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/viewbalance'))
				$this->load->view('reports_balance');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function allpayments()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/allpayments'))
				$this->load->view('reports_payments');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function alltransactions()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/alltransactions'))
				$this->load->view('reports_alltransactions');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function userledger()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/userledger'))
				$this->load->view('reports_userledger');
			else
				redirect('unauthorised');
		else
			redirect('/');
    }

	public function open_ndr()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('open_ndr'))
				$this->load->view('report_ndr');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function active_ndr()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('active_ndr'))
				$this->load->view('report_ndr_active');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function closed_ndr()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('closed_ndr'))
				$this->load->view('report_ndr_closed');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function status_logs()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/status_logs'))
				$this->load->view('reports_statuslogs');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function shipments_billing()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/billing_reports'))
				$this->load->view('report_shipmentsbilling');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function get_pickupid()
	{
		if($this->session->has_userdata('user_session'))
			if($this->session_role == 'SUPERADMIN' || $this->permissions_model->check_permission('reports/get_pickupid'))
				$this->load->view('report_getpickupids');
			else
				redirect('unauthorised');
		else
			redirect('/');
	}

	public function error_401()
	{
		if($this->session->has_userdata('user_session'))
			$this->load->view('error_401');
		else
			redirect('/');
	}
}
?>