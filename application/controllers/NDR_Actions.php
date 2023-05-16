<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NDR_Actions extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('NDRActions_model','NDRActions');
      if(!$this->session->has_userdata('user_session'))
		  exit();
    }

    public function Reattempt()
    {
      $ndr_response = $this->NDRActions->Reattempt($this->input->post());
      if($ndr_response['status'] == 'true')
      {
        $output['title']    = 'Congrats';
        $output['message']  = $ndr_response['message'];
      }
      else
      {
          $output['error'] = true;
          $output['title'] = 'Error';
          $output['message'] = $ndr_response['message'];
      }
      echo json_encode($output);
    }

    public function Reschedule()
    {
      $ndr_response = $this->NDRActions->Reschedule($this->input->post());
      if($ndr_response['status'] == 'true')
      {
        $output['title']    = 'Congrats';
        $output['message']  = $ndr_response['message'];
      }
      else
      {
          $output['error'] = true;
          $output['title'] = 'Error';
          $output['message'] = $ndr_response['message'];
      }
      echo json_encode($output);
    }

    public function Updatedetails()
    {
      $ndr_response = $this->NDRActions->Updatedetails($this->input->post());
      if($ndr_response['status'] == 'true')
      {
        $output['title']    = 'Congrats';
        $output['message']  = $ndr_response['message'];
      }
      else
      {
          $output['error'] = true;
          $output['title'] = 'Error';
          $output['message'] = $ndr_response['message'];
      }
      echo json_encode($output);
    }

    public function MarkRTO()
    {
      $ndr_response = $this->NDRActions->MarkRTO($this->input->post());
      if($ndr_response['status'] == 'true')
      {
        $output['title']    = 'Congrats';
        $output['message']  = $ndr_response['message'];
      }
      else
      {
          $output['error'] = true;
          $output['title'] = 'Error';
          $output['message'] = $ndr_response['message'];
      }
      echo json_encode($output);
    }
    
}
?>