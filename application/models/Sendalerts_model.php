<?php
class Sendalerts_model extends CI_Model
{
    public function trigger_alerts($event,$alertsdata)
    {
        //Prepare Message Content
        if($event=="user_complete_registration")
        {
            $msg = "Dear ".$alertsdata['fullname'].", Welcome to InTargos.\r\nLogin to InTargos portal at https://app.intargos.com/ with\r\nUsername: ".$alertsdata['username']." &\r\nPassword: ".$alertsdata['password'].".\r\nFor more details check your email. Please change your password after login.\r\nRegards\r\nTeam InTargos\r\nhttps://intargos.com/";

            $this->SendSMS($msg,$alertsdata['number']);
            $this->SendEmail(2,$alertsdata);
        }
    }

    public function SendSMS($msg,$to)
    {
        // echo $msg;
        $encoded_msg = urlencode($msg);
        $URL         = 'http://alerts.solutionsinfini.com/api/v4/?api_key=A28ac4fa3a6dce354cc2ee3adbe1d3fa7&method=sms&sender=INTRGS&to='.$to.'&message='.$encoded_msg;
        // echo $URL;
        //Send SMS
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        // echo $err;
        // echo $response;
    }

    public function SendEmail($templateId,$mailData)
    {
        $headers = array
        (
            'api-key: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',
            'Content-Type: application/json',
            'Accept: application/json'
        );

        $emailData = array(
            'templateId' => $templateId,
            'to' => [[
                'name'  =>  $mailData['fullname'],
                'email' =>  $mailData['email']
            ]],
            'bcc' => [[
                'name'  =>  'Pankaj Dudeja',
                'email' =>  'pankaj@intargos.com'
            ]],
            'params' => [
                'Fullname'      =>  $mailData['fullname'],
                'Businessname'  =>  $mailData['businessname'],
                'username'      =>  $mailData['username'],
                'password'      =>  $mailData['password']
            ]
        );

        $Data = json_encode($emailData);
        // print_r($Data);
        $emailURL = "https://api.sendinblue.com/v3/smtp/email";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $emailURL);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$Data); 
        $result = curl_exec($ch);
        curl_close($ch);
        // print_r($result);
        // die();
    }

}
?>