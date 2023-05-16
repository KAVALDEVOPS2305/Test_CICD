<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actionstatusupdate extends CI_Controller
{
    public function administrator_roles()
    {
        $logdata='Status of admin_role_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_admin_role($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_admin_role',$logdata))
        {
            $output['message'] = 'Role Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function administrator_modules()
    {
        $logdata='Status of admin_module_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_admin_module($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_admin_module',$logdata))
        {
            $output['message'] = 'Module Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }


    public function administrator_users()
    {
        $logdata='Status of admin_uid '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_admin_user($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_admin_user',$logdata))
        {
            $output['message'] = 'Sub-Admin Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }


    public function master_billingcycles()
    {
        $logdata='Status of billing_cycle_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_billingcycle($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_billing_cycle',$logdata))
        {
            $output['message'] = 'Billing Cycle Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }


    public function master_codcycles()
    {
        $logdata='Status of cod_cycle_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_codcycle($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_cod_cycle',$logdata))
        {
            $output['message'] = 'COD Cycle Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function master_transitpartners()
    {
        $logdata='Status of transitpartner_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_transitpartner($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_transitpartner',$logdata))
        {
            $output['message'] = 'Transit Partner Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function master_transitpartners_accounts()
    {
        $logdata='Status of transitpartner_accounts_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_transitpartner_account($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_transitpartner',$logdata))
        {
            $output['message'] = 'Transit Partner account Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }


    public function master_weightslabs()
    {
        $logdata='Status of weightslab_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_weightslab($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_weightslab',$logdata))
        {
            $output['message'] = 'Weight-slab Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }


    public function master_users()
    {
        $logdata='Status of user_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_master_user($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_user',$logdata))
        {
            $output['message'] = 'User Status updated Successfully.';
            $output['title'] = 'Congrats';
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
        $logdata='Status of admin_module_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        if($this->statusupdate_model->status_users_module($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_admin_module',$logdata))
        {
            $output['message'] = 'Users Module Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function agreement_status()
    {
        $logdata='Status of agreement '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        // _print_r($logdata,1);
        if($this->statusupdate_model->agreement_status($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_users_module',$logdata))
        {
            $output['message'] = 'Agreement Status updated Successfully.';
            $output['title'] = 'Congrats';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }

    public function site_manage_status()
    {
        // _print_r($this->input->post(),1);
        $logdata='Status of sitemanage_id '.$this->input->post('record_id').' changed to '.$this->input->post('new_status');
        // _print_r($logdata,1);
        if($this->statusupdate_model->site_manage_status($this->input->post('record_id'),$this->input->post('new_status')) && $this->updations_model->activity_logs('status_update_site_manage',$logdata))
        {
            $output['message'] = 'Site-manage Status updated Successfully.';
            $output['title'] = 'Congrats';
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