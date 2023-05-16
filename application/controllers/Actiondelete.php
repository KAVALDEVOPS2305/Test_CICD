<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actiondelete extends CI_Controller
{
    public function administrator_roles()
    {
        $logdata = 'Deleted admin_role_id '.$this->input->post('id');
        if($this->deletions_model->del_admin_role($this->input->post('id')) && $this->updations_model->activity_logs('delete_admin_role',$logdata))
        {
            $output['message'] = 'Role Deleted Successfully.';
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

    public function college_course()
    {
        if($this->deletions_model->del_clg_course($this->input->post('id')))
            $output['message'] = 'Course Deleted Successfully.';
        else
        {
            $output['error'] = true;
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);
    }
}
?>