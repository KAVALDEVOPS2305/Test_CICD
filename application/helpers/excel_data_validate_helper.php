<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

function validate_zonedata($param1,$param2,$param3)
{
    if($param1!='' && $param2!='' && preg_match('/^[a-fA-F]*$/',$param3))
    	return "Validated";
    else
    	return "Data Mismatch";
}

function read_zonedata($inputFileName)
{
    $error_data = array();
    $error_cnt=0;
    $ci =& get_instance();
    try
    {
        // $object = PHPExcel_IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $object = $reader->load($inputFileName);

        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
                $source_city = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $destination_pin = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $zone = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                if((preg_match('/^[a-zA-Z0-9\s\-_.,&]+$/', $source_city)) AND (preg_match('/^(\d{6})$/', $destination_pin)) AND (preg_match('/^[a-fA-F]+$/', $zone)))
                {
                    $form_data[] = array(
                        'source_city'       => strtoupper($source_city),
                        'destination_pin'   => $destination_pin,
                        'zone'              => strtoupper($zone),
                        'added_by'          => $ci->session->userdata['user_session']['admin_username'],
                        'updated_by'        => $ci->session->userdata['user_session']['admin_username']
                    );
                }
                else
                {
                    if(!preg_match('/^[a-zA-Z0-9\s\-_.,&]+$/', $source_city))
                    {
                        $error_data[] = array(
                            'source_city'       => strtoupper($source_city),
                            'destination_pin'   => $destination_pin,
                            'zone'              => strtoupper($zone),
                            'error'             => "Invalid city name at row # ".$row,
                        );
                    }

                    else if(!preg_match('/^(\d{6})$/', $destination_pin))
                    {
                        $error_data[] = array(
                            'source_city'       => strtoupper($source_city),
                            'destination_pin'   => $destination_pin,
                            'zone'              => strtoupper($zone),
                            'error'             => "Invalid pincode at row # ".$row,
                        );
                    }

                    else if(!preg_match('/^[a-fA-F]+$/', $zone))
                    {
                        $error_data[] = array(
                            'source_city'       => strtoupper($source_city),
                            'destination_pin'   => $destination_pin,
                            'zone'              => strtoupper($zone),
                            'error'             => "Invalid zone at row # ".$row,
                        );
                    }
                }
            }
        }
        // print_r($form_data);
        // print_r($error_data);
        return array($form_data, $error_data);
    }
    catch(Exception $e)
    {
        $output['error'] = true;
        $output['title'] = 'Error importing file';
        $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
    }

}

function read_pinservicesdata($inputFileName)
{
    $error_data = array();
    $ci =& get_instance();
    try
    {
        // $object = PHPExcel_IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $object = $reader->load($inputFileName);

        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
                $pincode = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $pickup = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $reverse = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $prepaid = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $cod = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $dangerous_goods = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $ndd = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                if((preg_match('/^(\d{6})$/', $pincode)) AND (preg_match('/^[YN]$/i', $pickup)) AND (preg_match('/^[YN]$/i', $reverse)) AND (preg_match('/^[YN]$/i', $prepaid)) AND (preg_match('/^[YN]$/i', $cod)) AND (preg_match('/^[YN]$/i', $dangerous_goods)) AND (preg_match('/^[YN]$/i', $ndd)))
                {
                    $form_data[] = array(
                        'account_id'       => $ci->input->post('account_id'),
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'added_by'         => $ci->session->userdata['user_session']['admin_username']
                    );
                }
                else if(!empty($pincode) || !empty($pickup) || !empty($reverse) || !empty($prepaid) || !empty($cod) || !empty($dangerous_goods) || !empty($ndd))
                {
                    if(!preg_match('/^(\d{6})$/', $pincode))
                    {
                        $error_data[] = array(
                        'pincode'          => '<span class="text-danger"><b>'.$pincode.'</b></span>',
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'error'             => "Invalid pincode at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $pickup))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => '<span class="text-danger"><b>'.strtoupper($pickup).'</b></span>',
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'error'            => "Invalid pickup value at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $reverse))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => '<span class="text-danger"><b>'.strtoupper($reverse).'</b></span>',
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'error'            => "Invalid reverse value at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $prepaid))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => '<span class="text-danger"><b>'.strtoupper($prepaid).'</b></span>',
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'error'            => "Invalid prepaid value at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $cod))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => '<span class="text-danger"><b>'.strtoupper($cod).'</b></span>',
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => strtoupper($ndd),
                        'error'            => "Invalid cod value at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $dangerous_goods))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => '<span class="text-danger"><b>'.strtoupper($dangerous_goods).'</b></span>',
                        'ndd'              => strtoupper($ndd),
                        'error'            => "Invalid DG value at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^[YN]$/i', $ndd))
                    {
                        $error_data[] = array(
                        'pincode'          => $pincode,
                        'pickup'           => strtoupper($pickup),
                        'reverse'          => strtoupper($reverse),
                        'prepaid'          => strtoupper($prepaid),
                        'cod'              => strtoupper($cod),
                        'dangerous_goods'  => strtoupper($dangerous_goods),
                        'ndd'              => '<span class="text-danger"><b>'.strtoupper($ndd).'</b></span>',
                        'error'            => "Invalid NDD at row # ".$row,
                        );
                    }
                }
            }
        }
        // echo '<pre>';
        // print_r($form_data);
        // echo '</pre><pre>';
        // print_r($error_data);
        // echo '</pre>';
        // die();
        return array($form_data, $error_data);
    }
    catch(Exception $e)
    {
        $output['error'] = true;
        $output['title'] = 'Error importing file';
        $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
    }

}

