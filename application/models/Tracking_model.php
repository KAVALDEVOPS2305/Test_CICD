<?php
defined('BASEPATH') or exit('No direct script access allowed');
use App\app\Sp;
class Tracking_model extends CI_Model
{
    public function update_status($awbs_data)
    {
        $success_count = 0;
        for ($record = 0; $record < count($awbs_data); $record++)
        {
            $awbn = $awbs_data[$record];
            $shipment_condition = array(
                "waybill_number" => $awbn,
                // "system_status !=" => '108,109',
                // "user_status !=" => '227'
            );
            $query_shipment = $this->db->select('shipment_id,user_id,fulfilled_by,fulfilled_account')->get_where("shipments", $shipment_condition)->row();
            if (!empty($query_shipment))
            {
                $fulfilled_by = $query_shipment->fulfilled_by;
                $fulfilled_account = $query_shipment->fulfilled_account;
                $user_id = $query_shipment->user_id;
                
                //Pulling Scans for Delhivery
                if ($fulfilled_by == 1)
                {
                    $account_id = $this->db->get_where("master_transitpartners_accounts", array("account_id" => $fulfilled_account))->row();
                    $token = $account_id->account_key;
                    // $token = 'd7b53c776ac67bf1186179a183d7bceb1b99a354';
                    $ch = curl_init();
                    $curlConfig = array(
                        CURLOPT_URL => DELHIVERY_URL . "/api/v1/packages/json/?waybill=$awbn&token=$token",
                        CURLOPT_POST           => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS     => "",
                        CURLOPT_ENCODING       => "",
                        CURLOPT_MAXREDIRS      => 10,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST  => "GET",
                        CURLOPT_TIMEOUT        => 0,
                        CURLOPT_HTTPHEADER     => array(),
                    );
                    curl_setopt_array($ch, $curlConfig);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($result);
                    if (!empty($response))
                    {
                        $scans_data = $response->ShipmentData[0]->Shipment->Scans;
                        $get_last_updates = $this->db->order_by(1, 'DESC')->limit(1)->get_where("shipments_status_logs", array("waybill_number" => $response->ShipmentData[0]->Shipment->AWB))->row_array();
                        $last_updated_at = date('c', strtotime($get_last_updates['updated_on']));

                        $statuslogs_data = [];
                        
                        if (empty($get_last_updates))
                        {
                            for ($sc = 0; $sc < count($scans_data); $sc++)
                            {
                                $px_statuscode = delhivery_status($scans_data[$sc]->ScanDetail->ScanType, $scans_data[$sc]->ScanDetail->Scan);

                                $statuslogs_data[] = array(
                                    'shipment_id'     => $response->ShipmentData[0]->Shipment->ReferenceNo,
                                    'waybill_number'  => $response->ShipmentData[0]->Shipment->AWB,
                                    'status_code'     => $scans_data[$sc]->ScanDetail->ScanType,
                                    'updated_status'  => $scans_data[$sc]->ScanDetail->Scan,
                                    'px_statuscode'   => $px_statuscode['user_status'],
                                    'status_location' => $scans_data[$sc]->ScanDetail->ScannedLocation,
                                    'log_data'        => json_encode($scans_data[$sc]),
                                    'status_description' => $scans_data[$sc]->ScanDetail->Instructions,
                                    'updated_on'      => $scans_data[$sc]->ScanDetail->ScanDateTime,
                                    'updated_by'      => $this->session->userdata['user_session']['admin_username']
                                );
                                
                                $this->status_event_handling($scans_data[$sc], $response->ShipmentData[0]->Shipment->AWB, $response->ShipmentData[0]->Shipment->ReferenceNo, $user_id,$fulfilled_by);
                            }
                        }
                        else
                        {
                            for ($sc = 0; $sc < count($scans_data); $sc++)
                            {
                                if (date('c', strtotime($scans_data[$sc]->ScanDetail->ScanDateTime)) > $last_updated_at)
                                {
                                    $px_statuscode = delhivery_status($scans_data[$sc]->ScanDetail->ScanType, $scans_data[$sc]->ScanDetail->Scan);

                                    // echo "Records";
                                    $statuslogs_data[] = array(
                                        'shipment_id'     => $response->ShipmentData[0]->Shipment->ReferenceNo,
                                        'waybill_number'  => $response->ShipmentData[0]->Shipment->AWB,
                                        'status_code'     => $scans_data[$sc]->ScanDetail->ScanType,
                                        'updated_status'  => $scans_data[$sc]->ScanDetail->Scan,
                                        'px_statuscode'   => $px_statuscode['user_status'],
                                        'status_location' => $scans_data[$sc]->ScanDetail->ScannedLocation,
                                        'log_data'        => json_encode($scans_data[$sc]),
                                        'status_description' => $scans_data[$sc]->ScanDetail->Instructions,
                                        'updated_on'      => $scans_data[$sc]->ScanDetail->ScanDateTime,
                                        'updated_by'      => $this->session->userdata['user_session']['admin_username']

                                    );
                                    $this->status_event_handling($scans_data[$sc], $response->ShipmentData[0]->Shipment->AWB, $response->ShipmentData[0]->Shipment->ReferenceNo, $user_id,$fulfilled_by);
                                }
                            }
                        }

                        //Insert in shipments_status_logs
                        if(!empty($statuslogs_data))
                        {
                            $this->db->trans_start();
                            $this->db->insert_batch("shipments_status_logs", $statuslogs_data);
                            //Update the status in shipment table
                            $update_shipment_condition = array(
                                'waybill_number' => $response->ShipmentData[0]->Shipment->AWB,
                                'shipment_id' => $response->ShipmentData[0]->Shipment->ReferenceNo,
                                // 'system_status !=' => '107,108,109',
                                // 'user_status !=' => '227'
                            );
                            // $update_shipments = $this->db->where_in($update_shipment_condition)->update('shipments', delhivery_status($scans_data[count($scans_data)-1]->ScanDetail->ScanType, $scans_data[count($scans_data)-1]->ScanDetail->Scan));

                            $this->db->update('shipments', delhivery_status($scans_data[count($scans_data)-1]->ScanDetail->ScanType, $scans_data[count($scans_data)-1]->ScanDetail->Scan), $update_shipment_condition);

                            //Updating Last_Scans Data
                            $updt_lastscans_data = array(
                                'last_scan_on'          => $scans_data[count($scans_data)-1]->ScanDetail->ScanDateTime,
                                'last_scan_location'    => $scans_data[count($scans_data)-1]->ScanDetail->ScannedLocation,
                                'last_scan_remark'      => $scans_data[count($scans_data)-1]->ScanDetail->Instructions
                            );
                            $updt_lastscans_condition = array(
                                'waybill_number'    => $awbn,
                                'user_id'           => $user_id,
                            );
                            $this->db->update('shipments_statuses_logs', $updt_lastscans_data, $updt_lastscans_condition);
                            // $this->db->where_in($updt_lastscans_condition)->update('shipments_statuses_logs', $updt_lastscans_data);

                            // $this->db->update('shipments_statuses_logs', delhivery_status($scans_data[count($scans_data)-1]->ScanDetail->ScanType, $scans_data[count($scans_data)-1]->ScanDetail->Scan));
                            $this->db->trans_complete();

                            if($this->db->trans_status() === TRUE)
                            {
                                $success_count++;
                                $response_data[] = array(
                                'waybill_number'  => $awbn,
                                'remarks'         => 'Status updated successfully.'
                                );
                            }
                            else{
                                $response_data[] = array(
                                    'waybill_number'  => $awbn,
                                    'remarks'         => 'Error Updating Status, try again'
                                );
                            }
                        }
                        else
                        {
                            $response_data[] = array(
                                'waybill_number'  => $awbn,
                                'remarks'         => 'Status already uptodate'
                            );
                        }
                    }
                    else
                    {
                        $response_data[] = array(
                            'waybill'   => $awbn,
                            'remarks'   => 'No Scans available.'
                        );
                    }
                }

                //Pulling Scan for Amazon
                else if($fulfilled_by == 8)
                {
                    $account_data = $this->db->get_where("master_transitpartners_accounts", array("account_id" => $fulfilled_account))->row();

                    $requestData = Array(
                        "trackingId" => $awbn,
                        "carrierId" => "ATS"
                    );
                    $reportConfig = new \App\app\AmazonReport;
                    $reportConfig->refresh_token = $account_data->account_description;
                    $reportConfig->access_key = $account_data->account_key;
                    $reportConfig->secret_key = $account_data->account_secret;
                    $reportConfig->client_secret = $account_data->account_password;
                    $reportConfig->client_id = $account_data->account_username;
                    $reportConfig->region = "eu-west-1";            
                    $sp = new Sp($reportConfig);

                    $response = $sp->trackShipment($requestData);
                    // print_r($statusresult);
                    // $response = json_decode($statusresult);
                    // _print_r($response);
                    // $account_id = $account_data->account_id;
                    // $response = $this->amazon->get_tracking_info($shipment_condition,$account_id);
                    //echo "<pre>";print_r($response);
                    // _print_r($response->errors);
                    if (!empty($response))
                    {
                        if(isset($response->payload))
                        {
                            if(!empty($response->payload->eventHistory))
                            {
                                $scans_data = $response->payload->eventHistory;
                                // _print_r($scans_data);
                                $get_last_updates = $this->db->order_by(1, 'DESC')->limit(1)->get_where("shipments_status_logs", array("waybill_number" => $response->payload->trackingId))->row_array();
                                // _print_r($this->db->last_query(),1);
                                $last_updated_at = date('c', strtotime($get_last_updates['updated_on']));

                                $statuslogs_data = [];

                                if (empty($get_last_updates))
                                {
                                    for ($sc = 0; $sc < count($scans_data); $sc++)
                                    {
                                        $px_statuscode = amazon_status($scans_data[$sc]->eventCode,$response->payload->alternateLegTrackingId);
                                        //print_r($scans_data[$sc]);
                                        $statuslogs_data[] = array(
                                            'shipment_id'     => $query_shipment->shipment_id,
                                            'waybill_number'  => $response->payload->trackingId,
                                            'status_code'     => $scans_data[$sc]->eventCode,
                                            'updated_status'  => $scans_data[$sc]->eventCode,
                                            'px_statuscode'   => $px_statuscode['user_status'],
                                            'status_location' => isset($scans_data[$sc]->location->city)?$scans_data[$sc]->location->city.', '.$scans_data[$sc]->location->stateOrRegion:'No Data',
                                            'log_data'        => json_encode($scans_data[$sc]),
                                            'status_description' => $scans_data[$sc]->eventCode,
                                            'updated_on'      => $scans_data[$sc]->eventTime,
                                            'updated_by'      => $this->session->userdata['user_session']['admin_username']
                                        );
                                        $scans_data[$sc]->summary = $response->payload->summary->status;
                                        $scans_data[$sc]->promisedDeliveryDate = $response->payload->promisedDeliveryDate;
                                        $scans_data[$sc]->rtoawb = $response->payload->alternateLegTrackingId;
                                        $this->status_event_handling($scans_data[$sc],$response->payload->trackingId, $query_shipment->shipment_id, $user_id,$fulfilled_by);
                                    }
                                }
                                else
                                {
                                    for ($sc = 0; $sc < count($scans_data); $sc++)
                                    {
                                        if (date('c', strtotime($scans_data[$sc]->eventTime)) > $last_updated_at)
                                        {
                                            $px_statuscode = amazon_status($scans_data[$sc]->eventCode, $response->payload->alternateLegTrackingId);

                                            // echo "Records";
                                            $statuslogs_data[] = array(
                                                'shipment_id'     => $query_shipment->shipment_id,
                                                'waybill_number'  => $response->payload->trackingId,
                                                'status_code'     => $scans_data[$sc]->eventCode,
                                                'updated_status'  => $scans_data[$sc]->eventCode,
                                                'px_statuscode'   => $px_statuscode['user_status'],
                                                'status_location' => isset($scans_data[$sc]->location->city)?$scans_data[$sc]->location->city.', '.$scans_data[$sc]->location->stateOrRegion:'No Data',
                                                'log_data'        => json_encode($scans_data[$sc]),
                                                'status_description' => $scans_data[$sc]->eventCode,
                                                'updated_on'      => $scans_data[$sc]->eventTime,
                                                'updated_by'      => $this->session->userdata['user_session']['admin_username']
                                            );
                                            $scans_data[$sc]->summary = $response->payload->summary->status;
                                            $scans_data[$sc]->promisedDeliveryDate = $response->payload->promisedDeliveryDate;
                                            $scans_data[$sc]->rtoawb = $response->payload->alternateLegTrackingId;
                                            $this->status_event_handling($scans_data[$sc], $response->payload->trackingId, $query_shipment->shipment_id, $user_id,$fulfilled_by);
                                        }
                                    }
                                }

                                //Insert in shipments_status_logs
                                if(!empty($statuslogs_data))
                                {
                                    $this->db->trans_start();
                                    $this->db->insert_batch("shipments_status_logs", $statuslogs_data);
                                    //Update the status in shipment table
                                    $update_shipment_condition = array(
                                        'waybill_number' => $response->payload->trackingId,
                                        'shipment_id' => $query_shipment->shipment_id
                                    );

                                    $this->db->update('shipments', amazon_status($scans_data[count($scans_data)-1]->eventCode,$response->payload->alternateLegTrackingId), $update_shipment_condition);

                                    //Updating Last_Scans Data
                                    $updt_lastscans_data = array(
                                        'last_scan_on'          => $scans_data[count($scans_data)-1]->eventTime,
                                        'last_scan_location'    => isset($scans_data[count($scans_data)-1]->location->city)?$scans_data[count($scans_data)-1]->location->city.', '.$scans_data[count($scans_data)-1]->location->stateOrRegion:'No Location',
                                        'last_scan_remark'      => !empty($response->payload->alternateLegTrackingId) ? "RTO Track Id : ". $response->payload->alternateLegTrackingId :  $response->payload->summary->status,
                                    );
                                    $updt_lastscans_condition = array(
                                        'waybill_number'    => $awbn,
                                        'user_id'           => $user_id,
                                    );
                                    $this->db->update('shipments_statuses_logs', $updt_lastscans_data, $updt_lastscans_condition);

                                    $this->db->trans_complete();

                                    if($this->db->trans_status() === TRUE) {
                                        $success_count++;
                                        $response_data[] = array(
                                        'waybill_number'  => $awbn,
                                        'remarks'         => 'Status updated successfully.'
                                        );
                                    }
                                    else{
                                        $response_data[] = array(
                                            'waybill_number'  => $awbn,
                                            'remarks'         => 'Error Updating Status, try again'
                                        );
                                    }
                                }
                                else {
                                    $response_data[] = array(
                                        'waybill_number'  => $awbn,
                                        'remarks'         => 'Status already uptodate'
                                    );
                                }
                            }
                            elseif($response->payload->summary->status == "PickupCancelled") {
                                $response_data[] = array(
                                    'waybill_number'  => $awbn,
                                    'remarks'         => 'Shipment Cancelled'
                                );
                            }
                            else {
                                $response_data[] = array(
                                    'waybill_number'  => $awbn,
                                    'remarks'         => 'No logs available by Amazon'
                                );
                            }
                        }
                        else {
                            $response = json_decode($response);
                            $response_data[] = array(
                                'waybill_number'  => $awbn,
                                'remarks'         => $response->errors[0]->details.' for Amazon'
                            );
                        }
                    }
                    else {
                        $response_data[] = array(
                            'waybill'   => $awbn,
                            'remarks'   => 'No Scans available.'
                        );
                    }
                }
                else {
                    $response_data[] = array(
                        'waybill_number' => $awbn,
                        'remarks'        => 'Pull API not avaialable'
                    );
                }
            }
            else {
                $response_data[] = array(
                    'waybill_number' => $awbn,
                    'remarks'        => 'AWB is invalid'
                );
            }
        }

        return array($success_count, $response_data);
    }

