<?php
class AWBGeneration_model extends CI_Model
{
    //Batch Id Generation for XBees
    public function XBees_GenerateBatchid($data)
    {
        $batchid_apiload =json_encode(
            array(
            'BusinessUnit'  =>  "ECOM",
            "ServiceType"   =>  strtoupper($data['shipment_type']),
            "DeliveryType"  =>  $data['pay_mode']=="PPD"? "PREPAID":$data['pay_mode'],
            )
        );

        $headers = array
        (
            'XBKey: Y4h2L3l1',
            'Content-Type: application/json'
        );

        $batchid_url = 'http://49.248.221.43:803/StandardForwardStagingService.svc/AWBNumberSeriesGeneration';
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,$batchid_url);
        curl_setopt( $ch,CURLOPT_POST,true);
        curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt( $ch,CURLOPT_POSTFIELDS,$batchid_apiload);
        $Batchid_result = json_decode(curl_exec($ch));
        curl_close($ch);
        // print_r($Batchid_result);
        // die();
        return $Batchid_result;
    }

    public function generate_awb($awb_data)
    {
        // print_r($awb_data); 
        if($awb_data['transit_partner']==3)
        {
            $XBees_BatchRes = $this->XBees_GenerateBatchid($awb_data);
            // print_r($XBees_BatchRes);
            if($XBees_BatchRes->ReturnMessage=="Successful" && $XBees_BatchRes->ReturnCode=="100")
            {
                // echo "BatchId =".$XBees_BatchRes->BatchID;
                $awbgeneration_apiload =json_encode(
                    array(
                    'BusinessUnit'  =>  "ECOM",
                    "ServiceType"   =>  strtoupper($awb_data['shipment_type']),
                    "BatchID"       =>  $XBees_BatchRes->BatchID,
                    )
                );

                $headers = array
                (
                    'XBKey: Y4h2L3l1',
                    'Content-Type: application/json'
                );

                $batchid_url = 'http://49.248.221.43:803/StandardForwardStagingService.svc/GetAWBNumberGeneratedSeries';
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL,$batchid_url);
                curl_setopt( $ch,CURLOPT_POST,true);
                curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt( $ch,CURLOPT_POSTFIELDS,$awbgeneration_apiload);
                $awb_result = json_decode(curl_exec($ch));
                curl_close($ch);

                // print_r($awb_result);

                if($awb_result->ReturnMessage=="Successful" && $awb_result->ReturnCode=="100")
                {
                    echo "AWB Generated";
                    $c=0;
                    foreach ($awb_result->AWBNoSeries as $awbns) {
                        $ins_awbdata[$c] = array(
                            'transit_partner'   => $awb_data['transit_partner'],
                            'shipment_type'     => $awb_data['shipment_type'],
                            'pay_mode'          => $awb_data['pay_mode'],
                            'waybill_num'       => $awbns[$c],
                        );
                        $c++;
                    }

                    // print_r($ins_awbdata);
                    return $this->db->insert_batch('pregenerated_awbs',$ins_awbdata);

                }
                else
                    return $awb_result;
            }
            else
                return $XBees_BatchRes;
        }
    }


}
?>