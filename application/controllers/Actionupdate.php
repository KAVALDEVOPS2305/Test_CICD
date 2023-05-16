<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actionupdate extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('file_upload');
      $this->load->helper('excel_data_validate');
      if(!$this->session->has_userdata('user_session'))
        exit();
    }

    public function administrator_roles()
    {
        $this->form_validation->set_rules('role_name', 'Role', 'required|trim|min_length[3]|edit_unique[administrator_roles.role_name.admin_role_id.role_status]');
        $this->form_validation->set_rules('role_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'role_name' => $this->input->post('role_name'),
                'role_description' => $this->input->post('role_description'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],                
            );

            $tracking_data = array(
                'activity_type' => "update_admin_role",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_admin_role($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Role Updated Successfully.';
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

    public function administrator_modules()
    {
        $this->form_validation->set_rules('module_parent', 'Parent', 'required|trim');
        $this->form_validation->set_rules('module_name', 'Module Name', 'required|trim|edit_unique_no_condition[administrator_modules.module_name.admin_module_id]');
        $this->form_validation->set_rules('module_route', 'Route', 'required|trim|edit_unique_no_condition[administrator_modules.module_route.admin_module_id]');
        $this->form_validation->set_rules('module_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'parent_menu' => $this->input->post('module_parent'),
                'module_name' => $this->input->post('module_name'),
                'module_route' => $this->input->post('module_route'),
                'module_description' => $this->input->post('module_description'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_admin_module",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_admin_module($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Module Updated Successfully.';
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

    public function administrator_users()
    {
        $this->form_validation->set_rules('admin_name', 'Fullname', 'required|trim|min_length[3]|edit_unique_no_condition[admin_users.admin_name.admin_uid]');

        $this->form_validation->set_rules('admin_phone', 'Mobile number', 'required|trim|min_length[10]|max_length[10]|edit_unique_no_condition[admin_users.admin_phone.admin_uid]');

        $this->form_validation->set_rules('admin_email', 'Email', 'required|trim|valid_email|edit_unique_no_condition[admin_users.admin_email.admin_uid]');

        $this->form_validation->set_rules('admin_username', 'Username', 'required|trim|edit_unique_no_condition[admin_users.admin_username.admin_uid]');
        $this->form_validation->set_rules('admin_password', 'Password', 'required|trim');
        $this->form_validation->set_rules('admin_role', 'Role', 'required|trim');



        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'admin_name' => $this->input->post('admin_name'),
                'admin_phone' => $this->input->post('admin_phone'),
                'admin_email' => $this->input->post('admin_email'),
                'admin_username' => $this->input->post('admin_username'),
                'admin_password' => $this->input->post('admin_password'),
                'admin_role' => $this->input->post('admin_role'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],

            );

            $tracking_data = array(
                'activity_type' => "update_admin_user",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_admin_user($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Sub-Admin Updated Successfully.';
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

    public function master_billingcycles()
    {
        $this->form_validation->set_rules('billingcycle_title', 'Title', 'required|trim|edit_unique_no_condition[master_billing_cycle.billing_cycle_title.billing_cycle_id]');
        $this->form_validation->set_rules('billingcycle_dates', 'Dates', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'billing_cycle_title' => $this->input->post('billingcycle_title'),
                'billing_cycle_dates' => $this->input->post('billingcycle_dates'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_billing_cycle",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_billingcycle($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Billing Cycle Updated Successfully.';
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

    public function master_codcycles()
    {
        $this->form_validation->set_rules('codcycle_title', 'Title', 'required|trim|edit_unique_no_condition[master_cod_cycle.cod_cycle_title.cod_cycle_id]');
        $this->form_validation->set_rules('codcycle_dates', 'Dates', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'cod_cycle_title' => $this->input->post('codcycle_title'),
                'cod_cycle_dates' => $this->input->post('codcycle_dates'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_cod_cycle",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_codcycle($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'COD Cycle Updated Successfully.';
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

    public function master_transitpartners()
    {
        $this->form_validation->set_rules('transitpartner_name', 'Partner Name', 'required|trim|edit_unique_no_condition[master_transit_partners.transitpartner_name.transitpartner_id]');
        $this->form_validation->set_rules('logo_name', 'Logo filename', 'required|trim');
        $this->form_validation->set_rules('transitpartner_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'transitpartner_name' => $this->input->post('transitpartner_name'),
                'transitpartner_logo' => $this->input->post('logo_name'),
                'transitpartner_description' => $this->input->post('transitpartner_description'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_transitpartner",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_transitpartner($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Transit Partner Updated Successfully.';
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

    public function master_transitpartners_accounts()
    {
        $this->form_validation->set_rules('account_name', 'Account Name', 'required|trim|update_unique_no_condition[master_transitpartners_accounts.account_name.account_id.cid_acc]');
        $this->form_validation->set_rules('parent_id', 'Parent', 'required');
        $this->form_validation->set_rules('base_weight', 'Account Key', 'required|trim');
        $this->form_validation->set_rules('account_key', 'Account Key', 'trim');
        $this->form_validation->set_rules('account_username', 'Account username', 'trim');
        $this->form_validation->set_rules('account_password', 'Account password', 'trim');
        $this->form_validation->set_rules('account_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'account_name' => $this->input->post('account_name'),
                'parent_id' => $this->input->post('parent_id'),
                'base_weight' => $this->input->post('base_weight'),
                'account_key' => $this->input->post('account_key'),
                'account_username' => $this->input->post('account_username'),
                'account_password' => $this->input->post('account_password'),
                'account_description' => $this->input->post('account_description'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );
            $tracking_data = array(
                'activity_type' => "update_transitpartner_accounts",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );

            if($this->updations_model->updt_master_transitpartner_account($form_data,$this->input->post('cid_acc')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Transit Partner Accounts Updated Successfully.';
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

    public function master_weightslabs()
    {
        $this->form_validation->set_rules('slab_title', 'Slab title', 'required|trim|edit_unique_no_condition[master_weightslab.slab_title.weightslab_id]');
        $this->form_validation->set_rules('base_weight', 'Base weight', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('additional_weight', 'Additional weight', 'required|trim');


        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'slab_title' => $this->input->post('slab_title'),
                'base_weight' => $this->input->post('base_weight'),
                'additional_weight' => $this->input->post('additional_weight'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_weightslab",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_weightslab($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Weight-slab Updated Successfully.';
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

    public function master_pincodes()
    {
        $this->form_validation->set_rules('f_pincode', 'Pincode', 'required|trim|edit_unique_no_condition[tbl_pincodes.pincode.pincode_id]');
        $this->form_validation->set_rules('f_pin_city', 'City', 'required|trim|strtoupper');
        $this->form_validation->set_rules('f_pin_state', 'State', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'pincode' => $this->input->post('f_pincode'),
                'pin_city' => $this->input->post('f_pin_city'),
                'pin_state' => $this->input->post('f_pin_state'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_pincode",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_pincode($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Pincode Updated Successfully.';
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

    public function master_zones()
    {
        $this->form_validation->set_rules('f_source', 'Source city', 'required|trim|strtoupper');
        $this->form_validation->set_rules('f_destination_pin', 'Destination pin', 'required|trim|min_length[6]|max_length[6]');
        $this->form_validation->set_rules('f_zone', 'Zone', 'required|trim|min_length[1]|max_length[1]|regex_match[/^[A-Fa-f]*$/]|strtoupper');

        $this->form_validation->set_message('regex_match', 'The %s must have value betwen A to F.');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'source_city' => $this->input->post('f_source'),
                'destination_pin' => $this->input->post('f_destination_pin'),
                'zone' => $this->input->post('f_zone'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_zone",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_master_zone($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Zone Updated Successfully.';
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

    public function update_user()
    {
        $this->form_validation->set_rules('fullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('contact', 'Contact', 'required|trim|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('alt_contact', 'Alt. Contact', 'trim');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
        $this->form_validation->set_rules('business_type', 'Business Type', 'required|trim');

        $this->form_validation->set_rules('billing_type', 'Billing Type', 'required|trim');
        $this->form_validation->set_rules('liability_amount', 'Liability Amount', 'required|trim');
        $this->form_validation->set_rules('ndd_charges', 'NDD Charges', 'required|trim');
        $this->form_validation->set_rules('insurance_charges', 'Insurance Charges', 'required|trim');
        $this->form_validation->set_rules('capping_amount', 'Capping Amount', 'required|trim');
        $this->form_validation->set_rules('restrict_amount', 'Restriction Amount', 'required|trim');
        $this->form_validation->set_rules('credit_period', 'Credit Period', 'required|trim');
        $this->form_validation->set_rules('token_key', 'API Token', 'required|trim');

        $this->form_validation->set_rules('codgap', 'COD Gap', 'required|trim');
        $this->form_validation->set_rules('billing_cycle_id', 'Billing Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_cycle_id', 'COD Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_fees_amt', 'COD Fees Amount', 'required|trim');
        $this->form_validation->set_rules('cod_fees_per', 'COD Fees %age', 'required|trim');
        $this->form_validation->set_rules('awb_charges', 'AWB Charges', 'trim');
        $this->form_validation->set_rules('fsc_rate', 'FSC %', 'trim');
        $this->form_validation->set_rules('surcharge_3', 'Surcharge Amount', 'trim');
        $this->form_validation->set_rules('surcharge_4', 'Surcharge %age', 'trim');

        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        $this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'required|trim');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required|trim');
        $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
        $this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');

        $this->form_validation->set_rules('kyc_pan', 'PAN', 'required|trim');
        $this->form_validation->set_rules('upload_file[kyc_pan_doc]', 'PAN Card', 'file_required');
        $this->form_validation->set_rules('kyc_gst_reg', 'GST Registration', 'required|trim');
        $this->form_validation->set_rules('kyc_doctype', 'Document Type', 'required|trim');
        $this->form_validation->set_rules('kyc_doc_number', 'KYC Doc Num', 'required|trim');
        $this->form_validation->set_rules('upload_file[kyc_document]', 'KYC Document', 'file_required');
        $this->form_validation->set_rules('tan_number', 'TAN Number', 'trim');

        $this->form_validation->set_rules('sales_poc_id', 'Sales POC', 'required|trim');
        $this->form_validation->set_rules('ops_poc_id', 'Ops POC', 'required|trim');
        $this->form_validation->set_rules('ndr_poc_id', 'NDR POC', 'required|trim');
        $this->form_validation->set_rules('pickup_poc_id', 'Pickup POC', 'required|trim');
        $this->form_validation->set_rules('finance_poc_id', 'Finance POC', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $uid = $this->input->post('uid');
            $form_data_user = array(
                // User details
                'fullname'          => $this->input->post('fullname'),
                'contact'           => $this->input->post('contact'),
                'alt_contact'       => $this->input->post('alt_contact'),
                'business_name'     => $this->input->post('business_name'),
                'business_type'     => $this->input->post('business_type'),
                // Account Setup
                'billing_type'      => $this->input->post('billing_type'),
                'liability_amount'  => $this->input->post('liability_amount'),
                'ndd_charges'       => $this->input->post('ndd_charges'),
                'insurance_charges' => $this->input->post('insurance_charges'),
                'capping_amount'    => $this->input->post('capping_amount'),
                'restrict_amount'   => $this->input->post('restrict_amount'),
                'credit_period'     => $this->input->post('credit_period'),
                'token_key'         => $this->input->post('token_key'),
                'referral_type'     => $this->input->post('referral_type'),
                'referred_by'       => $this->input->post('referred_by'),
                // billing setting
                // 'category_level' => $this->input->post('category_level'),
                'codgap'            => $this->input->post('codgap'),
                'billing_cycle_id'  => $this->input->post('billing_cycle_id'),
                'cod_cycle_id'      => $this->input->post('cod_cycle_id'),
                'cod_fees_amt'      => $this->input->post('cod_fees_amt'),
                'cod_fees_per'      => $this->input->post('cod_fees_per'),
                'awb_charges'       => $this->input->post('awb_charges'),
                'fsc_rate'          => $this->input->post('fsc_rate'),
                'surcharge_3'       => $this->input->post('surcharge_3'),
                'surcharge_4'       => $this->input->post('surcharge_4'),
                // billing details
                'billing_address'   => $this->input->post('billing_address'),
                'billing_state'     => $this->input->post('billing_state'),
                'beneficiary_name'  => $this->input->post('beneficiary_name'),
                'account_number'    => $this->input->post('account_number'),
                'ifsc_code'         => $this->input->post('ifsc_code'),
                'bank_name'         => $this->input->post('bank_name'),
                'branch_name'       => $this->input->post('branch_name'),
                // 'approved_on'       => date('Y-m-d H:i:s'),
                // 'approved_by'       => $this->session->userdata['user_session']['admin_username'],
                'updated_by'        => $this->session->userdata['user_session']['admin_username'],
            );

            $form_data_kyc = array(
                'kyc_pan' => $this->input->post('kyc_pan'),
                'kyc_gst_reg' => $this->input->post('kyc_gst_reg'),
                'kyc_doctype' => $this->input->post('kyc_doctype'),
                'kyc_doc_number' => $this->input->post('kyc_doc_number'),
                'tan_number' => $this->input->post('tan_number'),
                // 'pan_doc' => $this->input->post('kyc_pan_doc'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $form_data_poc = array(
                'sales_poc_id' => $this->input->post('sales_poc_id'),
                'ops_poc_id' => $this->input->post('ops_poc_id'),
                'ndr_poc_id' => $this->input->post('ndr_poc_id'),
                'pickup_poc_id' => $this->input->post('pickup_poc_id'),
                'finance_poc_id' => $this->input->post('finance_poc_id'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "update_user",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );

            $fileupload_updt['agreement_doc_updt'] = file_upload('agreement_doc_updt','agreements',$this->input->post('business_name'));
            $fileupload_updt['cancelled_cheque_updt'] = file_upload('cancelled_cheque_updt','cheques',$this->input->post('business_name'));
            $fileupload_updt['kyc_pan_doc_updt'] = file_upload('kyc_pan_doc_updt','pan',$this->input->post('business_name'));
            $fileupload_updt['kyc_document_updt'] = file_upload('kyc_document_updt','kyc',$this->input->post('business_name'));

            if($fileupload_updt['agreement_doc_updt']['response']=="Success")
            {
                $form_data_user['agreement_doc'] = $fileupload_updt['agreement_doc_updt']['message'];
            }
            if($fileupload_updt['cancelled_cheque_updt']['response']=="Success")
            {
                $form_data_user['cancelled_cheque'] = $fileupload_updt['cancelled_cheque_updt']['message'];
            }
            if($fileupload_updt['kyc_pan_doc_updt']['response']=="Success")
            {
                $form_data_kyc['kyc_pan_doc'] = $fileupload_updt['kyc_pan_doc_updt']['message'];
            }
            if($fileupload_updt['kyc_document_updt']['response']=="Success")
            {
                $form_data_kyc['kyc_document'] = $fileupload_updt['kyc_document_updt']['message'];
            }
            
            if($this->updations_model->user_update($form_data_user,$form_data_kyc,$form_data_poc,$uid) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'User Updated Successfully.';
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
            $output['message'] = validation_errors();
            
        }
        echo json_encode($output);
    }

    public function convert_billingtype()
    {
        if(strtoupper($this->session->userdata('user_session')['role_name']) == 'SUPERADMIN' || $this->permissions_model->check_permission('convert_billingtype'))
        {
            $tracking_data = array(
                'activity_type' => "convert_billingtype",
                'log_data'      => json_encode($this->input->post()),
                'admin_id'      => $this->session->userdata['user_session']['admin_username'],
            );

            if($this->updations_model->convert_billingtype($this->input->post()) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['message'] = 'Billing converted successfully.';
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
            $output['message'] = 'Oops, you dont have access for this.';
        }
        echo json_encode($output);
    }

    public function users_complete_register()
    {
        $this->load->helper('file_upload');
        $this->form_validation->set_rules('fullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email_id', 'Email', 'required|trim');
        $this->form_validation->set_rules('contact', 'Contact', 'required|trim|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('alt_contact', 'Alt. Contact', 'trim');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
        $this->form_validation->set_rules('business_type', 'Business Type', 'required|trim');

        $this->form_validation->set_rules('billing_type', 'Billing Type', 'required|trim');
        $this->form_validation->set_rules('liability_amount', 'Liability Amount', 'required|trim');
        $this->form_validation->set_rules('ndd_charges', 'NDD Charges', 'required|trim');
        $this->form_validation->set_rules('insurance_charges', 'Insurance Charges', 'required|trim');
        $this->form_validation->set_rules('capping_amount', 'Capping Amount', 'required|trim');
        $this->form_validation->set_rules('restrict_amount', 'Restriction Amount', 'required|trim');
        $this->form_validation->set_rules('credit_period', 'Credit Period', 'required|trim');
        if (empty($_FILES['agreement_doc']['name']))
            $this->form_validation->set_rules('agreement_doc', 'Agreement Doc', 'file_required');
        $this->form_validation->set_rules('referral_type', 'Referrer Type', 'required|trim');
        $this->form_validation->set_rules('referred_by', 'Reffered By', 'required|trim');

        $this->form_validation->set_rules('express_type[]', 'Express Type', 'required|trim');
        $this->form_validation->set_rules('weight_slab_id[]', 'Weight slab', 'required|trim');

        $this->form_validation->set_rules('category_level', 'Category', 'required|trim');
        $this->form_validation->set_rules('codgap', 'COD Gap', 'required|trim');
        $this->form_validation->set_rules('billing_cycle_id', 'Billing Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_cycle_id', 'COD Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_fees_amt', 'COD Fees Amount', 'required|trim');
        $this->form_validation->set_rules('cod_fees_per', 'COD Fees %age', 'required|trim');
        $this->form_validation->set_rules('awb_charges', 'AWB Charges', 'trim');
        $this->form_validation->set_rules('fsc_rate', 'FSC %', 'trim');
        $this->form_validation->set_rules('surcharge_3', 'Surcharge Amount', 'trim');
        $this->form_validation->set_rules('surcharge_4', 'Surcharge %age', 'trim');

        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        $this->form_validation->set_rules('upload_file[cancelled_cheque]', 'Cheque', 'file_required');
        $this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'required|trim');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required|trim');
        $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
        $this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');

        $this->form_validation->set_rules('kyc_pan', 'PAN', 'required|trim');
        $this->form_validation->set_rules('upload_file[kyc_pan_doc]', 'PAN Card', 'file_required');
        $this->form_validation->set_rules('kyc_gst_reg', 'GST Registration', 'required|trim');
        $this->form_validation->set_rules('kyc_doctype', 'Document Type', 'required|trim');
        $this->form_validation->set_rules('kyc_doc_number', 'KYC Doc Num', 'required|trim');
        $this->form_validation->set_rules('upload_file[kyc_document]', 'KYC Document', 'file_required');
        $this->form_validation->set_rules('tan_number', 'TAN Number', 'trim');

        $this->form_validation->set_rules('sales_poc_id', 'Sales POC', 'required|trim');
        $this->form_validation->set_rules('ops_poc_id', 'Ops POC', 'required|trim');
        $this->form_validation->set_rules('ndr_poc_id', 'NDR POC', 'required|trim');
        $this->form_validation->set_rules('pickup_poc_id', 'Pickup POC', 'required|trim');
        $this->form_validation->set_rules('finance_poc_id', 'Finance POC', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            // $passkey = random_string('alpha', 6);
            $uid = $this->input->post('uid');
            $form_data_user = array(
                'fullname'          => $this->input->post('fullname'),
                'email_id'          => $this->input->post('email_id'),
                'contact'           => $this->input->post('contact'),
                'alt_contact'       => $this->input->post('alt_contact'),
                'mobile_verify'     => $this->input->post('mobile_verify'),
                'email_verify'      => '1',
                'password'          => password_hash($this->input->post('passkey'), PASSWORD_BCRYPT),
                'passkey'           => $this->input->post('passkey'),
                'token_key'         => strtoupper(random_string('alnum', 30)),
                'username'          => $this->input->post('email_id'),
                'business_name'     => $this->input->post('business_name'),
                'display_name'      => $this->input->post('business_name'),
                'business_type'     => $this->input->post('business_type'),
                'billing_type'      => $this->input->post('billing_type'),
                'codadjust'         => $this->input->post('codadjust'),
                'liability_amount'  => $this->input->post('liability_amount'),
                'ndd_charges'       => $this->input->post('ndd_charges'),
                'insurance_charges' => $this->input->post('insurance_charges'),
                'capping_amount'    => $this->input->post('capping_amount'),
                'restrict_amount'   => $this->input->post('restrict_amount'),
                'credit_period'     => $this->input->post('credit_period'),
                'agreement_doc'     => $this->input->post('agreement_doc'),
                'referral_type'     => $this->input->post('referral_type'),
                'referred_by'       => $this->input->post('referred_by'),
                'category_level'    => $this->input->post('category_level'),
                'codgap'            => $this->input->post('codgap'),
                'billing_cycle_id'  => $this->input->post('billing_cycle_id'),
                'cod_cycle_id'      => $this->input->post('cod_cycle_id'),
                'cod_fees_amt'      => $this->input->post('cod_fees_amt'),
                'cod_fees_per'      => $this->input->post('cod_fees_per'),
                'awb_charges'       => $this->input->post('awb_charges'),
                'fsc_rate'          => $this->input->post('fsc_rate'),
                'surcharge_3'       => $this->input->post('surcharge_3'),
                'surcharge_4'       => $this->input->post('surcharge_4'),
                'billing_address'   => $this->input->post('billing_address'),
                'billing_state'     => $this->input->post('billing_state'),
                'cancelled_cheque'  => $this->input->post('cancelled_cheque'),
                'beneficiary_name'  => $this->input->post('beneficiary_name'),
                'account_number'    => $this->input->post('account_number'),
                'ifsc_code'         => $this->input->post('ifsc_code'),
                'bank_name'         => $this->input->post('bank_name'),
                'branch_name'       => $this->input->post('branch_name'),
                'kyc_status'        => '1',
                'approved_on'       => date('Y-m-d H:i:s'),
                'approved_by'       => $this->session->userdata['user_session']['admin_username'],
                'account_status'    => '1',
                'updated_by'        => $this->session->userdata['user_session']['admin_username'],
            );

            $form_data_balances = array(
                'main_balance'  => '0',
                'promo_balance' => '0',
                'total_balance' => '0',
                'added_by'      => 'self',
                'updated_by'    => $this->session->userdata['user_session']['admin_username'],
            );

            $alertsdata = array(
                'fullname'      => $form_data_user['fullname'],
                'businessname'  => $form_data_user['business_name'],
                'username'      => $form_data_user['username'],
                'email'         => $form_data_user['email_id'],
                'number'        => $form_data_user['contact'],
                'password'      => $form_data_user['passkey']
            );

            $express_type = $this->input->post("express_type");
            $weightslab_id = $this->input->post("weight_slab_id");

            $cnt_exp    = count($express_type);
            $cnt_wslab  = count($weightslab_id);

            if($cnt_exp > 0 && $cnt_wslab > 0 && $cnt_wslab==$cnt_exp)
            {
                for($i=0; $i<$cnt_exp; $i++)
                {
                    $form_data_wtslab[] = array(
                        'express'       => $express_type[$i],
                        'weightslab_id' => $weightslab_id[$i],
                        'updated_by'    => $this->session->userdata['user_session']['admin_username']
                    );
                }
            }

            $form_data_kyc = array(
                'kyc_pan'           => $this->input->post('kyc_pan'),
                'kyc_gst_reg'       => $this->input->post('kyc_gst_reg'),
                'kyc_doctype'       => $this->input->post('kyc_doctype'),
                'kyc_doc_number'    => $this->input->post('kyc_doc_number'),
                'tan_number'        => $this->input->post('tan_number'),
                'added_by'          => 'self',
                'updated_by'        => $this->session->userdata['user_session']['admin_username'],
            );

            // $form_data_notification = array(
            //     'transitpartner_name' => $this->input->post('transitpartner_name'),
            //     'transitpartner_description' => $this->input->post('transitpartner_description'),
            //     'added_by' => 'self',
            //     'updated_by' => $this->session->userdata['user_session']['admin_username'],
            // );

            $form_data_poc = array(
                'sales_poc_id'      => $this->input->post('sales_poc_id'),
                'ops_poc_id'        => $this->input->post('ops_poc_id'),
                'ndr_poc_id'        => $this->input->post('ndr_poc_id'),
                'pickup_poc_id'     => $this->input->post('pickup_poc_id'),
                'finance_poc_id'    => $this->input->post('finance_poc_id'),
                'added_by'          => 'self',
                'updated_by'        => $this->session->userdata['user_session']['admin_username'],
            );

            $users_temp = array(
                'account_status'    => '0'
            );

            $tracking_data = array(
                'activity_type' => "add_user",
                'log_data'      => json_encode($this->input->post()),
                'admin_id'      => $this->session->userdata['user_session']['admin_username'],
            );            

            $fileupload_res['agreement_doc'] = file_upload('agreement_doc','agreements',$this->input->post('business_name'));
            $fileupload_res['cancelled_cheque'] = file_upload('cancelled_cheque','cheques',$this->input->post('business_name'));
            $fileupload_res['kyc_pan_doc'] = file_upload('kyc_pan_doc','pan',$this->input->post('business_name'));
            $fileupload_res['kyc_document'] = file_upload('kyc_document','kyc',$this->input->post('business_name'));
            
            // $form_data_user['agreement_doc'] = file_upload('agreement_doc','agreements',$this->input->post('business_name'));

            // print_r($fileupload_res['agreement_doc']);

            if($fileupload_res['agreement_doc']['response']=="Success" && $fileupload_res['cancelled_cheque']['response']=="Success" && $fileupload_res['kyc_pan_doc']['response']=="Success" && $fileupload_res['kyc_document']['response']=="Success")
            {
                $form_data_user['agreement_doc'] = $fileupload_res['agreement_doc']['message'];
                $form_data_user['cancelled_cheque'] = $fileupload_res['cancelled_cheque']['message'];
                $form_data_kyc['kyc_pan_doc'] = $fileupload_res['kyc_pan_doc']['message'];
                $form_data_kyc['kyc_document'] = $fileupload_res['kyc_document']['message'];


                if($this->updations_model->ins_user_completeregis($form_data_user,$form_data_wtslab,$form_data_balances,$form_data_kyc,$form_data_poc,$uid, $users_temp) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = 'User Registered & Approved Successfully.';
                    $this->sendalerts_model->trigger_alerts('user_complete_registration',$alertsdata);
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
                $message="";
                $output['error'] = true;
                $output['title'] = 'Error';

                $message .= $fileupload_res['agreement_doc']['response']=="Error" ? $fileupload_res['agreement_doc']['message'] : "";
                $message .= $fileupload_res['cancelled_cheque']['response']=="Error" ? $fileupload_res['cancelled_cheque']['message']:'';
                $message .= $fileupload_res['kyc_pan_doc']['response']=="Error" ? $fileupload_res['kyc_pan_doc']['message']:'';
                $message .= $fileupload_res['kyc_document']['response']=="Error" ? $fileupload_res['kyc_document']['message']:'';

                $output['message'] = $message;
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

    public function set_permissions()
    {
        if($this->input->post('permission_type') == "role_based_permission")
            $this->form_validation->set_rules('roles_id', 'Role', 'required|trim');
        else if($this->input->post('permission_type') == "custom_based_permission")
            $this->form_validation->set_rules('admin_id', 'User', 'required|trim');

        $this->form_validation->set_rules('modules_id[]', 'Permissions', 'required|trim');
            
        if($this->form_validation->run() == true)
        {
            // $form_data = array(
            //     'roles_id' => $this->input->post('roles_id'),
            //     'modules_id' => $this->input->post('modules_id'),
            //     'updated_by' => $this->session->userdata['user_session']['admin_username'],                
            // );

            $form_data = $this->input->post();
            $form_data['updated_by'] = $this->session->userdata['user_session']['admin_username'];

            $tracking_data = array(
                'activity_type' => "set_role_permission",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );  

            if($this->permissions_model->insert_update($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Permission granted successfully.';
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
            $output['message'] = validation_errors();
        }
        echo json_encode($output);
    }

    public function update_warehouse()
    {            
        $this->form_validation->set_rules('updt_addressee', 'Addressee', 'required|regex_match[/^([a-zA-Z0-9.]|\s)+$/]|trim|min_length[3]');
        $this->form_validation->set_rules('updt_full_address', 'Full Address', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('updt_phone', 'Phone', 'required|trim|min_length[10]|max_length[12]|numeric');
        $this->form_validation->set_rules('updt_pincode', 'Pincode', 'required|trim|regex_match[/^(\d{6})$/]');
        $this->form_validation->set_rules('updt_address_city', 'Address City', 'required|trim');
        $this->form_validation->set_rules('updt_address_state', 'Address State', 'required|trim');            
        $this->form_validation->set_rules('updt_address_id', 'Address Id', 'required|trim');            
        $this->form_validation->set_rules('updt_address_title', 'Address Title', 'required|trim');            

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'address_title' => $this->input->post('updt_address_title'),
                'addressee'     => $this->input->post('updt_addressee'),
                'full_address'  => $this->input->post('updt_full_address'),
                'phone'         => $this->input->post('updt_phone'),
                'pincode'       => $this->input->post('updt_pincode'),
                'address_city'  => $this->input->post('updt_address_city'),
                'address_state' => $this->input->post('updt_address_state'),
                'updated_by'    => $this->session->userdata['user_session']['admin_username']
            );

            $tracking_data = array(
                'activity_type' => "update_warehouse_by_admin",
                'log_data'      => json_encode($this->input->post()),
                'admin_id'      => $this->session->userdata['user_session']['admin_username'],
            );

            if($this->updations_model->update_warehouse($form_data,$this->input->post('updt_address_id')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title']    = 'Congrats';
                $output['message']  = 'Address updated successfully.';
            }
            else
            {
                $output['error']    = true;
                $output['title']    = 'Error';
                $output['message']  = 'Some Error occurred, Try again.';
            }
        }
        else
        {
            $output['error']    = true;
            $output['title']    = 'Error';
            $output['message']  = validation_errors();
        }
        echo json_encode($output);
    }

    public function register_warehouse()
    {
        $this->load->model('Warehousemanagement_model','warehouse');
        $return_data = $this->warehouse->Registerwarehouse($this->input->post());
        if($return_data)
        {
            $output['message']      = 'Address Id '.$this->input->post('address_id');
            $output['response_data']  = $return_data;
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function users_modules()
    {
        $this->form_validation->set_rules('module_parent', 'Parent', 'required|trim');
        $this->form_validation->set_rules('module_name', 'Module Name', 'required|trim|edit_unique_no_condition[userpanel_modules.module_name.user_module_id]');
        $this->form_validation->set_rules('module_route', 'Route', 'required|trim|edit_unique_no_condition[userpanel_modules.module_route.user_module_id]');
        $this->form_validation->set_rules('module_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'parent_menu' => $this->input->post('module_parent'),
                'module_name' => $this->input->post('module_name'),
                'module_route' => $this->input->post('module_route'),
                'module_description' => $this->input->post('module_description'),
                'updated_by' => $this->session->userdata['user_session']['admin_username'],               
            );

            $tracking_data = array(
                'activity_type' => "update_users_module",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       
            
            if($this->updations_model->updt_users_module($form_data,$this->input->post('cid')) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Users Module Updated Successfully.';
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

    //logic for single update or reject weight requests
    public function single_update_request()
	{
        $result_data = $this->db->select('uwt_id,user_id,waybill_number,request_weight')->where('uwt_id',$this->input->post('id'))->where('request_status','0')->get('users_weight_update')->row();
        if(!empty($result_data))
        {
            $title = 'Congrats';
            $error = false;
            $request_data[] = [
                "waybill_number" => $result_data->waybill_number,
                "billing_weight" => $result_data->request_weight
            ];

            if($this->input->post('process_type') == 'approve'){
                list($success_count, $error_records) = $this->billing_model->update_weight_request($request_data);

                if(!empty($error_records) && count($error_records) > 0){
                    $title = 'Error';
                    $error = true;
                    $user_request_id = '';
                    $trackingData = [
                        'uwt_id' => $result_data->uwt_id,
                        'waybill_number' => $result_data->waybill_number,
                        'request_weight' => $result_data->request_weight,
                        'message'   => $error_records[0]['error']
                    ];
                }else{
                    $user_request_id = $result_data->uwt_id;
                    $trackingData = [
                        'uwt_id' => $result_data->uwt_id,
                        'waybill_number' => $result_data->waybill_number,
                        'request_weight' => $result_data->request_weight,
                        'message'   => "Request Approved Successfully."
                    ];
                }
            }else{
                $user_request_id = $result_data->uwt_id;
                $trackingData = [
                    'uwt_id' => $result_data->uwt_id,
                    'waybill_number' => $result_data->waybill_number,
                    'request_weight' => $result_data->request_weight,
                    'message'   => "Request Rejected Successfully."
                ];
            }
            $tracking_data = array(
                'activity_type' => ($this->input->post('process_type') == 'approve')?'users_weight_update_request':'users_weight_reject_request',
                'log_data' => json_encode($trackingData),//json_encode([$this->input->post(),$request_data]),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );

            if($user_request_id !=''){
                $this->updations_model->update_request($data=['request_status' => ($this->input->post('process_type') == 'approve')?'1':'2'],$where=['uwt_id' => $this->input->post('id')],'users_weight_update');
            }
            if($this->insertions_model->activity_logs($tracking_data))
            {
                $output['error'] = $error;
                $output['title'] = $title;//'Congrats';
                $output['message'] = $trackingData['message'];//($this->input->post('process_type') == 'approve')?'Request Approved Successfully.':'Request Rejected Successfully.';
            }
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);

	}

    // logic for bulk checkbox update or reject
    public function bulk_approve_update_request()
	{
        if(!empty($this->input->post('order_id')) && count($this->input->post('order_id'))>0)
        {
			$order_cnt = $order_cnt_err = 0;
            $prepaired_data = $trackingData = [];
            //$update_status = "";
			foreach ($this->input->post('order_id') as $order)
			{ 
                //Getting User Request Weight
                $result_data = $this->db->select('uwt_id,user_id,waybill_number,request_weight')->where('uwt_id',$order)->where('request_status','0')->get('users_weight_update')->row();

				if(!empty($result_data))
				{
					//$order_cnt++;
                    // Preapare Request Data for billing weight
                    $prepaired_data[] = [
                        "waybill_number" => $result_data->waybill_number,
                        "billing_weight" => $result_data->request_weight
                    ];
                    

                    $update_status = ($this->input->post('process_type') == "approve")?'1':'2';

                    $user_request_id = "";
                    if($this->input->post('process_type') == "approve")
                    {
                        list($success_count, $error_records) = $this->billing_model->update_weight_request($prepaired_data);
                        
                        //check if return any error from shipment billing
                        if(!empty($error_records) && count($error_records) > 0){
                            if(!in_array($result_data->waybill_number,array_column($error_records, 'waybill'))){
                                $order_cnt++;
                                $user_request_id = $result_data->uwt_id;
                                $trackingData[] = [
                                    'uwt_id' => $result_data->uwt_id,
                                    'waybill_number' => $result_data->waybill_number,
                                    'request_weight' => $result_data->request_weight,
                                    'message'   => "Success"
                                ];
                            }else{
                                $order_cnt_err++;
                                $user_request_id = "";
                                $trackingData[] = [
                                    'uwt_id' => $result_data->uwt_id,
                                    'waybill_number' => $result_data->waybill_number,
                                    'request_weight' => $result_data->request_weight,
                                    'message'   => $error_records[0]['error']
                                ];
                            }
                        }else{
                            $order_cnt++;
                            $user_request_id = $result_data->uwt_id;
                            $trackingData[] = [
                                'uwt_id' => $result_data->uwt_id,
                                'waybill_number' => $result_data->waybill_number,
                                'request_weight' => $result_data->request_weight,
                                'message'   => "Success"
                            ];
                        }
                    }else{
                        $order_cnt++;
                        $user_request_id = $result_data->uwt_id;
                        $trackingData[] = [
                            'uwt_id' => $result_data->uwt_id,
                            'waybill_number' => $result_data->waybill_number,
                            'request_weight' => $result_data->request_weight,
                            'message'   => "Success"
                        ];
                    }

                    if(!empty($user_request_id)){
                        //$this->updations_model->update_request($data = ["request_status" => $update_status],$where = ['uwt_id' => $result_data->uwt_id],'users_weight_update');
                        $this->updations_model->update_request($data = ["request_status" => $update_status],$where = ['uwt_id' => $user_request_id],'users_weight_update');
                    }

                }
			}

            $trackingData['action'] = $this->input->post('process_type');

			$tracking_data = array(
				'activity_type' => ($this->input->post('process_type') == "approve")?'users_weight_update_request_bulk':'users_weight_reject_request_bulk',
                'log_data' => json_encode($trackingData),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
			);

			if($this->insertions_model->activity_logs($tracking_data))
			{
				$output['title'] = 'Success';
				$output['message'] = $order_cnt. ' Request Update '. $order_cnt_err. ' error ' ;
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
            $output['message'] = "Selected data not valid! Please select valid data";
        }

		echo json_encode($output);
	}

    // validate excel bulk request weight update when found any error then showing preview
    public function bulk_request_updates()
    {
        $this->form_validation->set_rules('requestweight_file', 'Excel File', 'file_required|trim');
        $output = [];
        if($this->form_validation->run() == TRUE)
        {
            $fileupload_res['requestweight'] = excel_upload('requestweight_file','request_weight');
            if($fileupload_res['requestweight']['title']=="Success")
            {
                $error_data = $form_data = [];
                $error_preview ='';
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fileupload_res['requestweight']['message']);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $object = $reader->load($fileupload_res['requestweight']['message']);
                foreach($object->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestDataRow();
                    for($row=2; $row<=$highestRow; $row++)
                    {
                        $request_id      = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $user_name       = strtoupper($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $waybill_number  = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $request_weight  = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $action  = strtoupper($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                        //Getting User Request Weight
                        $result_data = $this->db->select('uwt_id,user_id,waybill_number,request_weight,request_status')->where('uwt_id',$request_id)->where('waybill_number',$waybill_number)->get('users_weight_update')->row();
                        //echo " check data "."<pre>"; print_r($result_data);
                        if(!empty($result_data)){
                            if($result_data->request_status != 0){
                                $error_data[] = array(
                                    'uwt_id' => $request_id,
                                    'username' => $user_name,
                                    'waybill_number' => $waybill_number,
                                    'billing_weight' => $request_weight,
                                    'request_status' => $action,
                                    'error'          => "<span class='text-danger'><b>This record has been already ". ($result_data->request_status=='2'? 'Rejected ':($result_data->request_status=='1'? 'Approved ':'')) ."at row # ".$row."</b></span>",

                                );
                            }else if($result_data->request_status == 0 && $action == 'A' && (!round((float)$request_weight, 2) || !round((float)$request_weight, 1) || is_numeric($request_weight) != 1) ){
                                $error_data[] = array(
                                    'uwt_id' => $request_id,
                                    'username' => $user_name,
                                    'waybill_number' => $waybill_number,
                                    'billing_weight' => $request_weight,
                                    'request_status' => $action,
                                    'error'          => "<span class='text-danger'><b>Request weight is incorrect format at row # ".$row."</b></span>",

                                );

                            }else if($result_data->request_status == 0 && ($action == 'R' || $action == 'A')){

                                $form_data[] = array(
                                    'uwt_id' => $request_id,
                                    'waybill_number' => $waybill_number,
                                    'billing_weight' => (($action == "A")?$request_weight:$result_data->request_weight),
                                    'request_status' => (($action == "R")?"2":($action == "A"?"1":"0")),
                                    'updated_by'     => $this->session->userdata['user_session']['admin_username']
                                );
                            }else{
                                $error_data[] = array(
                                    'uwt_id' => $request_id,
                                    'username' => $user_name,
                                    'waybill_number' => $waybill_number,
                                    'billing_weight' => $request_weight,
                                    'request_status' => $action,
                                    'error'          => "<span class='text-danger'><b>Only Allowed Status R (Reject) or A (Approve) at row # ".$row."</b></span>",

                                );
                            }

                        }else{
                            $error_data[] = array(
                                'uwt_id' => $request_id,
                                'username' => $user_name,
                                'waybill_number' => $waybill_number,
                                'billing_weight' => $request_weight,
                                'request_status' => $action,
                                'error'          => "<span class='text-danger'><b>This record does not match in our records at row # ".$row."</b></span>",
                            );

                        }

                    }
                }

                if(!empty($error_data))
                {
                    $error_preview .= '<table id="datatable-preview" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Request Id #</th>
                            <th class="text-center">Username #</th>
                            <th class="text-center">AWB #</th>
                            <th class="text-center">Request Wt #</th>
                            <th class="text-center">Request Status #</th>
                            <th class="text-center">Error #</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h5><b><span class="text-danger">Found: '.count($error_data). ' errors</span>.</b></h5>';

                        foreach ($error_data as $errors)
                        {
                            $error_preview .='<tr>
                                <td class="text-center">'. $errors['uwt_id'].'</td>
                                <td class="text-center">'. $errors['username'].'</td>
                                <td class="text-center">'. $errors['waybill_number'].'</td>
                                <td class="text-center">'. $errors['billing_weight'].'</td>
                                <td class="text-center">'. $errors['request_status'].'</td>
                                <td class="text-center">'. $errors['error'].'</td>
                            </tr>';
                        }

                        $error_preview .='</tbody></table><form method="post" id="form_weightupdateanyway" style="display:none;" onsubmit="return false;">';
                        foreach ($form_data as $data => $data_value)
                        {
                            $error_preview .='<input type="hidden" name="data['.$data.'][waybill_number]" value="'.$data_value['waybill_number'].'" />
                            <input type="hidden" name="data['.$data.'][billing_weight]" value="'.$data_value['billing_weight'].'" />
                            <input type="hidden" name="data['.$data.'][uwt_id]" value="'.$data_value['uwt_id'].'" />
                            <input type="hidden" name="data['.$data.'][updated_by]" value="'.$data_value['updated_by'].'" />
                            <input type="hidden" name="data['.$data.'][request_status]" value="'.$data_value['request_status'].'" />';
                        }
                        $error_preview .='<input type="hidden" name="tracking_data" value="'.$fileupload_res['requestweight']['message'].'"/></form>';
                        $error_preview .='<div class="col-md-12" style="margin-top:15px;">
                        <button type="button" onclick="reupload();" class="btn btn-sm btn-primary" id="reuploadbtn"><i class="fa fa-repeat"></i> Reupload</button>
                        <button type="button" onclick="saveanyway();" class="btn btn-sm btn-success" id="continuebtn"><i class="fa fa-save"></i> Skip Error(s) & Continue</button></div>';

                    echo json_encode(array('message' => $error_preview), JSON_HEX_QUOT | JSON_HEX_TAG);
                }else if(!empty($form_data)){
                    $data['tracking_data'] = $fileupload_res['requestweight']['message'];
                    $data['data'] = $form_data;
                    $this->excelUpdateRequestWeight($data);
                }
                //pathinfo($fileupload_res['requestweight']['message'], PATHINFO_BASENAME).'": '.$e->getMessage();

            }
            else
                $output = json_encode($fileupload_res['requestweight']);
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = validation_errors();
            echo json_encode($output);

        }
    }

    //update excel request
    public function excelUpdateRequestWeight($form_data = null){
        //$set_data = $this->input->post()?$this->input->post():$form_data;

        $excel_data = $this->input->post()?$this->input->post():$form_data;
        $set_data['tracking_data'] = $excel_data['tracking_data'];
        
        $set_data['data'] = [];
        if(!empty($excel_data['data'])){
            foreach($excel_data['data'] as $key => $value){
                if(!in_array($value['uwt_id'],array_column($set_data['data'], 'uwt_id'))){
                    $set_data['data'][] = $value;
                }
            }
        }
        
        if(!empty($set_data['data'])){

            $error_records = [];

            //Remove rejected data sending from billing weight model
            $billing_record = $set_data['data'];
            foreach($billing_record as $bkey => $b_data){
                if($b_data['request_status'] == 2){
                    unset($billing_record[$bkey]);
                }
            }

            if(count($billing_record)>0){
                list($success_count, $error_records) = $this->billing_model->update_weight_request($billing_record);
            }

            //check if error data exist then remove error data from prepair updation Data
            if(!empty($error_records) && count($error_records) > 0){
                foreach($set_data['data'] as $key => $exact_data){
                    if(in_array($exact_data['waybill_number'],array_column($error_records, 'waybill_number'))){
                        unset($set_data['data'][$key]);
                    }
                }

            }

            // bulk update for approve and reject
            $update_con = $set_data['data'];
            array_walk( $update_con, function(&$a){
                    unset($a['billing_weight']);
                    unset($a['waybill_number']);
                    //unset($a['uwt_id']);
                    unset($a['updated_by']);
            });

            //check if data is greater then zero for approval
            if(count($update_con)>0){
                //$success_count = count($update_con);
                $result = $this->db->update_batch('users_weight_update',$update_con, 'uwt_id');
                $success_count = $result;
            }

            $tracking_data = array(
                'activity_type' => "excel_weight_update_request",
                'log_data' => json_encode($set_data['tracking_data']."<br />\\n\\nUpdated ".$success_count." Records.<br />\\n\\nError Logs".json_encode($error_records)),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );
            // print_r($tracking_data);
            if($this->insertions_model->activity_logs($tracking_data))
            {
                $output['updated'] = $success_count;
                $output['errors'] = $error_records;
                $output['title'] = 'Success';
                $output['action'] = 'RequestWeightUpdate';
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
            $output['message'] = 'No data available for approval or rejection, Try again.';
        }
        echo json_encode($output);
    }

    public function update_user_new()
    {
        // $columvalue = preg_replace('/\s+/', ' ', $this->input->post('columvalue'));
        $postData = $this->input->post();
        $where = $postData['userid'];
        unset($postData['userid']);

        $tracking_data = array(
            'activity_type' => "update_user",
            'log_data'      => json_encode($this->input->post()),
            'admin_id'      => $this->session->userdata['user_session']['admin_username'],
        );
        $update_status = isset($postData['tan_number']) ? $this->updations_model->update('users_kyc',['user_id' => $where],$postData) : $this->updations_model->update('users',['user_id' => $where],$postData);
        
        if($update_status && $this->insertions_model->activity_logs($tracking_data))
        {
            $output['title'] = 'Congrats';
            $output['message'] = 'User profile Updated Successfully.';
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
?>