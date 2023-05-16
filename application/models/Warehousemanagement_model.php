<?php
class Warehousemanagement_model extends CI_Model
{
    public function BulkRegisterwarehouse($account_id)
    {
        // echo "Account Id ". $account_id;
        // die();
        $tpa_data = $this->db->where('account_id',$account_id)->get('master_transitpartners_accounts')->row();
        $total_address = $this->db->query("SELECT * FROM users_address where registered_status='0' AND address_status <> '2'")->num_rows();
        $reg_address = 0;
        foreach ($this->db->where('registered_status','0')->where('address_status <>','2')->get('users_address')->result() as $unreg_add)
        {
            $reg_address++;
            //Add Account IDs for Delhivery
            if($tpa_data->parent_id=='1')
            {
                $address_data = array(
                    'phone' =>$unreg_add->phone,
                    "city"  =>$unreg_add->address_city,
                    "name"  =>$unreg_add->address_title,
                    "pin"   =>$unreg_add->pincode,
                    "address"=>$unreg_add->full_address,
                    "country"=>"India",
                    "email"=>"",
                    "registered_name"=>$unreg_add->address_title,
                    "return_address"=>$unreg_add->full_address,
                    "return_pin"=>$unreg_add->pincode,
                    "return_city"=>$unreg_add->address_city,
                    "return_state"=>$unreg_add->address_state,
                    "return_country"=>"India"
                );
        
                $fields=json_encode($address_data);

                $headers = array
                (
                    'Authorization: Token '.$tpa_data->account_key,
                    'Content-Type: application/json'
                );

                // _print_r($fields);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->parent_id =='1' ? 'Delhivery' : ($tpa_data->parent_id=='13' ? 'DelhiveryB2B' : ''),
                    'event_name'    => 'AddWarehouse-Bulk',
                    'event_id'      => $tpa_data->account_name,
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://staging-express.delhivery.com/api/backend/clientwarehouse/create/' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);
                $response = json_decode(json_encode((array)$xml), TRUE);
                // _print_r($response);
                // die();
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($xml) && !empty($response))
                {
                    if($response['success']=="False")
                        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$response['error']['list-item']."..! ') WHERE address_title='".$unreg_add->address_title."'");
                    else
                        $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE address_title='".$unreg_add->address_title."'");
                }
            }
            
