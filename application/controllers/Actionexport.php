<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Actionexport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load model
        $this->load->model('exportdata_model');
        $this->load->helper('file_upload');
        $this->load->helper('excel_data_validate');
    }

    public function weight_update_errordownload()
	{
        $postData=$this->input->post();
        // print_r($postData);
        // die();
	    $filename = 'WeightUpdate_Errors-'.now().'.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array('AWB Number', 'Updated Weight','Error');
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        $i=0;
        foreach ($postData['waybill'] as $errors)
        {            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount,($postData['waybill'][$i]!='null')?$postData['waybill'][$i]:'');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount,($postData['weight'][$i]!='null')?$postData['weight'][$i]:'');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, ($postData['error'][$i]!='null')?$postData['error'][$i]:'');
            
            $rowCount++;  
            $i++;      
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
	}

    //Create Excel for dowloading searched invoice
    public function searched_invoices()
    {
        $datalist = $this->exportdata_model->searched_invoices($_POST);
        // create file name
        $filename = 'Invoices -'.now().'.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array("Invoice #", "Invoice Date", "Business Name", "GST", "Billing", "Email", "Contact", "Billing/Client State", "Shipment Counts", "Taxable Amount", "Tax Amount", "Invoice Amount", "Paid Amount", "Due Amount", "Credit Period", "Status","Modified On");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->px_invoice_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, date('d-m-Y', strtotime($list->invoice_date)));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->business_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->kyc_gst_reg == "yes" ? $list->kyc_doc_number : "URP");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, ucwords($list->billing_type));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->email_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->contact);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->billing_state);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->shipments_count);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->invoice_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->gst_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->total_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->paid_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->due_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->credit_period.' days');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->invoice_status == 0 ? 'Due' : ($list->invoice_status == 1 ? 'Paid' : 'Pending'));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->updated_on);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    //Create Excel for dowloading AWBs from invoice
    public function download_invoice_awbs()
    {
        if(isset($_GET['inv']))
        {
            $invoice_number = $_GET['inv'];
            $datalist = $this->exportdata_model->download_invoice_awbs($invoice_number);
            // create file name
            $filename = 'Invoice AWBs - '.$invoice_number.'-'.now().'.xlsx';       
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $table_columns = array("ORDER ID", "AWB NUMBER", "SHIPMENT TYPE", "ORDER TYPE", "DESTINATION PERSON", "DESTINATION CITY","DESTINATION STATE" ,"DESTINATION PINCODE", "ORDERED ON", "ORDER AMOUNT", "COD AMOUNT", "DIMENSIONS", "MODE","STATUS","STATUS DATE","SOURCE LOCATION","SOURCE PINCODE","BILLING WEIGHT", "FORWARD CHARGES", "RTO CHARGES", "COD CHARGES", "FOV CHARGES", "FSC CHARGES", "SURCHARGE 1", "SURCHARGE 2", "SURCHARGE 3", "SURCHARGE 4", "NDD CHARGES", "AWB CHARGES", "CHARGES TOTAL", "GST AMOUNT", "TOTAL AMOUNT");
            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($datalist as $list) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->shipment_id);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->waybill_number);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, ucwords($list->shipment_type));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, ucwords($list->payment_mode));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, ucwords($list->consignee_name));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, ucwords($list->consignee_city));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, ucwords($list->consignee_state));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->consignee_pincode);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, date('d-m-Y', strtotime($list->order_date)));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->order_amt);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->cod_amount);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->shipment_length.' x '.$list->shipment_width.' x '.$list->shipment_height);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, ucwords($list->express_type));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->status_title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->billing_eligible_date);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->address_title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->pincode);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, $list->billing_weight);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->forward_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->rto_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, $list->cod_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, $list->fov_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, $list->fsc_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, $list->surcharge_1);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, $list->surcharge_2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $list->surcharge_3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, $list->surcharge_4);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, $list->ndd_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$rowCount, $list->awb_charges);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$rowCount, $list->charges_total);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31,$rowCount, $list->gst_amount);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32,$rowCount, $list->total_amount);
                $rowCount++;
            }
            //Highlight Head Row
            $objPHPExcel->getActiveSheet()->getStyle('A1:AF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
            //Clear the buffer, to avoid garbled 
            if (ob_get_contents())
            ob_end_clean(); 
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter->save('php://output');
        }
    }

    //Create Excel for dowloading AWBs from COD
    public function download_cod_awbs()
    {
        if(isset($_GET['cod_id']))
        {
            $cod_trn = $_GET['cod_id'];
            $datalist = $this->exportdata_model->download_cod_awbs($cod_trn);
            // create file name
            $filename = 'COD AWBs - '.$cod_trn.'-'.now().'.xlsx';       
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $table_columns = array("COD TRN","ORDER ID", "AWB NUMBER", "INVOICE #", "COURIER NAME", "BILLING DATE", "COD AMOUNT", "STATUS","DELIVERY DATE","COD GAP","COD ELIGIBLE ON","COD CYCLE","PREVIOUS COD TRN");
            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($datalist as $list) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->cod_trn);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->shipment_id);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->waybill_number);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->invoice_number);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->account_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, date('d-m-Y', strtotime($list->billing_date)));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->cod_status == '3' ? '-'.$list->cod_amount : $list->cod_amount);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->cod_status == '0' ? 'Pending' : ($list->cod_status == '1' ? 'Received' : ($list->cod_status == '2' ? 'Billed' : 'NA')));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->cod_status != '3' ? date('d-m-Y', strtotime($list->cod_date)) : 'NA');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->cod_gap." Days");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->cod_status != '3' ? date('d-m-Y', strtotime($list->cod_eligible_date)) : '-');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->cod_status != '3' ? date('d-m-Y', strtotime($list->cod_cycle_date)) : '-');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, !empty($list->previous_codtrn) && $list->previous_codtrn != $list->cod_trn ? $list->previous_codtrn : '-');
                $rowCount++;
            }
            //Highlight Head Row
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
            //Clear the buffer, to avoid garbled 
            if (ob_get_contents())
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter->save('php://output');
        }
    }

    //Create Excel for dowloading searched CODs
    public function searched_cods()
    {
        $datalist = $this->exportdata_model->searched_cods($_POST);
        // create file name
        $filename = 'CODs -'.now().'.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array("BUSINESS NAME", "BILLING", "CONTACT","EMAIL","COD TRN","COD AMOUNT","COD CYCLE DATE","COD ADJUST", "CREDIT PERIOD", "BENEFICIARY NAME", "ACCOUNT #", "IFSC CODE", "BANK NAME", "BRANCH NAME");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->business_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, ucwords($list->billing_type));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->contact);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->email_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->cod_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->cod_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, date('d-m-Y', strtotime($list->cod_cycle_date)));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->codadjust);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->credit_period.' days');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->beneficiary_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->account_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->ifsc_code);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->bank_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->branch_name);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    //Create Excel for dowloading Shipments Reports - Processed Orders
    public function reports_shipments()
    {
        $datalist = $this->exportdata_model->reports_shipments($_POST);
        // create file name
        $filename = 'ProcessedShipments.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array("Username","OrderId", "WayBill Number", "Order Date", "Mode", "Express", "Consignee Name", "Consignee Contact", "Address", "City", "State", "Pincode", "COD Amount" , "Dimensions" , "Weight" , "Fulfilled By" , "Status");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->shipment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->waybill_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->order_date);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->express_type);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->consignee_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->consignee_mobile);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->consignee_address1.",".$list->consignee_address2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->consignee_city);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->consignee_state);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->consignee_pincode);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->cod_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->shipment_length."x".$list->shipment_width."x".$list->shipment_height);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->shipment_weight);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->account_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->status_title);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        //Clear the buffer, to avoid garbled 
        if (ob_get_contents())
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

	public function reports_addresses()
    {
        if(strtoupper($this->session->userdata('user_session')['role_name']) == 'SUPERADMIN' || $this->permissions_model->check_permission('reports_addresses'))
        {
            $datalist = $this->searchdata_model->address_user($_POST);
            // create file name
            $filename = 'UserAddresses.xlsx';       
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $table_columns = array("Address Id","Username", "Business Name", "Address title", "Adressee", "Full Address", "Phone", "Pin", "City", "State");

            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($datalist as $list) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->user_address_id);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->username);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->business_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->address_title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->addressee);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->full_address);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->phone);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->pincode);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->address_city);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->address_state);
                $rowCount++;
            }
            //Highlight Head Row
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
            //Clear the buffer, to avoid garbled 
            if (ob_get_contents())
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter->save('php://output');
        }
        else
            redirect('unauthorised');
    }

    public function reports_mis()
    {
        if($this->input->post('is_mps') == '1')
        {
            $search_field=array(
            'username'=>$this->input->post('username'),
            'waybill_number'=>$this->input->post('waybill_number'),
            'shipment_id'=>$this->input->post('shipment_id'),
            'address_title'=>$this->input->post('address_title'),
            'user_status'=>$this->input->post('user_status'),
            'payment_mode'=>$this->input->post('payment_mode'),
            'express_type'=>$this->input->post('express_type'),
            'shipment_type'=>$this->input->post('shipment_type'),
            'fulfilled_account'=>$this->input->post('fulfilled_account'),
            'order_date'=>$this->input->post('order_date'),
            'from_date'=>$this->input->post('from_date'),
            'to_date'=>$this->input->post('to_date'),
            );
            $datalist = $this->exportdata_model->reports_mis('mpssingle',$search_field,'');
            
            /*Download file mps single search basis and add extra field */
            if(!empty($datalist))
            {
                $filename = 'MpsMisReports.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);
                $table_columns = array("Username","Business Name","Full Name","Parent WayBill #","Child WayBill #","Order Id","Shipment Count","Order Date", "Consignee Name", "Consignee Contact", "Consignee Address", "Consignee City", "Consignee State", "Consignee Pincode", "Payment Mode", "COD Amount" ,"Express","Order Type", "Dimensions" , "Box Vol. Weight", "Box Weight","Shipment Weight","Billed Weight","Current Status","Last Scanned At","Last Location","Last Scan Remark","Delivery Attempts","Fulfilled By" ,"Invoice/Ref #","Product Name", "Product Quantity", "Box Value");

                $result1 = array_reduce($datalist, function($temp, $item){
                    isset($temp[$item->shipment_id])
                       ? $temp[$item->shipment_id]->box_weight += $item->box_weight
                       : $temp[$item->shipment_id] = $item;
                    return $temp;
                }, []);

                if(!empty($this->input->post('extrafields'))){
                    foreach($this->input->post('extrafields') as $addfield){
                        if($addfield == 'address_title')
                            array_push($table_columns, "Address Title");
                        elseif($addfield == 'full_address')
                            array_push($table_columns, "Pickup Address");
                        elseif($addfield == 'phone')
                            array_push($table_columns, "Pickup Contact");
                        elseif($addfield == 'pincode')
                            array_push($table_columns, "Pickup Pincode");
                        elseif($addfield == 'address_city')
                            array_push($table_columns, "Pickup City");
                        elseif($addfield == 'address_state')
                            array_push($table_columns, "Pickup State");
                        elseif($addfield == 'ofd1_on')
                            array_push($table_columns, "1st Attempt On");
                        elseif($addfield == 'ofd2_on')
                            array_push($table_columns, "2nd Attempt On");
                        elseif($addfield == 'ofd3_on')
                            array_push($table_columns, "3rd Attempt On");
                        else
                            array_push($table_columns, ucwords(str_replace('_',' ',$addfield)));
                    }
                }
                $column = '1';
                foreach($table_columns as $field)
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }
                $rowCount = '2';
                foreach ($datalist as $list) 
                { 
                    if(in_array($list->waybill_number,(array)$result1[$list->shipment_id]))
                    {
                        $initial_weight = $result1[$list->shipment_id]->box_weight;
                    }else{
                        $initial_weight = '0';
                    }
                    $col=33;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->business_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->fullname);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->parent_id);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->waybill_number);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->shipment_id);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->shipment_count);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->order_date);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->consignee_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->consignee_mobile);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->consignee_address1.",".$list->consignee_address2);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->consignee_city);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->consignee_state);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->consignee_pincode);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->payment_mode);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->cod_amount);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, ucwords($list->express_type));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, ucwords($list->shipment_type));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->product_length."x".$list->product_width."x".$list->product_height);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->product_vol_weight);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, $list->product_weight);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, $initial_weight);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, $list->billing_weight);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, $list->status_title);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, $list->last_scan_on);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $list->last_scan_location);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, $list->last_scan_remark);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, $list->ofd_attempts);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$rowCount, $list->account_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$rowCount, $list->invoice_number);                                   
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31,$rowCount, $list->product_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32,$rowCount, $list->product_quantity);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(33,$rowCount, $list->product_value);
                    
                    if(!empty($this->input->post('extrafields')))
                    {
                        $efields= $_POST['extrafields'];
                        if (in_array('shipment_length', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->product_length);
                        if (in_array('shipment_width', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->product_width);
                        if (in_array('shipment_height', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->product_height);
                        
                        if (in_array('shipment_weight', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->product_weight);
                        if (in_array('billing_weight', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->billing_weight);
                        if (in_array('zone', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->zone);
                        if (in_array('address_title', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_title);
                        if (in_array('full_address', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->full_address);
                        if (in_array('phone', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->phone);
                        if (in_array('pincode', $efields))	
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pincode);
                        if (in_array('address_city', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_city);
                        if (in_array('address_state', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_state);
                        if (in_array('picked_on', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->picked_on);
                        if (in_array('ofd1_on', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd1_on);
                        if (in_array('ofd2_on', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd2_on);
                        if (in_array('ofd3_on', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd3_on);
                        if (in_array('last_attempt_date', $efields))
                        {
                            if(!empty($list->ofd_all))
                            {
                                $ofd_all=explode("##",$list->ofd_all);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,$ofd_all[count($ofd_all)-2]);
                            }
                            else
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                        }
                        if (in_array('turn_around_time', $efields))
                        {
                            if(!empty($list->ofd_all))
                            {
                                $ofd_all=explode("##",$list->ofd_all);
                                $last_attempt = new DateTime($ofd_all[count($ofd_all)-2]);
                                $picked_on = new DateTime($list->picked_on);

                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $last_attempt->diff($picked_on)->format("%a")." day(s)");
                            }
                            else
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                        }
                        if (in_array('pod', $efields))
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pod);
                    }
                    $rowCount++;
                    $col="";
                }
                //Highlight Head Row
                $objPHPExcel->getActiveSheet()->getStyle('A1:AY1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
                $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
                //Clear the buffer, to avoid garbled 
                if (ob_get_contents())
                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0'); 
                $objWriter->save('php://output');
            }
            else
            {
                $filename = 'MpsMisReports.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Date range should not be more than 31 days.');
                $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
                //Clear the buffer, to avoid garbled 
                if (ob_get_contents())
                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0'); 
                $objWriter->save('php://output');
            }
        }
        else
        {
            if(!empty($this->input->post('file_type')) && !empty($this->input->post($_FILES['mis_file'])))
            {
                $fileupload_res['misreport'] = excel_upload('mis_file','reports_mis');
                if($fileupload_res['misreport']['title']=="Success")
                {
                    $this->reports_mis_bulk($this->input->post('file_type'),$fileupload_res['misreport']['message'],$this->input->post('extrafields'));
                }
            }
            else
            {
                $search_field=array(
                'username'=>$this->input->post('username'),
                'waybill_number'=>$this->input->post('waybill_number'),
                'shipment_id'=>$this->input->post('shipment_id'),
                'address_title'=>$this->input->post('address_title'),
                'user_status'=>$this->input->post('user_status'),
                'payment_mode'=>$this->input->post('payment_mode'),
                'express_type'=>$this->input->post('express_type'),
                'shipment_type'=>$this->input->post('shipment_type'),
                'fulfilled_account'=>$this->input->post('fulfilled_account'),
                'order_date'=>$this->input->post('order_date'),
                'from_date'=>$this->input->post('from_date'),
                'to_date'=>$this->input->post('to_date'),
                );
                $datalist = $this->exportdata_model->reports_mis('single',$search_field,'');
                /*Download file single search basis and add extra field */
                if(!empty($datalist))
                {
                    $filename = 'MisReports.xlsx';
                    $objPHPExcel = new Spreadsheet();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $table_columns = array("Username","Business Name","Full Name","WayBill Number","Order Id","Order Date", "Consignee Name", "Consignee Contact", "Consignee Address", "Consignee City", "Consignee State", "Consignee Pincode", "Payment Mode", "COD Amount" ,"Express","Order Type", "Dimensions" , "Weight","Current Status","Last Scanned At","Last Location","Last Scan Remark","Delivery Attempts","Fulfilled By" ,"Invoice/Ref #","Item Name", "Item Quantity", "Item Value");
                    if(!empty($this->input->post('extrafields'))){
                        foreach($this->input->post('extrafields') as $addfield){
                            if($addfield == 'address_title')
                                array_push($table_columns, "Address Title");
                            elseif($addfield == 'full_address')
                                array_push($table_columns, "Pickup Address");
                            elseif($addfield == 'phone')
                                array_push($table_columns, "Pickup Contact");
                            elseif($addfield == 'pincode')
                                array_push($table_columns, "Pickup Pincode");
                            elseif($addfield == 'address_city')
                                array_push($table_columns, "Pickup City");
                            elseif($addfield == 'address_state')
                                array_push($table_columns, "Pickup State");
                            elseif($addfield == 'ofd1_on')
                                array_push($table_columns, "1st Attempt On");
                            elseif($addfield == 'ofd2_on')
                                array_push($table_columns, "2nd Attempt On");
                            elseif($addfield == 'ofd3_on')
                                array_push($table_columns, "3rd Attempt On");
                            else
                                array_push($table_columns, ucwords(str_replace('_',' ',$addfield)));
                        }
                    }
                    $column = 1;
                    foreach($table_columns as $field)
                    {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                        $column++;
                    }
                    $rowCount = 2;
                    foreach ($datalist as $list) 
                    { 
                        $col=28;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->business_name);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->fullname);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->waybill_number);                                 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->shipment_id);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->order_date);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->consignee_name);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->consignee_mobile);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->consignee_address1.",".$list->consignee_address2);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->consignee_city);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->consignee_state);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->consignee_pincode);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->payment_mode);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->cod_amount);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->express_type);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->shipment_type);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->shipment_length."x".$list->shipment_width."x".$list->shipment_height);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, $list->shipment_weight);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->status_title);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->last_scan_on);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, $list->last_scan_location);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, $list->last_scan_remark);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, $list->ofd_attempts);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, $list->account_name);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, $list->invoice_number);                                   
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $list->product_name);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, $list->product_quantity);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, $list->product_value);
                        
                        if(!empty($this->input->post('extrafields')))
                        {
                            $efields= $_POST['extrafields'];
                            if (in_array('shipment_length', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_length);
                            if (in_array('shipment_width', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_width);
                            if (in_array('shipment_height', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_height);
                            
                            if (in_array('shipment_weight', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_weight);
                            if (in_array('billing_weight', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->billing_weight);
                            if (in_array('zone', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->zone);
                            if (in_array('address_title', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_title);
                            if (in_array('full_address', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->full_address);
                            if (in_array('phone', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->phone);
                            if (in_array('pincode', $efields))	
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pincode);
                            if (in_array('address_city', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_city);
                            if (in_array('address_state', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_state);
                            if (in_array('picked_on', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->picked_on);
                            if (in_array('ofd1_on', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd1_on);
                            if (in_array('ofd2_on', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd2_on);
                            if (in_array('ofd3_on', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd3_on);
                            if (in_array('last_attempt_date', $efields))
                            {
                                if(!empty($list->ofd_all))
                                {
                                    $ofd_all=explode("##",$list->ofd_all);
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,$ofd_all[count($ofd_all)-2]);
                                }
                                else
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                            }
                            if (in_array('turn_around_time', $efields))
                            {
                                if(!empty($list->ofd_all))
                                {
                                    $ofd_all=explode("##",$list->ofd_all);
                                    $last_attempt = new DateTime($ofd_all[count($ofd_all)-2]);
                                    $picked_on = new DateTime($list->picked_on);

                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $last_attempt->diff($picked_on)->format("%a")." day(s)");
                                }
                                else
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                            }
                            if (in_array('pod', $efields))
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pod);
                        }
                        $rowCount++;
                        $col="";
                    }
                    //Highlight Head Row
                    $objPHPExcel->getActiveSheet()->getStyle('A1:AT1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
                    $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
                    //Clear the buffer, to avoid garbled 
                    if (ob_get_contents())
                    ob_end_clean();
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
                    header('Content-Disposition: attachment;filename="'.$filename.'"');
                    header('Cache-Control: max-age=0'); 
                    $objWriter->save('php://output');
                }
                else
                {
                    $filename = 'MisReports.xlsx';
                    $objPHPExcel = new Spreadsheet();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Date range should not be more than 31 days.');
                    $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
                    //Clear the buffer, to avoid garbled 
                    if (ob_get_contents())
                    ob_end_clean();
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
                    header('Content-Disposition: attachment;filename="'.$filename.'"');
                    header('Cache-Control: max-age=0'); 
                    $objWriter->save('php://output');
                }
            }
        }
    }
  
    private function reports_mis_bulk($file_type,$csv_file_data,$add_extra_field=null)
	{
		$datalist = $this->exportdata_model->reports_mis($action='bulk',$csv_file_data,$file_type);
		$filename = 'MisReports.xlsx';       
		$objPHPExcel = new Spreadsheet();
		$objPHPExcel->setActiveSheetIndex(0);                       
		$table_columns = array("Username","Business Name","Full Name","WayBill Number","Order Id","Order Date", "Consignee Name", "Consignee Contact", "Consignee Address", "Consignee City", "Consignee State", "Consignee Pincode", "Payment Mode", "COD Amount" ,"Express","Order Type", "Dimensions" , "Weight","Current Status","Last Scanned At","Last Location","Last Scan Remark","Delivery Attempts","Fulfilled By" ,"Invoice/Ref #","Item Name", "Item Quantity", "Item Value");
		if(!empty($add_extra_field)){
			foreach($add_extra_field as $addfield){
                if($addfield == 'address_title')
                    array_push($table_columns, "Address Title");
                elseif($addfield == 'full_address')
                    array_push($table_columns, "Pickup Address");
                elseif($addfield == 'phone')
                    array_push($table_columns, "Pickup Contact");
                elseif($addfield == 'pincode')
                    array_push($table_columns, "Pickup Pincode");
                elseif($addfield == 'address_city')
                    array_push($table_columns, "Pickup City");
                elseif($addfield == 'address_state')
                    array_push($table_columns, "Pickup State");
                elseif($addfield == 'ofd1_on')
                    array_push($table_columns, "1st Attempt On");
                elseif($addfield == 'ofd2_on')
                    array_push($table_columns, "2nd Attempt On");
                elseif($addfield == 'ofd3_on')
                    array_push($table_columns, "3rd Attempt On");
                else
				    array_push($table_columns, ucwords(str_replace('_',' ',$addfield)));	
			}
		}
		$column = 1;
		foreach($table_columns as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		$rowCount = 2;	
		foreach($datalist as $val)
		{
			foreach ($val as $list) 
			{ 
				$col=28;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->business_name);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->fullname);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->waybill_number);                                 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->shipment_id);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->order_date);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->consignee_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->consignee_mobile);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->consignee_address1.",".$list->consignee_address2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->consignee_city);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->consignee_state);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->consignee_pincode);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->cod_amount);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->express_type);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->shipment_type);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->shipment_length."x".$list->shipment_width."x".$list->shipment_height);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, $list->shipment_weight);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->status_title);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->last_scan_on);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, $list->last_scan_location);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, $list->last_scan_remark);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, $list->ofd_attempts);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, $list->account_name);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, $list->invoice_number);                                   
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $list->product_name);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, $list->product_quantity);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, $list->product_value);
				
				if(!empty($add_extra_field)){
					$efields= $add_extra_field;
					if (in_array('shipment_length', $efields)) 
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_length);
					if (in_array('shipment_width', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_width);
					if (in_array('shipment_height', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_height);
					if (in_array('shipment_weight', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->shipment_weight);
					if (in_array('billing_weight', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->billing_weight);
					if (in_array('zone', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->zone);
                    if (in_array('address_title', $efields))
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_title);
					if (in_array('full_address', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->full_address);
					if (in_array('phone', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->phone);
					if (in_array('pincode', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pincode);
					if (in_array('address_city', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_city);
					if (in_array('address_state', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->address_state);
                    if (in_array('picked_on', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->picked_on);
					if (in_array('ofd1_on', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd1_on);
					if (in_array('ofd2_on', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd2_on);
					if (in_array('ofd3_on', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->ofd3_on);
                    if (in_array('last_attempt_date', $efields))
                    {
                        if(!empty($list->ofd_all))
                        {
                            $ofd_all=explode("##",$list->ofd_all);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,$ofd_all[count($ofd_all)-2]);
                        }
                        else
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                    }
                    if (in_array('turn_around_time', $efields))
                    {
                        if(!empty($list->ofd_all))
                        {
                            $ofd_all=explode("##",$list->ofd_all);
                            $last_attempt = new DateTime($ofd_all[count($ofd_all)-2]);
                            $picked_on = new DateTime($list->picked_on);

                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $last_attempt->diff($picked_on)->format("%a")." day(s)");
                        }
                        else
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount,'NA');
                    }
					if (in_array('pod', $efields))
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col,$rowCount, $list->pod);
				}
				$rowCount++;
				$col="";
			}
		}
		//Highlight Head Row
		$objPHPExcel->getActiveSheet()->getStyle('A1:AT1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
		//Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter->save('php://output');
	}

    //Create Excel for All AWBs in Invoices
    public function export_all_invoices_awbs()
    {
        // print_r($_GET);
        // die();
        $datalist = $this->exportdata_model->export_all_invoices_awbs($_GET);
        // create file name
        $filename = 'All Invoices -'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);															
        $table_columns = array("USERNAME", "INVOICE #", "ORDER ID", "WAYBILL NUMBER", "BILLING DATE", "GIVEN WEIGHT", "APPLIED RATE", "COD AMOUNT", "COD GAP", "BILLING WEIGHT", "FORWARD CHARGE", "RTO CHARGE", "COD CHARGE", "TOTAL CHARGES", "GST AMOUNT","TOTAL AMOUNT", "PAID AMOUNT", "ZONE", "FULFILLED ACCOUNT", "STATUS");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->invoice_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->shipment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->waybill_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, date('d-m-Y', strtotime($list->billing_date)));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->given_weight);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->applied_rate);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->cod_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->cod_gap);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->billing_weight);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->forward_charges);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, $list->rto_charges);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, $list->cod_charges);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->charges_total);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $list->gst_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $list->total_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $list->paid_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, $list->zone);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->account_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->user_status == 226 ? 'Delivered' : ($list->user_status == 225 || $list->user_status == 224 ? 'RTO' :'NA'));
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    //Create Excel for All CODs AWB wise
    public function export_all_cods_awbs()
    {
        $datalist = $this->exportdata_model->export_all_cods_awbs($_GET);
        // create file name
        $filename = 'All COD AWBs -'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);															
        $table_columns = array("USERNAME", "COD TRN", "ORDER ID", "WAYBILL NUMBER", "COD AMOUNT", "COD GAP", "COD DATE", "COD CYCLE DATE", "COD STATUS", "SHIPMENT STATUS", "FULFILLED BY","PREVIOUS COD TRN");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $cod_status = $list->cod_status == 0 ? 'Pending' : ($list->cod_status == 1 ? 'Received' : ($list->cod_status == 2 ? 'Billed' : 'Not Applicable' ));

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->cod_trn);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->shipment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->waybill_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->cod_status == '3' ? '-'.$list->cod_amount : $list->cod_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->cod_gap);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, date('d-m-Y', strtotime($list->cod_date)));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, date('d-m-Y', strtotime($list->cod_cycle_date)));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $cod_status);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->status_title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->account_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, !empty($list->previous_codtrn) && $list->previous_codtrn != $list->cod_trn ? $list->previous_codtrn : '-');
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    public function reports_ndr()
    {
        $datalist = $this->searchdata_model->report_ndr_shipments($_POST);
        /*Download file single search basis and add extra field */
        $ndr_type = $_POST['ndr_status']=='0'? 'Open' : ($_POST['ndr_status']=='1' ? 'Active' : 'Closed');
        $filename = $ndr_type.' NDRs - '.time().'.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);                       
        $table_columns = array("WayBill Number","Order Id","Order Date", "Consignee Name", "Consignee Contact", "Consignee Address", "Consignee City", "Consignee State", "Consignee Pincode", "Payment Mode", "COD Amount" ,"Express","Order Type", "Invoice/Ref #","Item Name", "Item Quantity", "Item SKU","Pickup Address","Pickup Contact","Pickup Pincode","Pickup City","Pickup State","Current Status","First NDR Reason","First NDR Date & Time","First NDR Location","Latest NDR Reason","Latest NDR Date & Time","Latest NDR Location","OFDs Counts","OFDs On","Fulfilled By");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) 
        {            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->waybill_number);                                 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->shipment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->order_date);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->consignee_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->consignee_mobile.", ".$list->consignee_phone);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->consignee_address1.",".$list->consignee_address2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->consignee_city);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->consignee_state);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->consignee_pincode);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->payment_mode=='PPD'? 'Prepaid' : $list->payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, $list->cod_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, ucwords($list->express_type));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, ucwords($list->shipment_type));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, $list->invoice_number);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, $list->address_title." - ".$list->full_address);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, $list->phone);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, $list->pincode);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, $list->address_city);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, $list->address_state);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, $list->status_title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, $list->ndr_remark);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, $list->courier_timestamp);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $list->courier_location);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, $list->latest_ndr_remark);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, $list->latest_courier_timestamp);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$rowCount, $list->latest_courier_location);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$rowCount, $list->ofd_attempts);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31,$rowCount, str_replace("##",', ',$list->ofd_all));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32,$rowCount, $list->account_name);
            
            //Getting Product Details
            $products = $this->db->query("SELECT * FROM shipments_products WHERE user_id='".$list->user_id."' AND shipment_id='".$list->shipment_id."' AND waybill_number = '".$list->waybill_number."'")->result();
            foreach ($products as $prod_data)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, $prod_data->product_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, $prod_data->product_quantity);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, $prod_data->product_sku);
                $rowCount++;
            }
            // $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:AF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        //Clear the buffer, to avoid garbled 
        if (ob_get_contents())
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    public function allpayments()
    {
        $datalist = $this->searchdata_model->search_allpayments($_POST);
        // create file name
        $filename = 'All Payments -'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);															
        $table_columns = array("Username", "Business Name", "Customer Name", "Phone", "Billing Type", "Txn Amount", "Txn Detail", "Transaction Ref. #", "Payment Id", "Transaction On");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->business_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->fullname,$list->contact);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->contact);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->billing_type);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->transaction_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->remark.", ".$list->txn_rmk);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->transaction_reference_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->razorpay_payment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, $list->transaction_on);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    public function userledger()
    {
        $datalist = $this->searchdata_model->search_userledger($_POST);
        // create file name
        $filename = $_POST['username'].' - Ledger -'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);															
        $table_columns = array("USERNAME", "Transaction On", "Reference #", "Order #", "Waybill #", "Particulars", "Amount", "Opening Balance", "Closing Balance");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->transaction_on);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->transaction_reference_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->shipment_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, $list->waybill_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, $list->remark.", ".$list->txn_rmk);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, $list->transaction_amount);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, $list->opening_balance);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $list->closing_balance);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    public function tracking_update_errordownload()
	{
        $postData=$this->input->post();
        // print_r($postData);
        // die();
	    $filename = 'TrackingUpdate_Errors - '.now().'.xlsx';       
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array('AWB Number', 'Error');
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        $i=0;
        foreach ($postData['waybill_number'] as $errors)
        {            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount,($postData['waybill_number'][$i]!='null')?$postData['waybill_number'][$i]:'');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, ($postData['remarks'][$i]!='null')?$postData['remarks'][$i]:'');
            $rowCount++;  
            $i++;      
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('eeeeee');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
	}

    public function status_logs()
    {
        if(!empty($this->input->post($_FILES['logs_file'])))
		{
			$fileupload_res['statuslogs'] = excel_upload('logs_file','status_logs');
            if($fileupload_res['statuslogs']['title']=="Success")
			{
                $datalist = $this->exportdata_model->status_logs($fileupload_res['statuslogs']['message'],$this->input->post('file_type'));
                // _print_r($datalist,1);
                $filename = 'StatusLogs.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);                       
                $table_columns = array("WayBill Number","Order Id","Status Code", "Status", "Status Description", "Location","InTargos Status","Carrier Timestamp","InTargos Timestamp");
                
                $column = 1;
                foreach($table_columns as $field)
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }
                $rowCount = 2;	
                foreach($datalist as $val)
                {
                    foreach ($val as $list)
                    {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->waybill_number);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, (isset($list->shipment_id)?$list->shipment_id:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, (isset($list->status_code)?$list->status_code:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, (isset($list->updated_status)?$list->updated_status:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, (isset($list->status_description)?$list->status_description:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, (isset($list->status_location)?$list->status_location:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, (isset($list->status_title)?$list->status_title:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, (isset($list->updated_on)?$list->updated_on:''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, (isset($list->recorded_on)?$list->recorded_on:''));
                        $rowCount++;
                    }
                }
                //Highlight Head Row
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
			}
            else
            {
                $filename = 'Error.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, strip_tags($fileupload_res['statuslogs']['message']));
            }

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
            //Clear the buffer, to avoid garbled 
            if (ob_get_contents())
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter->save('php://output');
		}
    }

    public function shipments_billing_reports()
    {
        if(!empty($this->input->post($_FILES['billing_file'])))
		{
			$fileupload_res['billinglogs'] = excel_upload('billing_file','billing_reports');
			if($fileupload_res['billinglogs']['title']=="Success")
			{
				$datalist = $this->exportdata_model->shipments_billing_reports($fileupload_res['billinglogs']['message'],$this->input->post('file_type'));
                $bill_status = $cod_status = '';
                $filename = 'BillingReport.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);                       
                $table_columns = array("WayBill Number","Username","Order Id","Ordered On","Invoice Number","Billing Date","Initial Weight","Billed Weight","Billing Status","Forward Charges","RTO Charges","COD Charges","FOV Charges","FSC Charges","Surcharge 1","Surcharge 2","Surcharge 3","Surcharge 4","NDD Charges","AWB Charges","Total Charges","GST Charges","Total Amount","COD TRN","COD Amount","COD Status","COD/Delivered Date","COD Gap","COD Eligible Date","COD Cycle Date");
                $column = 1;
                foreach($table_columns as $field)
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }
                $rowCount = 2;	
                foreach($datalist as $val)
                {
                    foreach ($val as $list)
                    {
                        if(isset($list->billing_eligibility))
                            $bill_status = ($list->billing_eligibility == '0'?"Pending":($list->billing_eligibility == 1?"Unbilled":($list->billing_eligibility == 2?"Billed":"")));
                        
                        if(isset($list->cod_status))
                            $cod_status = ($list->cod_status == '0'?"Pending":($list->cod_status == 1?"Received":($list->cod_status == 2?"Billed":($list->cod_status == 3?"Not Applicable":""))));

                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->waybill_number);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->username);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, (isset($list->shipment_id)?($list->shipment_id):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, (isset($list->added_on)?($list->added_on):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, (isset($list->invoice_number)?($list->invoice_number):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowCount, (isset($list->billing_date)?($list->billing_date):''));                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowCount, (isset($list->given_weight)?($list->given_weight):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowCount, (isset($list->billing_weight)?($list->billing_weight):''));
                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowCount, $bill_status);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowCount, (isset($list->forward_charges)?($list->forward_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowCount, (isset($list->rto_charges)?($list->rto_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowCount, (isset($list->cod_charges)?($list->cod_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowCount, (isset($list->fov_charges)?($list->fov_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowCount, (isset($list->fsc_charges)?($list->fsc_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowCount, (isset($list->surcharge_1)?($list->surcharge_1):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowCount, (isset($list->surcharge_2)?($list->surcharge_2):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowCount, (isset($list->surcharge_3)?($list->surcharge_3):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowCount, (isset($list->surcharge_4)?($list->surcharge_4):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowCount, (isset($list->ndd_charges)?($list->ndd_charges):''));
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowCount, (isset($list->awb_charges)?($list->awb_charges):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowCount, (isset($list->charges_total)?($list->charges_total):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$rowCount, (isset($list->gst_amount)?($list->gst_amount):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$rowCount, (isset($list->total_amount)?($list->total_amount):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$rowCount, (isset($list->cod_trn)?($list->cod_trn):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$rowCount, (isset($list->cod_amount)?($list->cod_amount):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$rowCount, $cod_status);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$rowCount, (isset($list->cod_date)?($list->cod_date):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$rowCount, (isset($list->cod_gap)?($list->cod_gap):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$rowCount, (isset($list->cod_eligible_date)?($list->cod_eligible_date):''));
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$rowCount, (isset($list->cod_cycle_date)?($list->cod_cycle_date):''));
                        $rowCount++;
                    }
                }
                //Highlight Head Row
                $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
			}
            else
            {
                $filename = 'Error.xlsx';
                $objPHPExcel = new Spreadsheet();
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, strip_tags($fileupload_res['statuslogs']['message']));
            }

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
            //Clear the buffer, to avoid garbled 
            if (ob_get_contents())
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter->save('php://output');
		}
    }

    // Create Excel
    public function weight_request()
    {
        $datalist = $this->searchdata_model->search_weightrequest($_POST);
        $filename = 'RequestWeight.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array("Request Id *", "Username *","AWB *","Request Wt *", "Status Wt *");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($datalist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->uwt_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, $list->waybill_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowCount, $list->request_weight);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowCount, ($list->request_status==2?"Rejected":($list->request_status==1?"Approved":"Pending")));
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        //Clear the buffer, to avoid garbled
        if (ob_get_contents())
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    // create error excel for request update weight download
    public function request_weight_update_errordownload()
	{
        $postData=$this->input->post();
        // print_r($postData);
        // die();
	    $filename = 'RequestWeightUpdate_Errors-'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array('AWB Number', 'Updated Weight','Error');
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        $i=0;
        foreach ($postData['waybill'] as $errors)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount,($postData['waybill'][$i]!='null')?$postData['waybill'][$i]:'');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount,($postData['weight'][$i]!='null')?$postData['weight'][$i]:'');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, ($postData['error'][$i]!='null')?$postData['error'][$i]:'');

            $rowCount++;
            $i++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        //Clear the buffer, to avoid garbled
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
	}

    public function user_agreement_accept()
    {
        $datalist = $this->exportdata_model->user_agreement_accept($_GET);
        // create file name
        $filename = 'User Agreement Accept -'.now().'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        if(!empty($datalist))
        {															
            $table_columns = array("USERNAME", "AGREEMENT TITLE", "ACCEPTED ON");
            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($datalist as $list)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowCount, $list->agreement_title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowCount, date('d-m-Y H:i:s', strtotime($list->accepted_on)));
                $rowCount++;
            }
            //Highlight Head Row
            $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');
        }
        else
        {
            $table_columns = array("MESSAGE");
            $column = 1;
            foreach($table_columns as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }
            $rowCount = 2;
            foreach ($_GET as $agreement_id)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, "Not accepted agreement any users");
                $rowCount++;
            }
            //Highlight Head Row
            $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
		if (ob_get_contents())
		ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
    }

    public function notification_user_download()
	{
        $usernamelist = $this->exportdata_model->notification_user_download($_GET['notification_id']);
        
        $filename = 'Notifications Users - '.$_GET['notification_id'].'.xlsx';
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $table_columns = array("USERNAME");
        $column = 1;
        foreach($table_columns as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $rowCount = 2;
        foreach ($usernamelist as $list) {

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowCount, $list->username);
            $rowCount++;
        }
        //Highlight Head Row
        $objPHPExcel->getActiveSheet()->getStyle('A1:AF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7db831');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); 
        //Clear the buffer, to avoid garbled 
        if (ob_get_contents())
        ob_end_clean(); 
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter->save('php://output');
        
	}
}
?>