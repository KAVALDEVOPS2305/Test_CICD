<?php
defined('BASEPATH') or exit('No direct script access allowed');
//update  tracking
class Update_tracking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tracking_model');
		$this->load->helper('file_upload');
		$this->load->helper('excel_data_validate');
		$this->load->helper('shipmentstatus');
	}

	public function via_awb()
	{
		if (!empty($this->input->post($_FILES['awb_file'])))
		{
			$fileupload_res['uploadawb'] = excel_upload('awb_file', 'update_tracking');
			if ($fileupload_res['uploadawb']['title'] == "Success")
			{
				$query_data = read_awb_trackingdata($fileupload_res['uploadawb']['message']);
				//Sending Excel Data in Tracking Model
				list($success_count, $response_data) = $this->Tracking_model->update_status($query_data);

				$tracking_data = array(
					'activity_type' => "update_tracking",
					'log_data' => json_encode($fileupload_res['uploadawb']['message'] . "<br />\\n\\nUpdated " . $success_count . " Records out of total " . count($response_data)),
					'admin_id' => $this->session->userdata['user_session']['admin_username'],
				);
				if ($this->insertions_model->activity_logs($tracking_data))
				{
					$output['updated'] = $success_count;
					$output['errors'] = $response_data;
					$output['title'] = 'Success';
					$output['action'] = 'Updatetracking';
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
				echo json_encode($fileupload_res['uploadawb']);
		}
	}
}
