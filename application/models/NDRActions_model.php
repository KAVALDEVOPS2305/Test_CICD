<?php
class NDRActions_model extends CI_Model
{
    public function Reattempt($postData)
    {
        $returnresponse = [];
        $returnresponse['status']='false';

        $tpa_data = $this->db->select('fulfilled_by,fulfilled_account, MTPA.*')->join('master_transitpartners_accounts MTPA','fulfilled_account = account_id')->where('waybill_number',$postData['waybill_number'])->get('shipments')->row();
        
        // print_r($tpa_data);
        
        //Preparing status of the shipment in NDR Logs
        $update_ndrlog = array (
            'action_requested' => 're_attempt',
            'action_on'        =>  date('Y-m-d H:i:s'),
            'processed_status' => '101',
            'ndr_status'       => '1'
        );

        switch($tpa_data->fulfilled_by)
        {
            case 1:                     // For Delhivery Shipments
                $ndr_reattempt = array(
                    'waybill'   =>    $postData['waybill_number'],
                    "act"       =>    "RE-ATTEMPT"
                );
        
                $fields=json_encode($ndr_reattempt);

                $headers = array
                (
                    'Authorization: Token '.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // _print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - Reattempt',
                    'event_id'      => $postData['waybill_number'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, DELHIVERY_URL.'/api/p/update' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($response))
                {
                    if(isset($response->request_id) && !empty($response->request_id))
                    {
                        //Update status of the shipment in NDR Logs
                        $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['waybill_number']));

                        $activity_data = array(
                            'activity_type' => "ndr_reattempt",
                            'log_data' => $fields,
                            'admin_id' => $this->session->userdata['user_session']['admin_username'],
                        );
                        $this->insertions_model->activity_logs($activity_data);

                        $returnresponse['status']='true';
                        $returnresponse['message']=$response->message;
                    }
                    else
                        $returnresponse['message'] = isset($response->message) ? $response->message : $response->detail;
                }
                return $returnresponse;
            break;

            case 2:                         // For Shadowfax Shipments
                $returnresponse['message']  = 'Sorry, details cannot be re-attempted at this stage';
                return $returnresponse;
            break;

            case 3:                         // For XpressBees Shipments
                $ndr_reattempt = array(
                    'ShippingID'            =>    $postData['waybill_number'],
                    "DeferredDeliveryDate"  =>    date('Y-m-d 14:00:00', strtotime(date('Y-m-d') . ' +1 day'))
                );
        
                $fields=json_encode($ndr_reattempt);

                $headers = array
                (
                    'XBKey:'.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // _print_r($fields);
                // die();
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - Reattempt',
                    'event_id'      => $postData['waybill_number'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, XBEES_NDRURL);
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response->UpdateNDRDeferredDeliveryDate->ReturnCode);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if($response->UpdateNDRDeferredDeliveryDate->ReturnCode == '100')
                {
                    //Update status of the shipment in NDR Logs
                    $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['waybill_number']));

                    $activity_data = array(
                        'activity_type' => "ndr_reattempt",
                        'log_data' => $fields,
                        'admin_id' => $this->session->userdata['user_session']['admin_username'],
                    );
                    $this->insertions_model->activity_logs($activity_data);

