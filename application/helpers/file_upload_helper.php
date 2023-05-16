<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function file_upload($field,$path,$filename)
{
	// echo "fileupload -> field=>". $field . " path=>".$path." filename=>".$filename;
    $config['upload_path']   = FCPATH."/assets/uploads/clients/".$path;
    $config['allowed_types'] = "pdf|jpg|jpeg|png";
    $config['file_name']        = $filename;

    $ci =& get_instance();

    $ci->load->library('upload', $config);

    $ci->upload->initialize($config);

    if(!$ci->upload->do_upload($field))
    {
            // $error = array('error' => $ci->upload->display_errors());
            // $output['error'] = true;
            $output['response'] = 'Error';
            $output['message'] = $ci->upload->display_errors().' - '.$path;
            return $output;

            // return FALSE;
    }
    else
    {
    	$data = array('upload_data' => $ci->upload->data()); 

    	$output['response'] = 'Success';
        $output['message'] = $data['upload_data']['full_path'];
        // $output['message'] = $ci->upload->display_errors();
        return $output;
    	// return $data['upload_data']['full_path'];
    }

}



function excel_upload($field,$path)
{
    // echo "fileupload -> field=>". $field . " path=>".$path." filename=>".$filename;
    $config['upload_path']   = FCPATH."/assets/uploads/".$path;
    $config['allowed_types'] = "csv";
    $config['encrypt_name'] = TRUE;
    // $config['file_name']        = $filename;

    $ci =& get_instance();
    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);
    if(!$ci->upload->do_upload($field))
    {
        $output['error'] = true;
        $output['title'] = 'Error';
        $output['message'] = $ci->upload->display_errors();
        return $output;
    }
    else
    {
        $data = array('upload_data' => $ci->upload->data()); 
        $output['title'] = 'Success';
        $output['message'] = $data['upload_data']['full_path'];
        return $output;
    }

}

?>