            // Add Warehouse for Account IDs for Delhivery B2B
            if($tpa_data->parent_id=='13')
            {
                $address_data = json_encode(array(
                    "phone" =>$unreg_add->phone,
                    "city"  =>$unreg_add->address_city,
                    "name"  =>$unreg_add->address_title,
                    "pin"   =>$unreg_add->pincode,
                    "address"=>$unreg_add->full_address,
                    "country"=>"India",
                    "email"=>"",
                    "registered_name"=>$unreg_add->address_title,
                    "return_address"=>$unreg_add->full_address,
                    "return_pin"=>$unreg_add->pincode,
                    "return_city"=>$unreg_add->address_city,
                    "return_state"=>$unreg_add->address_state,
                    "return_country"=>"India"
                ));

                // $apitoken = $this->delhiveryb2b_jwtoken($tpa_data);
                $api_token = '';

                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'AddWarehouse',
                    'event_id'      => $unreg_add->user_address_id,
                    'payload'       => $address_data,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $headers = array
                (
                    'Authorization: Bearer ' . $apitoken,
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://track.delhivery.com/api/backend/clientwarehouse/create/' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $address_data );
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);
                $response = json_decode(json_encode((array)$xml), TRUE);
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($xml) && !empty($response))
                {
                    if($response['success']=="False")
                        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".str_replace("'","`", $response['error']['list-item'])." with $tpa_data->account_name..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
                    else
                        $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
                }
            }

            //Add Account IDs for Smartship
            if($tpa_data->parent_id=='14')
            {
                $api_token = $this->smartship_tokengenerate($tpa_data->account_id);
                // _print_r($api_token);
                
                if(!empty($api_token['access_token'])) 
                {
                    $address_data = array(
                    'hub_details'   =>  [
                        "hub_name"      => $unreg_add->address_title,
                        "pincode"       => $unreg_add->pincode,
                        "city"          => $unreg_add->address_city,
                        "state"         => $unreg_add->address_state,
                        "address1"      => $unreg_add->addressee,
                        "address2"      => $unreg_add->full_address,
                        "hub_phone"     => $unreg_add->phone,
                        "delivery_type_id" =>'2'
                    ]);
                    $fields=json_encode($address_data);
                    
                    $headers = array(
                        'Content-Type: application/json',
                        'Authorization:Bearer '.$api_token['access_token']
                    );
                    
                    $apilogs_data = array(
                        'partner'       => 'Smartship',
                        'event_name'    => 'AddWarehouse-Bulk',
                        'event_id'      => $api_token['account_name'],
                        'payload'       => $fields
                    );
                    $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://api.smartship.in/v2/app/Fulfillmentservice/hubRegistration' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result_wh = json_decode($result);
                        
                        //Updating Response in APILog
                        $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

                        if(!empty($result_wh) && isset($result_wh->data->hub_id))
                        {
                            //Storing Vendor Address/Hub Id
                            $users_address_ids = array(
                                "address_id "    => $unreg_add->user_address_id,
                                "account_id"     => $tpa_data->account_id,
                                "vendor_add_id"  => $result_wh->data->hub_id,
                                'added_by'       => $this->session->userdata['user_session']['admin_username'],
                                'updated_by'     => $this->session->userdata['user_session']['admin_username'],
                                );
                            $this->db->trans_start(); //Starting Transaction
                                $this->db->insert('users_address_ids',$users_address_ids);
                                $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
                            $this->db->trans_complete(); //Completing transaction
                        }
                        else
                            $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), 'For BlueDartSS -". implode(" , ",$result_wh->data->message->validation_error)."..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
                }
                else
                    $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), 'For BlueDartSS -".$api_token['error_description']."..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
            }    
            //end Smartship code 
        }

        $return_data = array(
            'status' => 'success',
            'tot_add' => $total_address,
            'reg_add' => $reg_address
        );

        return $return_data;
    }


    public function smartship_tokengenerate($account_id)
    {
        $tpa = $this->db->select('account_username,account_password,account_key,account_secret,account_name')->where('account_id',$account_id)->get('master_transitpartners_accounts')->row();

        $loginData = json_encode(array(
            "username"      => $tpa->account_username,
            "password"      => $tpa->account_password,
            "client_id"     => $tpa->account_key,
            "client_secret" => $tpa->account_secret,
            "grant_type"    => 'password'
        ));

        //Inserting API Log
        $apilogs_data = array(
            "partner"      => $tpa->account_name,
            "event_name"   => 'TokenGeneration',
            "payload"      => $loginData,
        );
        $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://oauth.smartship.in/loginToken.php');
        curl_setopt( $ch,CURLOPT_POST,true);
        curl_setopt( $ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt( $ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt( $ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$loginData );
        $response_result = curl_exec($ch);
        curl_close($ch);
        $result=json_decode($response_result,1);

        //Updating Response in APILog
        $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result)]);

        if(!empty($result))
        {
            $result['account_name'] = $tpa->account_name;
            return $result;
        }
        else
            return false;
    }

    public function delhiveryb2b_jwtoken($tpa)
    {
        // _print_r($tpa,1);
        $orderData=array(
            'username'      => $tpa->account_username,
            'password'      => $tpa->account_password
        );
        $jsonData =json_encode($orderData);
        $headers = array(
            'Content-Type: application/json',
        );

        //Inserting API Log
        $apilogs_data = array(
            'partner'       => $tpa->account_name,
            'event_name'    => 'Generate-JWTToken',
            'event_id'      => '',
            'payload'       => $jsonData,
        );
        $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://btob-api-dev.delhivery.com/ums/login/' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData ); 
        $result = curl_exec($ch );
        curl_close( $ch );
        $resultData=json_decode($result);
        // _print_r($resultData,1);
        
        //Updating API Log
        $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>$result]);

        if(!empty($resultData))
            return $resultData->jwt;
        else
            return false;
    }

    public function Registerwarehouse($postData)
    {
        // _print_r($postData);
        $params = $this->db->where('user_address_id',$postData['address_id'])->get('users_address')->row();
        // _print_r($params);
        // _print_r($postData['courierPartner'],1);
        if($postData['courierPartner'][0] == '0')
            $courierData = $this->db->where('account_status','1')->where_in('parent_id',[1,7,13,14])->get('master_transitpartners_accounts')->result();
        else
            $courierData = $this->db->where_in('account_id',$postData['courierPartner'])->get('master_transitpartners_accounts')->result();

        // _print_r($courierData,1);
        $success_cnt = 0;
        $error_cnt = 0;
        foreach ($courierData as $key => $tpa_data)
        {
            // _print_r($tpa_data,1);
            // Add Warehouse for Account IDs for Delhivery
            if($tpa_data->account_id=='1' || $tpa_data->account_id=='15' || $tpa_data->account_id=='16')
            {
                $address_data = array(
                    'phone' =>$params->phone,
                    "city"  =>$params->address_city,
                    "name"  =>$params->address_title,
                    "pin"   =>$params->pincode,
                    "address"=>$params->full_address,
                    "country"=>"India",
                    "email"=>"",
                    "registered_name"=>$params->address_title,
                    "return_address"=>$params->full_address,
                    "return_pin"=>$params->pincode,
                    "return_city"=>$params->address_city,
                    "return_state"=>$params->address_state,
                    "return_country"=>"India"
                );
        
                $fields=json_encode($address_data);
                
                $headers = array
                (
                    'Authorization: Token '.$tpa_data->account_key,
                    'Content-Type: application/json'
                );

                // _print_r($fields,1);
                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => 'Delhivery',
                    'event_name'    => 'Re-registerWarehouse',
                    'event_id'      => $tpa_data->account_name,
                    'payload'       => $fields,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://staging-express.delhivery.com/api/backend/clientwarehouse/create/' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
                $result = curl_exec($ch);
                curl_close($ch);
                // _print_r($result,1);
                $xml = simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);
                $response = json_decode(json_encode((array)$xml), TRUE);

                // $response = json_encode(simplexml_load_string($result));
                // _print_r($response,1);

                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($xml) && !empty($response))
                {
                    if($response['success']=="False")
                    {
                        $error_cnt++;
                        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".str_replace("'","`", $response['error']['list-item'])." Error with ".$tpa_data->account_name."..! ') WHERE address_title='".$params->address_title."'");
                    }
                    else
                    {
                        $success_cnt++;
                        $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE address_title='".$params->address_title."'");
                    }
                }
            }

            // Add Warehouse for Account IDs for Delhivery B2B
            if($tpa_data->account_id=='26')
            {
                $address_data = json_encode(array(
                    'phone' =>$params->phone,
                    "city"  =>$params->address_city,
                    "name"  =>$params->address_title,
                    "pin"   =>$params->pincode,
                    "address"=>$params->full_address,
                    "country"=>"India",
                    "email"=>"",
                    "registered_name"=>$params->address_title,
                    "return_address"=>$params->full_address,
                    "return_pin"=>$params->pincode,
                    "return_city"=>$params->address_city,
                    "return_state"=>$params->address_state,
                    "return_country"=>"India"
                ));

                $apitoken = $this->delhiveryb2b_jwtoken($tpa_data);

                //Inserting API Log
                $apilogs_data = array(
                    'partner'       => $tpa_data->account_name,
                    'event_name'    => 'AddWarehouse',
                    'event_id'      => $params->user_address_id,
                    'payload'       => $address_data,
                );
                $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                $headers = array
                (
                    'Authorization: Bearer ' . $apitoken,
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://track.delhivery.com/api/backend/clientwarehouse/create/' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, $address_data );
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);
                $response = json_decode(json_encode((array)$xml), TRUE);
                //Updating Response in APILog
                $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($response)]);
                if(!empty($xml) && !empty($response))
                {
                    if($response['success']=="False")
                    {
                        $error_cnt++;
                        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".str_replace("'","`", $response['error']['list-item'])." error with $tpa_data->account_name..! ') WHERE user_address_id='".$params->user_address_id."'");
                    }
                    else
                    {
                        $success_cnt++;
                        $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$params->user_address_id."'");
                    }
                }
            }

            //Add Account IDs for Smartship
            else if($tpa_data->account_id=='17')
            {
                $api_token = $this->smartship_tokengenerate($tpa_data->account_id);

                if(!empty($api_token['access_token'])) 
                { 
                    $address_data = json_encode(array(
                        'hub_details'   =>  [
                            "hub_name"      => $params->address_title,
                            "pincode"       => $params->pincode,
                            "city"          => $params->address_city,
                            "state"         => $params->address_state,
                            "address1"      => $params->addressee,
                            "address2"      => $params->full_address,
                            "hub_phone"     => $params->phone,
                            "delivery_type_id" =>'2'
                    ]));

                    //Inserting API Log
                    $apilogs_data = array(
                        'partner'       => 'Smartship',
                        'event_name'    => 'Re-registerWarehouse',
                        'event_id'      => $tpa_data->account_name,
                        'payload'       => $address_data
                    );
                    $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

                    $headers = array(
                        'Content-Type: application/json',
                        'Authorization:Bearer '.$api_token['access_token']
                    );

                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://api.smartship.in/v2/app/Fulfillmentservice/hubRegistration' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, $address_data );
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result_wh = json_decode($result);
                        
                    //Updating Response in APILog
                    $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

                    if(!empty($result_wh) && isset($result_wh->data->hub_id))
                    {
                        $success_cnt++;
                        //Storing Vendor Address/Hub Id
                        $users_address_ids = array(
                            "address_id "    => $params->user_address_id,
                            "account_id"     => $tpa_data->account_id,
                            "vendor_add_id"  => $result_wh->data->hub_id,
                            'added_by'       => $params->added_by,
                            'updated_by'     => $params->updated_by,
                        );
                        
                        $this->db->trans_start(); //Starting Transaction
                            $this->db->insert('users_address_ids',$users_address_ids);
                            $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$params->user_address_id."'");
                        $this->db->trans_complete(); //Completing transaction
                    }
                    else
                    {
                        $error_cnt++;
                        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '". json_encode($result_wh->data->message->validation_error)." Error with ".$tpa_data->account_name."..! ') WHERE user_address_id='".$params->user_address_id."'");
                    }
                }
                else
                    $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$api_token['error_description']."..! ') WHERE user_address_id='".$params->user_address_id."'");
            }
        }
        $return_data = array(
            'success_cnt' => $success_cnt,
            'error_cnt'   => $error_cnt
        );
        // _print_r($return_data,1);
        return $return_data;
    }
    
}
?>