                    $returnresponse['status']='true';
                    $returnresponse['message']=$response->UpdateNDRDeferredDeliveryDate->ReturnMessage;
                }
                else
                    $returnresponse['message'] = $response->UpdateNDRDeferredDeliveryDate->ReturnMessage;
                
                return $returnresponse;
            break;

            case 4:                         // For Udaan Shipments
                $returnresponse['message']  = 'Sorry, details cannot be re-attempted at this stage';
                return $returnresponse;
            break;
        }
    }

    public function Reschedule($postData)
    {
        $returnresponse = [];
        $returnresponse['status']='false';

        $tpa_data = $this->db->select('fulfilled_by,fulfilled_account, MTPA.*')->join('master_transitpartners_accounts MTPA','fulfilled_account = account_id')->where('waybill_number',$postData['waybill_num'])->get('shipments')->row();
        
        // print_r($tpa_data);
        
        //Update status of the shipment in NDR Logs
        $update_ndrlog = array (
            'future_delivery'  => date('Y-m-d', strtotime($postData['future_delivery'])),
            'action_requested' => 're_schedule',
            'action_on'        =>  date('Y-m-d H:i:s'),
            'processed_status' => '101',
            'ndr_status'       => '1'
        );

        switch($tpa_data->fulfilled_by)
        {
            case 1:                         // For Delhivery Shipment
                $ndr_reschedule = array(
                    'waybill'   =>    $postData['waybill_num'],
                    "act"       =>    "DEFER_DLV",
                    "action_data" => array(
                        "deferred_date" => date('Y-m-d', strtotime($postData['future_delivery']))
                    )
                );

                $fields=json_encode($ndr_reschedule);

                $headers = array
                (
                    'Authorization: Token '.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - Reschedule',
                    'event_id'      => $postData['waybill_num'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, DELHIVERY_URL.'/api/p/update' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($response))
                {
                    if(isset($response->request_id) && !empty($response->request_id))
                    {
                        //Update status of the shipment in NDR Logs
                        $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['waybill_num']));

                        $activity_data = array(
                            'activity_type' => "ndr_schedule",
                            'log_data' => $fields,
                            'admin_id' => $this->session->userdata['user_session']['admin_username'],
                        );
                        $this->insertions_model->activity_logs($activity_data);


                        $returnresponse['status']='true';
                        $returnresponse['message']=$response->message;
                    }
                    else
                        $returnresponse['message'] = isset($response->message) ? $response->message : $response->detail;
                }
                return $returnresponse;
            break;

            case 2:                         // For Shadowfax Shipments
                $returnresponse['message']     = 'Sorry, details cannot be reschedule at this stage';
                return $returnresponse;
            break;

            case 3:                         // For XpressBees Shipments
                $ndr_reschedule = array(
                    'ShippingID'            =>  $postData['waybill_num'],
                    "DeferredDeliveryDate"  =>  date('Y-m-d 14:00:00', strtotime($postData['future_delivery']))
                );

                $fields=json_encode($ndr_reschedule);

                $headers = array
                (
                    'XBKey:'.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - Reschedule',
                    'event_id'      => $postData['waybill_num'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, XBEES_NDRURL );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if($response->UpdateNDRDeferredDeliveryDate->ReturnCode == '100')
                {
                    //Update status of the shipment in NDR Logs
                    $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['waybill_num']));

                    $activity_data = array(
                        'activity_type' => "ndr_schedule",
                        'log_data' => $fields,
                        'admin_id' => $this->session->userdata['user_session']['admin_username'],
                    );
                    $this->insertions_model->activity_logs($activity_data);

                    $returnresponse['status']='true';
                    $returnresponse['message']=$response->UpdateNDRDeferredDeliveryDate->ReturnMessage;
                }
                else
                    $returnresponse['message'] = $response->UpdateNDRDeferredDeliveryDate->ReturnMessage;

                return $returnresponse;
            break;

            case 4:                         // For Udaan Shipments
                $returnresponse['message']     = 'Sorry, details cannot be reschedule at this stage';
                return $returnresponse;
            break;
        }
    }

    public function Updatedetails($postData)
    {
        $returnresponse = [];
        $returnresponse['status']='false';

        $tpa_data = $this->db->select('fulfilled_by,fulfilled_account, MTPA.*')->join('master_transitpartners_accounts MTPA','fulfilled_account = account_id')->where('waybill_number',$postData['updt_modal_waybill_number'])->get('shipments')->row();
        
        // print_r($tpa_data);
        
        //Update status of the shipment in NDR Logs
        $update_ndrlog = array (
            'updated_details'  => "Name: ".$postData['consignee_name']."<br/>Phone: ".$postData['consignee_phone']."<br/>Address: ".$postData['consignee_address'],
            'action_requested' => 'update_details',
            'action_on'        =>  date('Y-m-d H:i:s'),
            'processed_status' => '101',
            'ndr_status'       => '1'
        );
        
        switch($tpa_data->fulfilled_by)
        {
            case 1:                     // For Delhivery Shipment
                $ndr_updatedata = array(
                    'waybill'   =>    $postData['updt_modal_waybill_number'],
                    "act"       =>    "EDIT_DETAILS",
                    "action_data" => array(
                        "name"  => $postData['consignee_name'],
                        "add"   => $postData['consignee_address'],
                        "phone" => $postData['consignee_phone']
                    )
                );

                $fields=json_encode($ndr_updatedata);
                $headers = array
                (
                    'Authorization: Token '.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - UpdateDetails',
                    'event_id'      => $postData['updt_modal_waybill_number'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, DELHIVERY_URL.'/api/p/update' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($response))
                {
                    if(isset($response->request_id) && !empty($response->request_id))
                    {
                        //Update status of the shipment in NDR Logs
                        $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['updt_modal_waybill_number']));

                        $activity_data = array(
                            'activity_type' => "ndr_updatedetails",
                            'log_data' => $fields,
                            'admin_id' => $this->session->userdata['user_session']['admin_username'],
                        );
                        $this->insertions_model->activity_logs($activity_data);


                        $returnresponse['status']='true';
                        $returnresponse['message']=$response->message;
                    }
                    else
                        $returnresponse['message'] = isset($response->message) ? $response->message : $response->detail;
                }
                return $returnresponse;
            break;

            case 2:                         // For Shadowfax Shipments
                $returnresponse['message']     = 'Sorry, details cannot be updated';
                return $returnresponse;
            break;

            case 3:                         // For XpressBees Shipments
                $ndr_updatedata = array(
                    'ShippingID'                    =>  $postData['updt_modal_waybill_number'],
                    "DeferredDeliveryDate"          =>   date('Y-m-d 14:00:00', strtotime(date('Y-m-d') . ' +1 day')),
                    "AlternateCustomerAddress"      =>  $postData['consignee_address'],
                    "AlternateCustomerMobileNumber" =>  $postData['consignee_phone'],
                    "CustomerPincode"               =>  $postData['consignee_pincode']
                );

                $fields=json_encode($ndr_updatedata);
                $headers = array
                (
                    'XBKey:'.$tpa_data->account_key,
                    'Content-Type: application/json'
                );
                // print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'NDR - UpdateDetails',
                    'event_id'      => $postData['updt_modal_waybill_number'],
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, XBEES_NDRURL);
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);

                $response =  json_decode($result);
                // print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if($response->UpdateNDRDeferredDeliveryDate->ReturnCode == '100')
                {
                    //Update status of the shipment in NDR Logs
                    $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['updt_modal_waybill_number']));

                    $activity_data = array(
                        'activity_type' => "ndr_updatedetails",
                        'log_data' => $fields,
                        'admin_id' => $this->session->userdata['user_session']['admin_username'],
                    );
                    $this->insertions_model->activity_logs($activity_data);

                    $returnresponse['status']='true';
                    $returnresponse['message']=$response->UpdateNDRDeferredDeliveryDate->ReturnMessage;
                }
                else
                    $returnresponse['message'] = $response->UpdateNDRDeferredDeliveryDate->ReturnMessage;
                    
                return $returnresponse;
            break;

            case 4:                         // For Udaan Shipments
                $returnresponse['message']     = 'Sorry, details cannot be updated';
                return $returnresponse;
            break;
        }
    }

    public function MarkRTO($postData)
    {
        $returnresponse = [];
        $returnresponse['status']='false';

        $tpa_data = $this->db->select('fulfilled_by,fulfilled_account, MTPA.*')->join('master_transitpartners_accounts MTPA','fulfilled_account = account_id')->where('waybill_number',$postData['waybill_number'])->get('shipments')->row();
        
        // print_r($tpa_data);
        
        //Update status of the shipment in NDR Logs
        $update_ndrlog = array (
            'action_requested' => 'mark_rto',
            'action_on'        =>  date('Y-m-d H:i:s'),
            'processed_status' => '101',
            'ndr_status'       => '1'
        );

        switch($tpa_data->fulfilled_by)
        {
            case 1:                     // For Delhivery Shipments
                $returnresponse['message']     = 'Shipment will be marked RTO, automatically.';
                return $returnresponse;
            break;

            case 2:                         // For Shadowfax Shipments
                $returnresponse['message']     = 'Sorry, shipment cannot be marked RTO';
                return $returnresponse;
            break;

            case 3:                         // For XpressBees Shipments
                $cancelData = json_encode(array(
                    'XBkey'     => $tpa_data->account_key,
                    'AWBNumber' => $postData['waybill_number'],
                    'RTOReason' => "RTO due to NDR"
                ));

                $headers = array
                (
                    'Content-Type: application/json'
                );

                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'Mark RTO',
                    'event_id'      => $postData['waybill_number'],
                    'payload'       => $cancelData,
                );
                
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, XBEES_FWDCNURL);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $cancelData);
                $result = curl_exec($ch);
                curl_close($ch);
                $responseData = json_decode($result);
                // print_r($responseData->RTONotifyShipment[0]);
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($responseData)]);
                // die();
                if (!empty($responseData->RTONotifyShipment[0]))
                {
                    if ($responseData->RTONotifyShipment[0]->ReturnMessage=='successful')
                    {
                        //Update status of the shipment in NDR Logs
                        $this->db->update('ndr_logs', $update_ndrlog, array('waybill_number' => $postData['waybill_number']));

                        $activity_data = array(
                            'activity_type' => "ndr_markrto",
                            'log_data' => $cancelData,
                            'admin_id' => $this->session->userdata['user_session']['admin_username'],
                        );
                        $this->insertions_model->activity_logs($activity_data);

                        $returnresponse['status']   = "true";
                        $returnresponse['message']  = 'Shipment marked RTO successfully';
                        // $returnresponse['message'] = $responseData->RTONotifyShipment[0]->ReturnMessage;
                    }
                    else
                        $returnresponse['message'] = $responseData->RTONotifyShipment[0]->ReturnMessage;
                }
                else
                    $returnresponse['message']     = 'Oops! Something went wrong while marking RTO';
                
                return $returnresponse;
            break;

            case 4:                         // For Udaan Shipments
                $returnresponse['message']     = 'Sorry, shipment cannot be marked RTO';
                return $returnresponse;
            break;
        }
        
    }

}
?>