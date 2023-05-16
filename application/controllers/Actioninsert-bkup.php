<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actioninsert extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('file_upload');
      $this->load->helper('excel_data_validate');
    }

    /* For Admin Roles */
    public function administrator_roles()
    {
        $this->form_validation->set_rules('role_name', 'Role', 'required|trim|custom_unique[administrator_roles.role_name.role_status]|min_length[3]');
        $this->form_validation->set_rules('role_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'role_name' => $this->input->post('role_name'),
                'role_description' => $this->input->post('role_description'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_admin_role",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_admin_role($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Role Saved Successfully.';
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


    /* For Module  */
    public function administrator_modules()
    {
        $this->form_validation->set_rules('module_parent', 'Parent', 'required|trim');
        $this->form_validation->set_rules('module_name', 'Module Name', 'required|trim|is_unique[administrator_modules.module_name]');
        $this->form_validation->set_rules('module_route', 'Route', 'required|trim|is_unique[administrator_modules.module_route]');
        $this->form_validation->set_rules('module_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'parent_menu' => $this->input->post('module_parent'),
                'module_name' => $this->input->post('module_name'),
                'module_route' => $this->input->post('module_route'),
                'module_description' => $this->input->post('module_description'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_admin_module",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_admin_modules($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Module Saved Successfully.';
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




    /* For Sub-Admins  */
    public function administrator_users()
    {
        $this->form_validation->set_rules('admin_name', 'Fullname', 'required|trim|min_length[3]|is_unique[admin_users.admin_name]');

        $this->form_validation->set_rules('admin_phone', 'Mobile number', 'required|trim|min_length[10]|max_length[10]|is_unique[admin_users.admin_phone]');

        $this->form_validation->set_rules('admin_email', 'Email', 'required|trim|valid_email|is_unique[admin_users.admin_email]');

        $this->form_validation->set_rules('admin_username', 'Username', 'required|trim|is_unique[admin_users.admin_username]');
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
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_admin_user",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_admin_user($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Sub-Admin Saved Successfully.';
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



    /* For Billing Cycle  */
    public function master_billingcycles()
    {
        $this->form_validation->set_rules('billingcycle_title', 'Title', 'required|trim|is_unique[master_billing_cycle.billing_cycle_title]');
        $this->form_validation->set_rules('billingcycle_dates', 'Dates', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'billing_cycle_title' => $this->input->post('billingcycle_title'),
                'billing_cycle_dates' => $this->input->post('billingcycle_dates'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_billing_cycle",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_master_billingcycle($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Billing Cycle Saved Successfully.';
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


    /* For COD Cycle  */
    public function master_codcycles()
    {
        $this->form_validation->set_rules('codcycle_title', 'Title', 'required|trim|is_unique[master_cod_cycle.cod_cycle_title]');
        $this->form_validation->set_rules('codcycle_dates', 'Dates', 'required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'cod_cycle_title' => $this->input->post('codcycle_title'),
                'cod_cycle_dates' => $this->input->post('codcycle_dates'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_cod_cycle",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_master_codcycle($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'COD Cycle Saved Successfully.';
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


    /* For Transit Partners  */
    public function master_transitpartners()
    {
        $this->form_validation->set_rules('transitpartner_name', 'Partner Name', 'required|trim|is_unique[master_transit_partners.transitpartner_name]');
        $this->form_validation->set_rules('transitpartner_description', 'Description', 'trim');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'transitpartner_name' => $this->input->post('transitpartner_name'),
                'transitpartner_description' => $this->input->post('transitpartner_description'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_transitpartner",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_master_transitpartner($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Transit Partner Saved Successfully.';
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


    /* For Pincodes  */
    public function master_pincodes()
    {
        $this->form_validation->set_rules('f_pincode', 'Pincode', 'required|trim|is_unique[tbl_pincodes.pincode]');
        $this->form_validation->set_rules('f_pin_city', 'City', 'required|trim|strtoupper');
        $this->form_validation->set_rules('f_pin_state', 'State', 'required|trim');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'pincode' => $this->input->post('f_pincode'),
                'pin_city' => $this->input->post('f_pin_city'),
                'pin_state' => $this->input->post('f_pin_state'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_pincode",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_master_pincode($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Pincode Saved Successfully.';
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


    /* For Weight Slab  */
    public function master_weightslabs()
    {
        $this->form_validation->set_rules('slab_title', 'Slab title', 'required|trim|is_unique[master_weightslab.slab_title]');
        $this->form_validation->set_rules('base_weight', 'Base weight', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('additional_weight', 'Additional weight', 'required|trim');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');

        if($this->form_validation->run() == TRUE)
        {
            $form_data = array(
                'slab_title' => $this->input->post('slab_title'),
                'base_weight' => $this->input->post('base_weight'),
                'additional_weight' => $this->input->post('additional_weight'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $tracking_data = array(
                'activity_type' => "add_weight_slab",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_master_weightslab($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Weight-slab Saved Successfully.';
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



    // For Data Preview 
    public function preview_data()
    {
        $fileupload_res['zone'] = excel_upload('zone_file','zones');

        if($fileupload_res['zone']['title']=="Success")
        {
            // print_r($fileupload_res['zone']);
            list($form_data, $error_data) = read_zonedata($fileupload_res['zone']['message']);
            $output ='';
            if(!empty($error_data))
            {
                $output .= '<table id="datatable-preview" class="table table-vcenter table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Source City</th>
                        <th class="text-center">Destination Pincode</th>
                        <th class="text-center">Zone</th>
                        <th class="text-center">Error</th>
                    </tr>
                </thead>
                <tbody>
                    <h5><b><span class="text-danger">Found: '.count($error_data). ' errors</span>.</b></h5>';

                    foreach ($error_data as $errors)
                    {
                        $output .='<tr>
                            <td class="text-center">'. $errors['source_city'].'</td>
                            <td class="text-center">'. $errors['destination_pin'].'</td>
                            <td class="text-center">'. $errors['zone'].'</td>
                            <td class="text-center">'. $errors['error'].'</td>
                        </tr>';
                    }

                    $output .='</tbody></table><form method="post" id="form_savezonesanyway" style="display:none;" onsubmit="return false;">';
                    foreach ($form_data as $data => $data_value)
                    {
                        $output .='<input type="hidden" name="data['.$data.'][source_city]" value="'.$data_value['source_city'].'" />
                        <input type="hidden" name="data['.$data.'][destination_pin]" value="'.$data_value['destination_pin'].'" />
                        <input type="hidden" name="data['.$data.'][zone]" value="'.$data_value['zone'].'" />
                        <input type="hidden" name="data['.$data.'][added_by]" value="'.$data_value['added_by'].'" />
                        <input type="hidden" name="data['.$data.'][updated_by]" value="'.$data_value['updated_by'].'" />';
                    }
                    $output .='<input type="hidden" name="tracking_data" value="'.$fileupload_res['zone']['message'].'"/></form>';
                    $output .='<div class="col-md-12" style="margin-top:15px;">
                    <button type="button" onclick="reupload();" class="btn btn-sm btn-primary" id="reuploadbtn"><i class="fa fa-repeat"></i> Reupload</button>
                    <button type="button" onclick="saveanyway();" class="btn btn-sm btn-success" id="continuebtn"><i class="fa fa-save"></i> Skip Error(s) & Continue</button></div>';

                echo json_encode(array('message' => $output), JSON_HEX_QUOT | JSON_HEX_TAG);
            }
            else
            {
                $tracking_data = array(
                    'activity_type' => "add_import_zones",
                    'log_data' => json_encode($fileupload_res['zone']),
                    'admin_id' => $this->session->userdata['user_session']['admin_username'],
                );

                if($this->insertions_model->ins_master_zones($form_data) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = count($form_data).' Records imported successfully.';
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
        else
            echo json_encode($fileupload_res['zone']);
    }




     /* For Save Anyway Zones  */
    public function master_zones()
    {
        // print_r($this->input->post());
        // print_r($this->input->post('tracking_data'));
        // print_r($this->input->post('data'));


        // die();


        $tracking_data = array(
            'activity_type' => "add_import_zones",
            'log_data' => json_encode($this->input->post('tracking_data')),
            'admin_id' => $this->session->userdata['user_session']['admin_username'],
        );

        if($this->insertions_model->ins_master_zones($this->input->post('data')) && $this->insertions_model->activity_logs($tracking_data))
        {
            $output['title'] = 'Congrats';
            $output['message'] = count($this->input->post('data')).' Records imported successfully.';
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = 'Some Error occurred, Try again.';
        }
        echo json_encode($output);






        die();

        $config['upload_path']   = "H:/wamp64/www/ParcelX/Portal\assets/uploads/zones/";
        $config['allowed_types'] = "xlsx|csv|xls";
        // $config['file_name']        = date("d-m-Y") . "-" . time();

        // echo $config['upload_path'];

        $this->load->library('upload', $config);
        // $this->load->helper('excel_data_validate');
        $this->upload->initialize($config); 

        if(!$this->upload->do_upload('zone_file'))
        {
                // $error = array('error' => $this->upload->display_errors());
                $output['error'] = true;
                $output['title'] = 'File Upload Error';
                $output['message'] = $this->upload->display_errors();
                echo json_encode($output);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());        

            $inputFileName = $data['upload_data']['full_path'];
            // echo $inputFileName;
            $error_data = array();
            $error_cnt=0;
            try
            {
                $object = PHPExcel_IOFactory::load($inputFileName);
                foreach($object->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++)
                    {
                        $source_city = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $destination_pin = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $zone = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        if((preg_match('/^[a-zA-Z0-9\s\-_.,&]*$/', $source_city)) AND (preg_match('/^(\d{6})$/', $destination_pin)) AND (preg_match('/^[a-fA-F]*$/', $zone)))
                        {
                            $form_data[] = array(
                                'source_city'       => strtoupper($source_city),
                                'destination_pin'   => $destination_pin,
                                'zone'              => strtoupper($zone),
                                'added_by'          => $this->session->userdata['user_session']['admin_username'],
                                'updated_by'        => $this->session->userdata['user_session']['admin_username']
                            );
                        }
                        else
                        {
                            if(!preg_match('/^[a-zA-Z0-9\s\-_.,&]*$/', $source_city))
                            {
                                $error_data[] = array(
                                    'source_city'       => strtoupper($source_city),
                                    'destination_pin'   => $destination_pin,
                                    'zone'              => strtoupper($zone),
                                    'error'             => "Invalid city name",
                                );
                            }

                            else if(!preg_match('/^(\d{6})$/', $destination_pin))
                            {
                                $error_data[] = array(
                                    'source_city'       => strtoupper($source_city),
                                    'destination_pin'   => $destination_pin,
                                    'zone'              => strtoupper($zone),
                                    'error'             => "Invalid pincode",
                                );
                            }

                            else if(!preg_match('/^[a-fA-F]*$/', $zone))
                            {
                                $error_data[] = array(
                                    'source_city'       => strtoupper($source_city),
                                    'destination_pin'   => $destination_pin,
                                    'zone'              => strtoupper($zone),
                                    'error'             => "Invalid zone",
                                );

                            }
                        }
                    }
                }

                //Pending - Excel File Data COntent Validation
                // echo validate_zonedata($source_city,$destination_pin,$zone);

                print_r($form_data);

                print_r($error_data);
                die();

                $tracking_data = array(
                    'activity_type' => "add_import_zones",
                    'log_data' => json_encode($data['upload_data']),
                    'admin_id' => $this->session->userdata['user_session']['admin_username'],
                );

                if($this->insertions_model->ins_master_zones($form_data) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = count($form_data).' Records imported successfully.';
                }
                else
                {
                    $output['error'] = true;
                    $output['title'] = 'Error';
                    $output['message'] = 'Some Error occurred, Try again.';
                }
            }
            catch(Exception $e)
            {
                $output['error'] = true;
                $output['title'] = 'Error importing file';
                $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
            }

            echo json_encode($output);
        } 
    }

  



    /* For Complete User Registration  */
    public function users_registercomplete()
    {
        $this->load->helper('file_upload');

        $this->form_validation->set_rules('fullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email_id', 'Email', 'required|trim|is_unique[users.email_id]|valid_email');
        $this->form_validation->set_rules('contact', 'Contact', 'required|trim|is_unique[users.contact]|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('alt_contact', 'Alt. Contact', 'trim|is_unique[users.alt_contact]');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
        $this->form_validation->set_rules('business_type', 'Business Type', 'required|trim');

        $this->form_validation->set_rules('billing_type', 'Billing Type', 'required|trim');
        $this->form_validation->set_rules('liability_amount', 'Liability Amount', 'required|trim');
        // $this->form_validation->set_rules('rto_charges', 'RTO Charges', 'required|trim');
        $this->form_validation->set_rules('insurance_charges', 'Insurance Charges', 'required|trim');
        $this->form_validation->set_rules('capping_amount', 'Capping Amount', 'required|trim');
        $this->form_validation->set_rules('restrict_amount', 'Restriction Amount', 'required|trim');
        $this->form_validation->set_rules('credit_period', 'Credit Period', 'required|trim');
        if (empty($_FILES['agreement_doc']['name']))
        {
            $this->form_validation->set_rules('agreement_doc', 'Agreement Doc', 'file_required');
        }
        // $this->form_validation->set_rules('upload_file[agreement_doc]', 'Agreement Doc', 'file_required');
        $this->form_validation->set_rules('referral_type', 'Referrer Type', 'required|trim');
        $this->form_validation->set_rules('referred_by', 'Reffered By', 'required|trim');

        $this->form_validation->set_rules('express_type[]', 'Express Type', 'required|trim');
        $this->form_validation->set_rules('weight_slab_id[]', 'Weight slab', 'required|trim');
        
        // $this->form_validation->set_rules('normal_surface_a', 'Zone A Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_surface_b', 'Zone B Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_surface_c', 'Zone C Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_surface_d', 'Zone D Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_surface_e', 'Zone E Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_air_a', 'Zone A Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_air_b', 'Zone B Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_air_c', 'Zone C Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_air_d', 'Zone D Rate', 'required|trim');
        // $this->form_validation->set_rules('normal_air_e', 'Zone E Rate', 'required|trim');
        // $this->form_validation->set_rules('heavy_surface_a', 'Zone A Rate', 'required|trim');
        // $this->form_validation->set_rules('heavy_surface_b', 'Zone B Rate', 'required|trim');
        // $this->form_validation->set_rules('heavy_surface_c', 'Zone D Rate', 'required|trim');
        // $this->form_validation->set_rules('heavy_surface_d', 'Zone D Rate', 'required|trim');
        // $this->form_validation->set_rules('heavy_surface_e', 'Zone E Rate', 'required|trim');

        $this->form_validation->set_rules('category_level', 'Category', 'required|trim');
        $this->form_validation->set_rules('codgap', 'COD Gap', 'required|trim');
        $this->form_validation->set_rules('billing_cycle_id', 'Billing Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_cycle_id', 'COD Cycle', 'required|trim');
        $this->form_validation->set_rules('cod_fees_amt', 'COD Fees Amount', 'required|trim');
        $this->form_validation->set_rules('cod_fees_per', 'COD Fees %age', 'required|trim');

        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        $this->form_validation->set_rules('upload_file[cancelled_cheque]', 'Cheque', 'file_required');
        $this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'required|trim');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required|trim|is_unique[users.account_number]');
        $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
        $this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');

        $this->form_validation->set_rules('kyc_pan', 'PAN', 'required|trim|is_unique[users_kyc.kyc_pan]');
        $this->form_validation->set_rules('upload_file[kyc_pan_doc]', 'PAN Card', 'file_required');
        $this->form_validation->set_rules('kyc_gst_reg', 'GST Registration', 'required|trim');
        $this->form_validation->set_rules('kyc_doctype', 'Document Type', 'required|trim');
        $this->form_validation->set_rules('kyc_doc_number', 'KYC Doc Num', 'required|trim|is_unique[users_kyc.kyc_doc_number]');
        // if (empty($_FILES['kyc_document']['name']))
        // {
        //     $this->form_validation->set_rules('kyc_document', 'KYC', 'required');
        // }
        $this->form_validation->set_rules('upload_file[kyc_document]', 'KYC Document', 'file_required');

        // $this->form_validation->set_rules('priority_1', 'Priority 1', 'required|differs[priority_2]|differs[priority_3]');
        // $this->form_validation->set_rules('priority_2', 'Priority 2', 'required|differs[priority_1]|differs[priority_3]');
        // $this->form_validation->set_rules('priority_3', 'Priority 3', 'required|differs[priority_1]|differs[priority_2]');

        $this->form_validation->set_rules('sales_poc_id', 'Sales POC', 'required|trim');
        $this->form_validation->set_rules('ops_poc_id', 'Ops POC', 'required|trim');
        $this->form_validation->set_rules('ndr_poc_id', 'NDR POC', 'required|trim');
        $this->form_validation->set_rules('pickup_poc_id', 'Pickup POC', 'required|trim');
        $this->form_validation->set_rules('finance_poc_id', 'Finance POC', 'required|trim');


        if($this->form_validation->run() == TRUE)
        {
            // echo "##".file_upload('agreement_doc','agreements',$this->input->post('business_name'));

            $form_data_user = array(
                'fullname' => $this->input->post('fullname'),
                'email_id' => $this->input->post('email_id'),
                'contact' => $this->input->post('contact'),
                'alt_contact' => $this->input->post('alt_contact'),
                // 'agreement_doc' => $ag_doc,
                // 'password' => $this->input->post('contact'),
                // 'password' => password_hash(random_string('alpha', 6), PASSWORD_BCRYPT),
                // 'passkey' => random_string('alpha', 6),
                'mobile_verify' => '1',
                'email_verify' => '1',
                'business_name' => $this->input->post('business_name'),
                'display_name' => $this->input->post('business_name'),
                'business_type' => $this->input->post('business_type'),
                'billing_type' => $this->input->post('billing_type'),
                'codadjust' => $this->input->post('codadjust'),
                'liability_amount' => $this->input->post('liability_amount'),
                'rto_charges' => $this->input->post('rto_charges'),
                'insurance_charges' => $this->input->post('insurance_charges'),
                'capping_amount' => $this->input->post('capping_amount'),
                'restrict_amount' => $this->input->post('restrict_amount'),
                'credit_period' => $this->input->post('credit_period'),
                'agreement_doc' => $this->input->post('agreement_doc'),
                'referral_type' => $this->input->post('referral_type'),
                'referred_by' => $this->input->post('referred_by'),
                'category_level' => $this->input->post('category_level'),
                'codgap' => $this->input->post('codgap'),
                'billing_cycle_id' => $this->input->post('billing_cycle_id'),
                'cod_cycle_id' => $this->input->post('cod_cycle_id'),
                'cod_fees_amt' => $this->input->post('cod_fees_amt'),
                'cod_fees_per' => $this->input->post('cod_fees_per'),
                'billing_address' => $this->input->post('billing_address'),
                'billing_state' => $this->input->post('billing_state'),
                'cancelled_cheque' => $this->input->post('cancelled_cheque'),
                'beneficiary_name' => $this->input->post('beneficiary_name'),
                'account_number' => $this->input->post('account_number'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'bank_name' => $this->input->post('bank_name'),
                'branch_name' => $this->input->post('branch_name'),
                'kyc_status' => '1',
                'approved_on' => date('Y-m-d H:i:s'),
                'approved_by' => $this->session->userdata['user_session']['admin_username'],
                'account_status' => '1',
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $form_data_balances = array(
                'main_balance' => '0',
                'promo_balance' => '0',
                'total_balance' => '0',
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            $express_type = $this->input->post("express_type");
            $weightslab_id = $this->input->post("weight_slab_id");

            $cnt_exp = count($express_type);
            $cnt_wslab = count($weightslab_id);

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

            // $form_data_cp = array(
            //     'priority_1' => $this->input->post('priority_1'),
            //     'priority_2' => $this->input->post('priority_2'),
            //     'priority_3' => $this->input->post('priority_3'),
            //     'added_by' => $this->session->userdata['user_session']['admin_username'],
            //     'updated_by' => $this->session->userdata['user_session']['admin_username'],
            // );

            $form_data_kyc = array(
                'kyc_pan' => $this->input->post('kyc_pan'),
                'kyc_gst_reg' => $this->input->post('kyc_gst_reg'),
                'kyc_doctype' => $this->input->post('kyc_doctype'),
                'kyc_doc_number' => $this->input->post('kyc_doc_number'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            // $form_data_notification = array(
            //     'transitpartner_name' => $this->input->post('transitpartner_name'),
            //     'transitpartner_description' => $this->input->post('transitpartner_description'),
            //     'added_by' => $this->session->userdata['user_session']['admin_username'],
            //     'updated_by' => $this->session->userdata['user_session']['admin_username'],
            // );

            $form_data_poc = array(
                'sales_poc_id' => $this->input->post('sales_poc_id'),
                'ops_poc_id' => $this->input->post('ops_poc_id'),
                'ndr_poc_id' => $this->input->post('ndr_poc_id'),
                'pickup_poc_id' => $this->input->post('pickup_poc_id'),
                'finance_poc_id' => $this->input->post('finance_poc_id'),
                'added_by' => $this->session->userdata['user_session']['admin_username'],
                'updated_by' => $this->session->userdata['user_session']['admin_username'],
            );

            // $form_data_rates = array(
            //                     array(
            //                         'weight_type' => 'normal',
            //                         'express_type' => 'surface',
            //                         'zone_a_rate' => $this->input->post('normal_surface_a'),
            //                         'zone_b_rate' => $this->input->post('normal_surface_b'),
            //                         'zone_c_rate' => $this->input->post('normal_surface_c'),
            //                         'zone_d_rate' => $this->input->post('normal_surface_d'),
            //                         'zone_e_rate' => $this->input->post('normal_surface_e'),
            //                         'added_by' => $this->session->userdata['user_session']['admin_username'],
            //                         'updated_by' => $this->session->userdata['user_session']['admin_username'],
            //                     ),
            //                     array(
            //                         'weight_type' => 'normal',
            //                         'express_type' => 'air',
            //                         'zone_a_rate' => $this->input->post('normal_air_a'),
            //                         'zone_b_rate' => $this->input->post('normal_air_b'),
            //                         'zone_c_rate' => $this->input->post('normal_air_c'),
            //                         'zone_d_rate' => $this->input->post('normal_air_d'),
            //                         'zone_e_rate' => $this->input->post('normal_air_e'),
            //                         'added_by' => $this->session->userdata['user_session']['admin_username'],
            //                         'updated_by' => $this->session->userdata['user_session']['admin_username'],
            //                     ),
            //                     array(
            //                         'weight_type' => 'heavy',
            //                         'express_type' => 'surface',
            //                         'zone_a_rate' => $this->input->post('heavy_surface_a'),
            //                         'zone_b_rate' => $this->input->post('heavy_surface_b'),
            //                         'zone_c_rate' => $this->input->post('heavy_surface_c'),
            //                         'zone_d_rate' => $this->input->post('heavy_surface_d'),
            //                         'zone_e_rate' => $this->input->post('heavy_surface_e'),
            //                         'added_by' => $this->session->userdata['user_session']['admin_username'],
            //                         'updated_by' => $this->session->userdata['user_session']['admin_username'],
            //                     )                
            //                 );


            $tracking_data = array(
                'activity_type' => "add_user",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
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


                if($this->insertions_model->ins_user_completeregis($form_data_user,$form_data_wtslab,$form_data_balances,$form_data_kyc,$form_data_poc) && $this->insertions_model->activity_logs($tracking_data))
                {
                    $output['title'] = 'Congrats';
                    $output['message'] = 'User Registered & Approved Successfully.';
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

            // if($this->insertions_model->ins_user_completeregis($form_data_user,$form_data_balances,$form_data_cp,$form_data_kyc,$form_data_rates,$form_data_poc) && $this->insertions_model->activity_logs($tracking_data))
            // {
            //     $output['title'] = 'Congrats';
            //     $output['message'] = 'User Registered & Approved Successfully.';
            // }
            // else
            // {
            //     $output['error'] = true;
            //     $output['title'] = 'Error';
            //     $output['message'] = 'Some Error occurred, Try again.';
            // }
            echo json_encode($output);
            //echo json_encode("Successfully");
        }
        else
        {
            $output['error'] = true;
            $output['title'] = 'Error';
            $output['message'] = validation_errors();
            echo json_encode($output);
        }
    }


    /* For User Ratechart  */
    public function user_rates()
    {
        $this->form_validation->set_rules('fwd_base_a[]', 'Fwd base rate A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_a[]', 'Fwd addon rate A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_a[]', 'RTO base rate A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_a[]', 'RTO addon rate A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_a[]', 'Surcharge A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_a[]', 'NDD A', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        $this->form_validation->set_rules('fwd_base_b[]', 'Fwd base rate B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_b[]', 'Fwd addon rate B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_b[]', 'RTO base rate B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_b[]', 'RTO addon rate B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_b[]', 'Surcharge B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_b[]', 'NDD B', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        $this->form_validation->set_rules('fwd_base_c[]', 'Fwd base rate C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_c[]', 'Fwd addon rate C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_c[]', 'RTO base rate C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_c[]', 'RTO addon rate C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_c[]', 'Surcharge C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_c[]', 'NDD C', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        $this->form_validation->set_rules('fwd_base_d[]', 'Fwd base rate D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_d[]', 'Fwd addon rate D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_d[]', 'RTO base rate D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_d[]', 'RTO addon rate D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_d[]', 'Surcharge D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_d[]', 'NDD D', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        $this->form_validation->set_rules('fwd_base_e[]', 'Fwd base rate E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_e[]', 'Fwd addon rate E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_e[]', 'RTO base rate E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_e[]', 'RTO addon rate E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_e[]', 'Surcharge E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_e[]', 'NDD E', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        $this->form_validation->set_rules('fwd_base_f[]', 'Fwd base rate F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('fwd_addon_f[]', 'Fwd addon rate F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_base_f[]', 'RTO base rate F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('rto_addon_f[]', 'RTO addon rate F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('surcharge_f[]', 'Surcharge F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');
        $this->form_validation->set_rules('ndd_f[]', 'NDD F', 'required|trim|regex_match[/^\d{0,10}(\.\d{0,2})?$/]');


        if($this->form_validation->run() == TRUE)
        {
            $userid = $this->input->post("user_id");
            $slabs = $this->input->post("slab_id");
            $weightslab = $this->input->post("weightslab_id");
            $express = $this->input->post("express");

            $cnt_slab = count($slabs);
            $cnt_wslab = count($weightslab);

            // print_r($userid);
            // print_r($slabs);
            // print_r($weightslab);
            // print_r($express);

            if($cnt_slab > 0 && $cnt_wslab > 0 && $cnt_wslab==$cnt_slab)
            {
                for($i=0; $i<$cnt_slab; $i++)
                {
                    for($j='A';$j<='F';$j++)
                    {
                        $form_data[] = array(
                        'user_id'       => $userid[$i],
                        'userslab_id'   => $slabs[$i],
                        'weightslab_id' => $weightslab[$i],
                        'express'       => $express[$i],
                        'zone'          => $j,
                        'fwd_base'      => $this->input->post("fwd_base_".strtolower($j))[$slabs[$i]],
                        'fwd_addon'     => $this->input->post("fwd_addon_".strtolower($j))[$slabs[$i]],
                        'rto_base'      => $this->input->post("rto_base_".strtolower($j))[$slabs[$i]],
                        'rto_addon'     => $this->input->post("rto_addon_".strtolower($j))[$slabs[$i]],
                        'surcharge'     => $this->input->post("surcharge_".strtolower($j))[$slabs[$i]],
                        'ndd'           => $this->input->post("ndd_".strtolower($j))[$slabs[$i]],
                        'added_by'      => $this->session->userdata['user_session']['admin_username'],
                        'updated_by'    => $this->session->userdata['user_session']['admin_username']
                        );
                    }
                }
            }

            // print_r($form_data);

            $tracking_data = array(
                'activity_type' => "add_weight_slab",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_user_ratechart($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Ratechart Saved Successfully.';
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


    /* For User Courier Priority  */
    public function user_courierpriority()
    {
        $this->form_validation->set_rules('priority_1_a[]', 'Priority 1 A', 'required');
        $this->form_validation->set_rules('priority_2_a[]', 'Priority 2 A', 'required');
        $this->form_validation->set_rules('priority_3_a[]', 'Priority 3 A', 'required');
        
        $this->form_validation->set_rules('priority_1_b[]', 'Priority 1 A', 'required');
        $this->form_validation->set_rules('priority_2_b[]', 'Priority 2 A', 'required');
        $this->form_validation->set_rules('priority_3_b[]', 'Priority 3 A', 'required');

        $this->form_validation->set_rules('priority_1_c[]', 'Priority 1 C', 'required');
        $this->form_validation->set_rules('priority_2_c[]', 'Priority 2 C', 'required');
        $this->form_validation->set_rules('priority_3_c[]', 'Priority 3 C', 'required');

        $this->form_validation->set_rules('priority_1_d[]', 'Priority 1 D', 'required');
        $this->form_validation->set_rules('priority_2_d[]', 'Priority 2 D', 'required');
        $this->form_validation->set_rules('priority_3_d[]', 'Priority 3 D', 'required');

        $this->form_validation->set_rules('priority_1_e[]', 'Priority 1 E', 'required');
        $this->form_validation->set_rules('priority_2_e[]', 'Priority 2 E', 'required');
        $this->form_validation->set_rules('priority_3_e[]', 'Priority 3 E', 'required');

        $this->form_validation->set_rules('priority_1_f[]', 'Priority 1 F', 'required');
        $this->form_validation->set_rules('priority_2_f[]', 'Priority 2 F', 'required');
        $this->form_validation->set_rules('priority_3_f[]', 'Priority 3 F', 'required');


        if($this->form_validation->run() == TRUE)
        {
            $userid = $this->input->post("user_id");
            $slabs = $this->input->post("slab_id");
            $weightslab = $this->input->post("weightslab_id");

            $cnt_slab = count($slabs);
            $cnt_wslab = count($weightslab);

            // print_r($userid);
            // print_r($slabs);
            // print_r($weightslab);
            // print_r($express);

            if($cnt_slab > 0 && $cnt_wslab > 0 && $cnt_wslab==$cnt_slab)
            {
                for($i=0; $i<$cnt_slab; $i++)
                {
                    for($j='A';$j<='F';$j++)
                    {
                        $form_data[] = array(
                        'user_id'       => $userid[$i],
                        'slab_id'   => $slabs[$i],
                        'weightslab_id' => $weightslab[$i],
                        'zone'          => $j,
                        'priority_1'      => $this->input->post("priority_1_".strtolower($j))[$slabs[$i]],
                        'priority_2'     => $this->input->post("priority_2_".strtolower($j))[$slabs[$i]],
                        'priority_3'      => $this->input->post("priority_3_".strtolower($j))[$slabs[$i]],
                        'added_by'      => $this->session->userdata['user_session']['admin_username'],
                        'updated_by'    => $this->session->userdata['user_session']['admin_username']
                        );
                    }
                }
            }

            // print_r($form_data);
            // die();

            $tracking_data = array(
                'activity_type' => "add_weight_slab",
                'log_data' => json_encode($this->input->post()),
                'admin_id' => $this->session->userdata['user_session']['admin_username'],
            );       

            if($this->insertions_model->ins_user_courierpriority($form_data) && $this->insertions_model->activity_logs($tracking_data))
            {
                $output['title'] = 'Congrats';
                $output['message'] = 'Priority Saved Successfully.';
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


    /* For College Stream */
    public function college_stream()
    {
        $this->form_validation->set_rules('college_category_id', 'Category', 'required');
        $this->form_validation->set_rules('college_course_id', 'Course', 'required');    
        $this->form_validation->set_rules('college_stream_name[]', 'Stream', 'required|trim|min_length[3]');        

        if($this->form_validation->run() == TRUE)
        {
            $streams = $this->input->post('college_stream_name');

            foreach ($streams as $key => $value)
            {
                $form_data = array(
                    'college_category_id' => $this->input->post('college_category_id'),
                    'college_course_id' => $this->input->post('college_course_id'),
                    //'stream_name' => $this->input->post('college_stream_name'),
                    'created_by' => $this->session->userdata['user_session']['username'],
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata['user_session']['username'],
                );

                $form_data['stream_name'] = $streams[$key];

                $res=$this->insertions_model->ins_clg_stream($form_data);
            }

            if($res)
                $output['message'] = 'Stream Saved Successfully.';
            else
            {
                $output['error'] = true;
                $output['message'] = 'Some Error occurred, Try again.';
            }
            echo json_encode($output);            
        }
        else
        {
            $output['error'] = true;
            $output['message'] = validation_errors();
            echo json_encode($output);
        }
    }
}
?>