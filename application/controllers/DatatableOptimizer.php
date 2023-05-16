<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatatableOptimizer extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
    }

    //To Be called every Monday 12:15AM/00:15
    public function RemoveFailedOrders()
    {
      $failedOrders = array_column($this->db->select('shipment_id')
      ->where_in('user_status','229,200',false)->where_in('system_status','108,100',false)->where('waybill_number','')
      ->where('added_on <','now() - INTERVAL 7 day',false)->get('shipments')->result_array(),'shipment_id');

      // print_r($this->db->last_query());
      // echo "<pre>";
      // print_r($failedOrders);
      if(!empty($failedOrders))
      {
        $this->db->trans_start();
          $this->db->where_in('shipment_id', $failedOrders)->delete('shipments');
          $this->db->where_in('shipment_id', $failedOrders)->delete('shipments_products');
        $this->db->trans_complete();
      }
    }

    //To Be called every Monday 12:30AM/00:30
    public function RemovePickupRequests()
    {
      $this->db->where('added_on <','now() - INTERVAL 7 day',false)->delete('shipments_pickuprequests');
      // print_r($this->db->last_query());
    }

    //To Be called 1st of every Month at 12:45AM/00:45
    public function RemoveAPILogs()
    {
      $this->db->where('added_on <','now() - INTERVAL 60 day',false)->delete('tbl_pushedapilogs');
      // print_r($this->db->last_query());
    }
    

}
?>