    public function status_event_handling($scan_data_arr, $waybill_number, $shipment_id, $user_id,$fulfilled_by)
    {
        //Recording Events for Delhivery START
        if($fulfilled_by == 1)
        {
            //Event for Pickup
            if ($scan_data_arr->ScanDetail->StatusCode == 'X-PPOM')
            {
                // $check_shipments_statuses = $this->db->get_where('shipments_statuses_logs', array('waybill_number' => $waybill_number, 'user_id' => $user_id));
                // if ($check_shipments_statuses->num_rows() > 0)
                if ($this->check_shipments_statuses_data(array('waybill_number' => $waybill_number, 'user_id' => $user_id)))
                {
                    // echo 'Update';
                    $updated_logs_data = array(
                        'picked_on'  => $scan_data_arr->ScanDetail->ScanDateTime,
                        'last_scan_on' => $scan_data_arr->ScanDetail->ScanDateTime,
                        'last_scan_location' => $scan_data_arr->ScanDetail->ScannedLocation,
                        'last_scan_remark' => $scan_data_arr->ScanDetail->Instructions
                    );
                    $updated_logs_condition = array(
                        'waybill_number'  => $waybill_number,
                        'user_id'     => $user_id,
                    );
                    $this->db->update('shipments_statuses_logs', $updated_logs_data, $updated_logs_condition);
                } 
                else
                {
                    $logs_data = array(
                        'shipment_id'     => $shipment_id,
                        'waybill_number'  => $waybill_number,
                        'user_id'     => $user_id,
                        'picked_on'  => $scan_data_arr->ScanDetail->ScanDateTime,
                        'last_scan_on' => $scan_data_arr->ScanDetail->ScanDateTime,
                        'last_scan_location' => $scan_data_arr->ScanDetail->ScannedLocation,
                        'last_scan_remark' => $scan_data_arr->ScanDetail->Instructions
                    );
                    $this->db->insert('shipments_statuses_logs', $logs_data);
                }
            }

            // Event for OFD/Dispatched
            if ($scan_data_arr->ScanDetail->StatusCode == 'X-DDD3FD') 
            {
                $check_ofd_condition = array(
                    'waybill_number'  => $waybill_number,
                    'user_id'     => $user_id,
                );
                $get_ofd_data = $this->check_ofd_data($check_ofd_condition);
                if(is_null($get_ofd_data->ofd1_on))
                    $this->update_ofd_data("ofd1_on",$scan_data_arr->ScanDetail->ScanDateTime, $waybill_number);
                elseif($get_ofd_data->ofd1_on != null && is_null($get_ofd_data->ofd2_on))
                    $this->update_ofd_data("ofd2_on",$scan_data_arr->ScanDetail->ScanDateTime, $waybill_number);
                elseif($get_ofd_data->ofd1_on != null && $get_ofd_data->ofd2_on != null && is_null($get_ofd_data->ofd3_on))
                    $this->update_ofd_data("ofd3_on",$scan_data_arr->ScanDetail->ScanDateTime, $waybill_number);
                else
                {
                    $this->db->set('ofd_attempts','ofd_attempts+1', false)->set('ofd_all',"CONCAT(COALESCE(ofd_all,''),'".$scan_data_arr->ScanDetail->ScanDateTime."##')", false)->where('waybill_number',$waybill_number)->update('shipments_statuses_logs');
                }
            }

            //Event for Billing Delivered or RTO
            if (($scan_data_arr->ScanDetail->ScanType == 'DL' and $scan_data_arr->ScanDetail->Scan == 'Delivered') || $scan_data_arr->ScanDetail->ScanType == 'RT' || ($scan_data_arr->ScanDetail->ScanType == 'DL' and $scan_data_arr->ScanDetail->Scan == 'DTO'))
            {
                $shipmentStatusbillingData = json_encode(array(
                    'awb_num'       => $waybill_number,
                    // 'order_status'  => $scan_data_arr->ScanDetail->ScanType == 'DL' ? '226' : ($scan_data_arr->ScanDetail->ScanType == 'RT' ? '225' : ''),
                    'order_status'  => ($scan_data_arr->ScanDetail->ScanType == 'DL' AND $scan_data_arr->ScanDetail->Scan == 'Delivered') ? '226' : '225',
                    'status_date'   => $scan_data_arr->ScanDetail->ScanDateTime,
                ));

                $billingurl = base_url().'Billing/change_status_webhook/';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $billingurl);
                curl_setopt($ch, CURLOPT_POST, false);
                // curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $shipmentStatusbillingData);

                $result = curl_exec($ch);
                curl_close($ch);
            }
        }
        //Recording Events for Delhivery END