/*
//Add Account IDs for Udaan
if($tpa_data->parent_id=='X4')
{
    $address_data = array(
        'orgUnitId'     => '',
        "addressLine1"  => $unreg_add->full_address,
        "addressLine2"  => "",
        "addressLine3"  => "",
        "city"          => $unreg_add->address_city,
        "state"         => $unreg_add->address_state,
        "pincode"       => $unreg_add->pincode,
        "unitName"      => $unreg_add->address_title,
        "representativeName" => $unreg_add->addressee,
        'mobileNumber' =>$unreg_add->phone,
    );
    $fields=json_encode($address_data);

    $headers = array
    (
        'Authorization:'.$tpa_data->account_key,
        'Content-Type: application/json',
        'cf-access-client-id:'.$tpa_data->account_username,
        'cf-access-client-secret:'.$tpa_data->account_secret
    );
    // _print_r($fields);

    //Inserting API Log
    $apilogs_data = array(
        'partner'       => 'Udaan',
        'event_name'    => 'AddWarehouse-Bulk',
        'event_id'      => $tpa_data->account_name,
        'payload'       => $fields,
    );
    $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL,'https://dev.udaan.com/api/udaan-express/integration/v1/address/'.$tpa_data->account_description);
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
    $result = curl_exec($ch);
    curl_close($ch);
    
    $result_wh = json_decode($result);
    // _print_r($result_wh);
    // die();
    //Updating Response in APILog
    $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

    if(!empty($result_wh) && !empty($result_wh->response) && $result_wh->responseCode=="UE_1001")
        $this->db->query("UPDATE users_address SET vendor_add_id ='".$result_wh->response->orgUnitId."', registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE address_title='".$unreg_add->address_title."'");
    else
        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE address_title='".$unreg_add->address_title."'");
}

//Add Account IDs for OnlineXpress
if($tpa_data->parent_id=='7')
{
    $add_code = time();
    $address_data = array(
        'id'            => '',
        "shortcode"     => $unreg_add->address_title."_".$add_code,
        "customer_id"   => $tpa_data->account_secret,
        "address"       => $unreg_add->full_address,
        "city"          => $unreg_add->address_city,
        "pincode"       => $unreg_add->pincode,
        "phone"         => $unreg_add->phone,
        "type"          => 'pickup',
        "isactive"      => 'Y'
    );

    $fields=json_encode($address_data);

    // .$tpa_data->account_username,
    // 
    $headers = array(
        'Content-Type: application/json',
        'AUTH_USER: '.$tpa_data->account_username,
        'AUTH_PW: '.$tpa_data->account_key
    );

    //Inserting API Log
    $apilogs_data = array(
        'partner'       => 'OnlineXpress',
        'event_name'    => 'AddWarehouse-Bulk',
        'event_id'      => $tpa_data->account_name,
        'payload'       => $fields,
    );
    $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'http://onlinexpress.co.in/admin/services/addData/pickup' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
    $result = curl_exec($ch);
    curl_close($ch); 
    $result_wh = json_decode($result);

    //Updating Response in APILog
    $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

    if(!empty($result_wh) && $result_wh->failedDetails == "SUCCESS")
    {
        //Storing Vendor Address/Hub Id
        $users_address_ids = array(
            "address_id "    => $unreg_add->user_address_id,
            "account_id"     => $tpa_data->account_id,
            "vendor_add_id"  => $add_code,
            'added_by'       => $this->session->userdata['user_session']['admin_username'],
            'updated_by'     => $this->session->userdata['user_session']['admin_username'],
        );
        $this->db->trans_start(); //Starting Transaction
            $this->db->insert('users_address_ids',$users_address_ids);
            $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
        $this->db->trans_complete(); //Completing transaction
    }
    else
        $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE address_title='".$unreg_add->address_title."'");
}
*/


