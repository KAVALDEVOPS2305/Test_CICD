<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('_print_r')){
    function _print_r($data,$die=NULL){
       echo "<pre>";
       print_r($data);
       if($die)
           die;
   }
}

function get_billingdate($billing_dates,$delivery_date)
{
    // echo $billing_dates."##".$delivery_date."\n";
    $billing_dates = explode(',',$billing_dates);
    sort($billing_dates);
    //Calculating next billing date
    foreach ($billing_dates as $value) {
        if ($value > $delivery_date)
            return date_format(date_create(date('Y-m-').$value),"Y-m-d");
    }
    return date('Y-m-d', strtotime(date('Y-m-').$billing_dates[0].' + 1 month'));
}

function get_codcycledate($codcycle_dates,$codeligible_date)
{
   // echo $codcycle_dates."##".$codeligible_date."\n";
   $codcycle_dates = explode(',',$codcycle_dates);
   sort($codcycle_dates);
   //Calculating next billing date
   foreach ($codcycle_dates as $value) {
       if ($value > $codeligible_date)
           return date_format(date_create(date('Y-m-').$value),"Y-m-d");
   }
   return date('Y-m-d', strtotime(date('Y-m-').$codcycle_dates[0].' + 1 month'));
}

function get_codcycledate_alt($codcycle_dates,$codeligible_date)
{
   // echo $codcycle_dates."##".$codeligible_date."\n";
   $codcycle_dates = explode(',',$codcycle_dates);
   sort($codcycle_dates);
   //Calculating next billing date
   foreach ($codcycle_dates as $value) {
       if ($value > date('d',strtotime($codeligible_date)))
           return date('Y-m-', strtotime($codeligible_date)).$value;
   }
   return date('Y-m-d', strtotime(date('Y-m-').$codcycle_dates[0].' + 1 month'));
}


function user_transaction_data($awb,$txn_amt,$txn)
{
    $ci =& get_instance();
    $order_data = $ci->billing_model->get_balance_order_details($awb);
    // print_r($order_data);
    if(!empty($order_data))
    {
        if($txn=='rto_charges')
        {
            $user_txn_data = array(
                'user_id'                   => $order_data['user_id'],
                'balance_type'              => "main",
                'action_type'               => $txn_amt>=0 ? "debit" : "credit",
                'transaction_reference_id'  => $order_data['user_id'].now().'D'.rand(999,100000),
                'shipment_id'               => $order_data['shipment_id'],
                'waybill_number'            => $order_data['waybill_number'],
                'transaction_type'          => '1017',
                'transaction_status'        => '551',
                'transaction_amount'        => $txn_amt,
                'opening_balance'           => $order_data['total_balance'],
                'closing_balance'           => $order_data['total_balance'] - $txn_amt,
                'transaction_remark'        => 'RTO Processing charge by system',
                'added_by'                  => 'system',
            );
        }
        else if($txn=='wtupdate_charges')
        {
            $user_txn_data = array(
                'user_id'                   => $order_data['user_id'],
                'balance_type'              => "main",
                'action_type'               => $txn_amt>=0 ? "debit" : "credit",
                'transaction_reference_id'  => $order_data['user_id'].now().'D'.rand(999,100000),
                'shipment_id'               => $order_data['shipment_id'],
                'waybill_number'            => $order_data['waybill_number'],
                'transaction_type'          => '1018',
                'transaction_status'        => '551',
                'transaction_amount'        => $txn_amt,
                'opening_balance'           => $order_data['total_balance'],
                'closing_balance'           => $order_data['total_balance'] - $txn_amt,
                'transaction_remark'        => 'Weight update charges',
                'added_by'                  => 'system',
            );
        }
        
        return $user_txn_data;
    }
}

//Source - https://stackoverflow.com/questions/10042485/how-to-display-currency-in-indian-numbering-format-in-php
function indian_format($num)
{
    $explrestunits = "" ;
    $num = preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des = "00";
    if(count($words)<=2){
        $num=$words[0];
        if(count($words)>=2){$des=$words[1];}
        if(strlen($des)<2){$des="$des";}else{$des=substr($des,0,2);}
    }
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
}

function indian_currency($amount)
{
    $currency = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
    return $currency->format($amount);
    // return number_format(((float)$currency->format($amount)),2);
}

/* Actual code for getting next higher value 
Source - https://stackoverflow.com/questions/31247001/php-how-to-find-next-greater-key-value-from-array
$last = null; // return value if $pricing array is empty
    foreach ($pricing as $key => $value) {
        if ($key >= $needle) {
            return $key; // found it, return quickly
        }
        $last = $key; // keep the last key thus far
    }
    return $last;
*/


?>