        //Recording Events for Amazon START
        if ($fulfilled_by == 8)
        {
            //Event for Amazon Pickup
            if ($scan_data_arr->eventCode == 'PickupDone')
            {
                if ($this->check_shipments_statuses_data(array('waybill_number' => $waybill_number, 'user_id' => $user_id)))
                {
                    // echo 'Update';
                    $updated_logs_data = array(
                        'picked_on'  => $scan_data_arr->eventTime,
                        'last_scan_on' => $scan_data_arr->eventTime,
                        'last_scan_location' => isset($scan_data_arr->location->city)?$scan_data_arr->location->city.', '.$scan_data_arr->location->stateOrRegion:'No Data',
                        'expected_dd' => isset($scan_data_arr->promisedDeliveryDate)?date("Y-m-d",strtotime($scan_data_arr->promisedDeliveryDate)):'',
                        'promised_dd' => isset($scan_data_arr->promisedDeliveryDate)?date("Y-m-d",strtotime($scan_data_arr->promisedDeliveryDate)):'',
                        'last_scan_remark' => $scan_data_arr->summary
                    );
                    $updated_logs_condition = array(
                        'waybill_number'  => $waybill_number,
                        'user_id'     => $user_id,
                    );
                    
                    $this->db->update('shipments_statuses_logs', $updated_logs_data, $updated_logs_condition);
                } 
                else
                {
                    $logs_data = array(
                        'shipment_id'     => $shipment_id,
                        'waybill_number'  => $waybill_number,
                        'user_id'     => $user_id,
                        'picked_on'  => $scan_data_arr->eventTime,
                        'last_scan_on' => $scan_data_arr->eventTime,
                        'last_scan_location' => isset($scan_data_arr->location->city)?$scan_data_arr->location->city.', '.$scan_data_arr->location->stateOrRegion:'No Data',
                        'expected_dd' => isset($scan_data_arr->promisedDeliveryDate)?date("Y-m-d",strtotime($scan_data_arr->promisedDeliveryDate)):'',
                        'promised_dd' => isset($scan_data_arr->promisedDeliveryDate)?date("Y-m-d",strtotime($scan_data_arr->promisedDeliveryDate)):'',
                        'last_scan_remark' => $scan_data_arr->summary
                    );
                    
                    $this->db->insert('shipments_statuses_logs', $logs_data);
                }
            }

            // Event for Amazon OFD/Dispatched
            if ($scan_data_arr->eventCode == 'OutForDelivery') 
            {
                $check_ofd_condition = array(
                    'waybill_number'  => $waybill_number,
                    'user_id'     => $user_id,
                );
                $get_ofd_data = $this->check_ofd_data($check_ofd_condition);
                if(is_null($get_ofd_data->ofd1_on))
                    $this->update_ofd_data("ofd1_on",$scan_data_arr->eventTime, $waybill_number);
                elseif($get_ofd_data->ofd1_on != null && is_null($get_ofd_data->ofd2_on))
                    $this->update_ofd_data("ofd2_on",$scan_data_arr->eventTime, $waybill_number);
                elseif($get_ofd_data->ofd1_on != null && $get_ofd_data->ofd2_on != null && is_null($get_ofd_data->ofd3_on))
                    $this->update_ofd_data("ofd3_on",$scan_data_arr->eventTime, $waybill_number);
                else
                {
                    $this->db->set('ofd_attempts','ofd_attempts+1', false)->set('ofd_all',"CONCAT(COALESCE(ofd_all,''),'".$scan_data_arr->eventTime."##')", false)->where('waybill_number',$waybill_number)->update('shipments_statuses_logs');
                }
            }

            //Event for Amazon Billing Delivered or RTO
            if ($scan_data_arr->eventCode == 'Delivered' || $scan_data_arr->eventCode == 'Rejected' || $scan_data_arr->eventCode == 'Undeliverable')
            {
                $shipmentStatusbillingData = json_encode(array(
                    'awb_num'       => $waybill_number,
                    'order_status'  => $scan_data_arr->eventCode == 'Delivered' && empty($scan_data_arr->rtoawb) ? '226' : '225',
                    'status_date'   => $scan_data_arr->eventTime,
                ));

                $billingurl = base_url().'Billing/change_status_webhook/';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $billingurl);
                curl_setopt($ch, CURLOPT_POST, false);
                // curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $shipmentStatusbillingData);

                $result = curl_exec($ch);
                curl_close($ch);
            }
        }
        //Recording Events for Amazon END
    }

    public function check_shipments_statuses_data($data)
    {
        $query = $this->db->get_where('shipments_statuses_logs', $data);
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function check_ofd_data($check_ofd_condition)
    {
        $query = $this->db
            ->where($check_ofd_condition)
            ->get('shipments_statuses_logs');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function update_ofd_data($column, $data, $condition)
    {
        return $this->db->set($column, $data)->set('ofd_attempts', 'ofd_attempts+1', false)->set('ofd_all', "CONCAT(COALESCE(ofd_all,''),'" . $data . "##')", false)->where('waybill_number', $condition)->update('shipments_statuses_logs');
    }
}