//Add Account IDs for OnlineXpress
// else if($tpa_data->account_id=='10')
// {
//     $add_code = time();
//     $address_data = array(
//         'id'            => '',
//         "shortcode"     => $params->address_title."_".$add_code,
//         "customer_id"   => $tpa_data->account_secret,
//         "address"       => $params->full_address,
//         "city"          => $params->address_city,
//         "pincode"       => $params->pincode,
//         "phone"         => $params->phone,
//         "type"          => 'pickup',
//         "isactive"      => 'Y'
//     );
//     $fields=json_encode($address_data);

//     $headers = array(
//         'Content-Type: application/json',
//         'AUTH_USER: '.$tpa_data->account_username,
//         'AUTH_PW: '.$tpa_data->account_key
//     );

//     //Inserting API Log
//     $apilogs_data = array(
//         'partner'       => 'OnlineXpress',
//         'event_name'    => 'Re-registerWarehouse',
//         'event_id'      => $tpa_data->account_name,
//         'payload'       => $fields,
//     );
//     // _print_r($fields,1);
//     $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

//     $ch = curl_init();
//     curl_setopt( $ch,CURLOPT_URL, 'http://onlinexpress.co.in/admin/services/addData/pickup');
//     curl_setopt( $ch,CURLOPT_POST, true );
//     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//     curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
//     $result = curl_exec($ch);
//     curl_close($ch);
    