function read_weightupdatedata($inputFileName)
{
    $error_data = array();
    $ci =& get_instance();
    try
    {
        //$object = PHPExcel_IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $object = $reader->load($inputFileName);

        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
            {
                $awb_num = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $new_wt = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                if((preg_match('/^[A-Za-z0-9]+$/', $awb_num)) AND !empty($new_wt) AND (preg_match('/^\d{0,10}(\.\d{0,2})?$/', $new_wt)))
                {
                    $form_data[] = array(
                        'waybill_number' => $awb_num,
                        'billing_weight' => $new_wt,
                        'updated_by'     => $ci->session->userdata['user_session']['admin_username']
                    );
                }
                else if(!empty($awb_num) || !empty($new_wt))
                {
                    if(!preg_match('/^[A-Za-z0-9]+$/', $awb_num))
                    {
                        $error_data[] = array(
                        'waybill_number' => '<span class="text-danger"><b>'.$awb_num.'</b></span>',
                        'billing_weight' => $new_wt,
                        'error'          => "Invalid waybill at row # ".$row,
                        );
                    }
                    else if(!preg_match('/^\d{0,10}(\.\d{0,2})?$/', $new_wt))
                    {
                        $error_data[] = array(
                        'waybill_number' => $awb_num,
                        'billing_weight' => '<span class="text-danger"><b>'.$new_wt.'</b></span>',
                        'error'          => "Invalid weight at row # ".$row,
                        );
                    }
                }
            }
        }
        // echo '<pre>';
        // print_r($form_data);
        // echo '</pre><pre>';
        // print_r($error_data);
        // echo '</pre>';
        // die();
        return array($form_data, $error_data);
    }
    catch(Exception $e)
    {
        $output['error'] = true;
        $output['title'] = 'Error importing file';
        $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
    }
}

function read_reportmisdata($inputFileName)
{
    $ci =& get_instance();
    try
    {
        //$object = PHPExcel_IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $object = $reader->load($inputFileName);

        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestColumn();
            
            for($row=2; $row<=$highestRow; $row++)
                $fetch_data[] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        }
        return $fetch_data;
        // echo "<pre>";print_r($fetch_data);exit;
    }
    catch(Exception $e)
    {
        $output['error'] = true;
        $output['title'] = 'Error importing file';
        $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
    }
}

function read_awb_trackingdata($inputFileName)
{
    try
    {
        //$object = PHPExcel_IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $object = $reader->load($inputFileName);

        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
                $fetch_data[] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        }
        return $fetch_data;
    }
    catch(Exception $e)
    {
        $output['error'] = true;
        $output['title'] = 'Error importing file';
        $output['message'] = pathinfo($inputFileName, PATHINFO_BASENAME).'": '.$e->getMessage();
    }
}

?>