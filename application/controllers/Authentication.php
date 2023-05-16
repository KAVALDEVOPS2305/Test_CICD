<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    public function check_login()
	{
		$logId = $this->insertions_model->insert('admin_loginlogs',$this->getAdminDetails($this->input->post('login_username')));

		$this->form_validation->set_rules('login_username', 'Username', 'trim|required');
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('login_password', 'Pasword', 'trim|required');

		if($this->form_validation->run())
		{
			$logged_user = $this->authenticate_model->login($this->input->post('login_username'), $this->input->post('login_password'));
	        if($logged_user)
	        {
				$logged_user['avatar'] = rand(1,10); // For Avatar icon
				$this->session->set_userdata('user_session', $logged_user);
				
				$output['message'] 	= 'Login Successfull.';
				$output['title'] 	= 'Welcome';
				$login_status 		= '1';
			}
	        else
	        {
				$output['error'] 	= true;
				$output['title'] 	= 'Sorry';
				$output['message'] 	= 'Invalid username or password.';
				$login_status 		= '0';
			}
			// echo json_encode($output);
		}
		else
		{
			$output['error'] 	= true;
			$output['title'] 	= 'Error';
			$output['message'] 	= 'Username or password cannot be blank.';
			$login_status 		= '0';
		}

		//Updating Login Response
		$this->updations_model->update('admin_loginlogs',['loginlog_id'=>$logId],['login_status'=>$login_status,'login_response'=>json_encode($output)]);

		echo json_encode($output);
    }
    
    public function logout()
    {
		$this->session->unset_userdata('user_session');
        $this->session->sess_destroy();
		redirect('/');
	}

	public function getAdminDetails($username)
	{
		$fullUserBrowser = (!empty($_SERVER['HTTP_USER_AGENT'])?
		$_SERVER['HTTP_USER_AGENT']:getenv('HTTP_USER_AGENT'));

		$userBrowser = explode(')', $fullUserBrowser);
		$deviceOs = $userBrowser[0];
		$deviceOs = explode(';',$deviceOs);
		$deviceOs = $deviceOs[1];
		$userBrowser = $userBrowser[count($userBrowser)-1];

		// logged in device details
		$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
		$isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet")); 

		$loggedDevice = "";
		if($isMob)
		{ 
			if($isTab)
				$loggedDevice = 'Tablet'; 
			else
				$loggedDevice = 'Mobile'; 
		}
		else
			$loggedDevice = 'Desktop';

		return array(
			'username'		  => $username,
			'loggedin_device' => $loggedDevice,
			'logged_browser'  => $userBrowser,
			'device_details'  => $_SERVER['HTTP_USER_AGENT'],
			'device_os'		  => $deviceOs,
			'device_ip'		  => $_SERVER['REMOTE_ADDR'],
		);
	}

}
?>