//     $result_wh = json_decode($result);

//     // print_r($result_wh);
//     // die();

//     //Updating Response in APILog
//     $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

//     if(!empty($result_wh) && $result_wh->failedDetails == "SUCCESS")
//     {
//         $success_cnt++;
//         //Storing Vendor Address/Hub Id
//         $users_address_ids = array(
//         "address_id "    =>$params->user_address_id,
//         "account_id"     =>$tpa_data->account_id,
//         "vendor_add_id"  =>$add_code,
//         'added_by'       =>$params->added_by,
//         'updated_by'     =>$params->updated_by,
//         );
//         $this->db->trans_start(); //Starting Transaction
//         $this->db->insert('users_address_ids',$users_address_ids);
//         $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$params->user_address_id."'");
//         $this->db->trans_complete(); //Completing transaction
//     }
//     else
//     {
//         $error_cnt++;
//         $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE user_address_id='".$params->user_address_id."'");
//     }
// }




/* =========================PROD CODE BELOW ============================*/

//Add Account IDs for OnlineXpress
// else if($tpa_data->account_id=='10')
// {
//     $add_code = time();
//     $address_data = array(
//         'id'            => '',
//         "shortcode"     => $params->address_title."_".$add_code,
//         "customer_id"   => $tpa_data->account_secret,
//         "address"       => $params->full_address,
//         "city"          => $params->address_city,
//         "pincode"       => $params->pincode,
//         "phone"         => $params->phone,
//         "type"          => 'pickup',
//         "isactive"      => 'Y'
//     );
//     $fields=json_encode($address_data);

//     $headers = array(
//         'Content-Type: application/json',
//         'AUTH_USER: '.$tpa_data->account_username,
//         'AUTH_PW: '.$tpa_data->account_key
//     );

//     //Inserting API Log
//     $apilogs_data = array(
//         'partner'       => 'OnlineXpress',
//         'event_name'    => 'Re-registerWarehouse',
//         'event_id'      => $tpa_data->account_name,
//         'payload'       => $fields,
//     );
//     // _print_r($fields,1);
//     $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

//     $ch = curl_init();
//     curl_setopt( $ch,CURLOPT_URL, 'http://onlinexpress.co.in/admin/services/addData/pickup');
//     curl_setopt( $ch,CURLOPT_POST, true );
//     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//     curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
//     $result = curl_exec($ch);
//     curl_close($ch);
    
//     $result_wh = json_decode($result);

//     // print_r($result_wh);
//     // die();

//     //Updating Response in APILog
//     $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

//     if(!empty($result_wh) && $result_wh->failedDetails == "SUCCESS")
//     {
//         $success_cnt++;
//         //Storing Vendor Address/Hub Id
//         $users_address_ids = array(
//         "address_id "    =>$params->user_address_id,
//         "account_id"     =>$tpa_data->account_id,
//         "vendor_add_id"  =>$add_code,
//         'added_by'       =>$params->added_by,
//         'updated_by'     =>$params->updated_by,
//         );
//         $this->db->trans_start(); //Starting Transaction
//         $this->db->insert('users_address_ids',$users_address_ids);
//         $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$params->user_address_id."'");
//         $this->db->trans_complete(); //Completing transaction
//     }
//     else
//     {
//         $error_cnt++;
//         $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE user_address_id='".$params->user_address_id."'");
//     }
// }




/*
//Add Account IDs for Udaan
// if($tpa_data->parent_id=='X4')
// {
//     $address_data = array(
//         'orgUnitId'     => '',
//         "addressLine1"  => $unreg_add->full_address,
//         "addressLine2"  => "",
//         "addressLine3"  => "",
//         "city"          => $unreg_add->address_city,
//         "state"         => $unreg_add->address_state,
//         "pincode"       => $unreg_add->pincode,
//         "unitName"      => $unreg_add->address_title,
//         "representativeName" => $unreg_add->addressee,
//         'mobileNumber' =>$unreg_add->phone,
//     );
//     $fields=json_encode($address_data);

//     $headers = array
//     (
//         'Authorization:'.$tpa_data->account_key,
//         'Content-Type: application/json',
//         // 'cf-access-client-id:'.$tpa_data->account_username,
//         // 'cf-access-client-secret:'.$tpa_data->account_secret
//     );
//     // _print_r($fields);

//     //Inserting API Log
//     $apilogs_data = array(
//         'partner'       => 'Udaan',
//         'event_name'    => 'AddWarehouse-Bulk',
//         'event_id'      => $tpa_data->account_name,
//         'payload'       => $fields,
//     );
//     $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

//     $ch = curl_init();
//     curl_setopt( $ch,CURLOPT_URL,'https://udaan.com/api/udaan-express/integration/v1/address/'.$tpa_data->account_description);
//     curl_setopt( $ch,CURLOPT_POST, true );
//     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//     curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
//     $result = curl_exec($ch);
//     curl_close($ch);
    
//     $result_wh = json_decode($result);
//     // _print_r($result_wh);
//     // die();
//     //Updating Response in APILog
//     $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

//     if(!empty($result_wh) && !empty($result_wh->response) && $result_wh->responseCode=="UE_1001")
//         $this->db->query("UPDATE users_address SET vendor_add_id ='".$result_wh->response->orgUnitId."', registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE address_title='".$unreg_add->address_title."'");
//     else
//         $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE address_title='".$unreg_add->address_title."'");
// }

//Add Account IDs for OnlineXpress
// if($tpa_data->parent_id=='7')
// {
//     $add_code = time();
//     $address_data = array(
//         'id'            => '',
//         "shortcode"     => $unreg_add->address_title."_".$add_code,
//         "customer_id"   => $tpa_data->account_secret,
//         "address"       => $unreg_add->full_address,
//         "city"          => $unreg_add->address_city,
//         "pincode"       => $unreg_add->pincode,
//         "phone"         => $unreg_add->phone,
//         "type"          => 'pickup',
//         "isactive"      => 'Y'
//     );

//     $fields=json_encode($address_data);

//     // .$tpa_data->account_username,
//     // 
//     $headers = array(
//         'Content-Type: application/json',
//         'AUTH_USER: '.$tpa_data->account_username,
//         'AUTH_PW: '.$tpa_data->account_key
//     );

//     //Inserting API Log
//     $apilogs_data = array(
//         'partner'       => 'OnlineXpress',
//         'event_name'    => 'AddWarehouse-Bulk',
//         'event_id'      => $tpa_data->account_name,
//         'payload'       => $fields,
//     );
//     $apilog_id = $this->insertions_model->insert('tbl_pushedapilogs',$apilogs_data);

//     $ch = curl_init();
//     curl_setopt( $ch,CURLOPT_URL, 'http://onlinexpress.co.in/admin/services/addData/pickup' );
//     curl_setopt( $ch,CURLOPT_POST, true );
//     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//     curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
//     $result = curl_exec($ch);
//     curl_close($ch);
//     $result_wh = json_decode($result);

//     //Updating Response in APILog
//     $this->updations_model->update('tbl_pushedapilogs',['apilog_id'=>$apilog_id],['response'=>json_encode($result_wh)]);

//     if(!empty($result_wh) && $result_wh->failedDetails == "SUCCESS")
//     {
//         //Storing Vendor Address/Hub Id
//         $users_address_ids = array(
//             "address_id "    => $unreg_add->user_address_id,
//             "account_id"     => $tpa_data->account_id,
//             "vendor_add_id"  => $add_code,
//             'added_by'       => $this->session->userdata['user_session']['admin_username'],
//             'updated_by'     => $this->session->userdata['user_session']['admin_username'],
//         );
//         $this->db->trans_start(); //Starting Transaction
//             $this->db->insert('users_address_ids',$users_address_ids);
//             $this->db->query("UPDATE users_address SET registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE user_address_id='".$unreg_add->user_address_id."'");
//         $this->db->trans_complete(); //Completing transaction
//     }
//         // $this->db->query("UPDATE users_address SET vendor_add_id ='".$add_code."', registered_status = '1', api_response = CONCAT(COALESCE(api_response,''), 'Warehouse Registered with $tpa_data->account_name..! ') WHERE address_title='".$unreg_add->address_title."'");
//     else
//         $this->db->query("UPDATE users_address SET api_response = CONCAT(COALESCE(api_response,''), '".$result_wh->responseMessage."..! ') WHERE address_title='".$unreg_add->address_title."'");
// }
*/