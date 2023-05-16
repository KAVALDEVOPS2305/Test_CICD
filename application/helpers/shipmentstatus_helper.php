<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function delhivery_status($status_code,$status)
{
    //Forward Status - Lifecycle
    if($status_code=='UD' && $status=='Manifested')
        return array('system_status'=>'103', 'vendor_status'=>'301','user_status'=>'222');
    if($status_code=='UD' && $status=='Not Picked')
        return array('system_status'=>'116', 'vendor_status'=>'302','user_status'=>'231');
    if($status_code=='UD' && $status=='In Transit')
        return array('system_status'=>'105', 'vendor_status'=>'303','user_status'=>'223');
    if($status_code=='UD' && $status=='Pending')
        return array('system_status'=>'105', 'vendor_status'=>'304','user_status'=>'223');
    if($status_code=='UD' && $status=='Dispatched')
        return array('system_status'=>'111', 'vendor_status'=>'305','user_status'=>'228');
    if($status_code=='DL' && $status=='Delivered')
        return array('system_status'=>'106', 'vendor_status'=>'306','user_status'=>'226');
    //Forward Status to RTO - Lifecycle
    if($status_code=='RT' && $status=='In Transit')
        return array('system_status'=>'115', 'vendor_status'=>'307','user_status'=>'225');
    if($status_code=='RT' && $status=='Pending')
        return array('system_status'=>'115', 'vendor_status'=>'308','user_status'=>'225');
    if($status_code=='RT' && $status=='Dispatched')
        return array('system_status'=>'115', 'vendor_status'=>'309','user_status'=>'225');
    if($status_code=='DL' && $status=='RTO')
        return array('system_status'=>'114', 'vendor_status'=>'310','user_status'=>'224');
    //Reverse Status - Lifecycle
    if($status_code=='PP' && $status=='Open')
        return array('system_status'=>'103', 'vendor_status'=>'311','user_status'=>'222');
    if($status_code=='PP' && $status=='Scheduled')
        return array('system_status'=>'116', 'vendor_status'=>'312','user_status'=>'231');
    if($status_code=='PP' && $status=='Dispatched')
        return array('system_status'=>'116', 'vendor_status'=>'313','user_status'=>'231');
    if($status_code=='PU' && $status=='In Transit')
        return array('system_status'=>'105', 'vendor_status'=>'314','user_status'=>'223');
    if($status_code=='PU' && $status=='Pending')
        return array('system_status'=>'105', 'vendor_status'=>'315','user_status'=>'223');
    if($status_code=='PU' && $status=='Dispatched')
        return array('system_status'=>'111', 'vendor_status'=>'316','user_status'=>'228');
    if($status_code=='DL' && $status=='DTO')
        return array('system_status'=>'106', 'vendor_status'=>'317','user_status'=>'226');
    if($status_code=='CN' && $status=='Canceled')
        return array('system_status'=>'109', 'vendor_status'=>'318','user_status'=>'227');
    if($status_code=='CN' && $status=='Closed')
        return array('system_status'=>'109', 'vendor_status'=>'319','user_status'=>'227');
    else
        return array('system_status'=>'0', 'vendor_status'=>'0','user_status'=>'0');
    
}

function shadowfax_status($status_code)
{
    //Forward Status - Lifecycle
    if($status_code=='new')
        return array('system_status'=>'103', 'vendor_status'=>'401','user_status'=>'222');
    if($status_code=='sent_to_rev')
        return array('system_status'=>'117', 'vendor_status'=>'402','user_status'=>'232');
    if($status_code=='assigned_for_seller_pickup')
        return array('system_status'=>'117', 'vendor_status'=>'403','user_status'=>'232');
    if($status_code=='ofp')
        return array('system_status'=>'117', 'vendor_status'=>'404','user_status'=>'232');
    if($status_code=='recd_at_rev_hub')
        return array('system_status'=>'104', 'vendor_status'=>'405','user_status'=>'223');
    if($status_code=='sent_to_fwd')
        return array('system_status'=>'105', 'vendor_status'=>'406','user_status'=>'223');
    if($status_code=='recd_at_fwd_hub')
        return array('system_status'=>'105', 'vendor_status'=>'407','user_status'=>'223');
    if($status_code=='recd_at_fwd_dc')
        return array('system_status'=>'105', 'vendor_status'=>'408','user_status'=>'223');
    if($status_code=='assigned_for_delivery')
        return array('system_status'=>'105', 'vendor_status'=>'409','user_status'=>'223');
    if($status_code=='ofd')
        return array('system_status'=>'111', 'vendor_status'=>'410','user_status'=>'228');
    if($status_code=='delivered')
        return array('system_status'=>'106', 'vendor_status'=>'411','user_status'=>'226');
    //Forward Status for Non Delivery
    if($status_code=='cid')
        return array('system_status'=>'105', 'vendor_status'=>'412','user_status'=>'223');
    if($status_code=='seller_initiated_delay')
        return array('system_status'=>'117', 'vendor_status'=>'413','user_status'=>'232');
    if($status_code=='nc')
        return array('system_status'=>'105', 'vendor_status'=>'414','user_status'=>'223');
    if($status_code=='na')
        return array('system_status'=>'105', 'vendor_status'=>'415','user_status'=>'223');
    if($status_code=='reopen_ndr')
        return array('system_status'=>'105', 'vendor_status'=>'416','user_status'=>'223');
    //Forward Status to RTO - Lifecycle
    if($status_code=='cancelled_by_customer')
        return array('system_status'=>'115', 'vendor_status'=>'417','user_status'=>'225');
    if($status_code=='rts')
        return array('system_status'=>'115', 'vendor_status'=>'418','user_status'=>'225');
    if($status_code=='rts_d')
        return array('system_status'=>'114', 'vendor_status'=>'419','user_status'=>'224');
    if($status_code=='rts_nd')
        return array('system_status'=>'105', 'vendor_status'=>'420','user_status'=>'223');
    if($status_code=='lost')
        return array('system_status'=>'105', 'vendor_status'=>'421','user_status'=>'223');
    if($status_code=='on_hold')
        return array('system_status'=>'105', 'vendor_status'=>'422','user_status'=>'223');
    //Reverse Status - Lifecycle
    if($status_code=='New')
        return array('system_status'=>'103', 'vendor_status'=>'423','user_status'=>'222');
    if($status_code=='Assigned')
        return array('system_status'=>'117', 'vendor_status'=>'424','user_status'=>'232');
    if($status_code=='Out For Pickup')
        return array('system_status'=>'117', 'vendor_status'=>'425','user_status'=>'232');
    if($status_code=='Picked')
        return array('system_status'=>'104', 'vendor_status'=>'426','user_status'=>'223');
    if($status_code=='Received')
        return array('system_status'=>'105', 'vendor_status'=>'427','user_status'=>'223');
    if($status_code=='Cancelled')
        return array('system_status'=>'109', 'vendor_status'=>'428','user_status'=>'227');
    if($status_code=='Cid')
        return array('system_status'=>'105', 'vendor_status'=>'429','user_status'=>'223');
    if($status_code=='Not Contactable')
        return array('system_status'=>'105', 'vendor_status'=>'430','user_status'=>'223');
    if($status_code=='Not Attempted')
        return array('system_status'=>'105', 'vendor_status'=>'431','user_status'=>'223');
    if($status_code=='Returned To Client')
        return array('system_status'=>'106', 'vendor_status'=>'432','user_status'=>'226');
    if($status_code=='Undelivered')
        return array('system_status'=>'105', 'vendor_status'=>'433','user_status'=>'223');
    if($status_code=='Lost')
        return array('system_status'=>'105', 'vendor_status'=>'434','user_status'=>'223');
    if($status_code=='QC Failed')
        return array('system_status'=>'105', 'vendor_status'=>'435','user_status'=>'223');
    if($status_code=='On Hold')
        return array('system_status'=>'105', 'vendor_status'=>'436','user_status'=>'223');
    else
        return array('system_status'=>'0', 'vendor_status'=>'0','user_status'=>'0');
    
}

function xpressbees_status($status_code)
{
    //Forward Status - Lifecycle
    if($status_code=='DRC')
        return array('system_status'=>'103', 'vendor_status'=>'501','user_status'=>'222');
    if($status_code=='OFP')
        return array('system_status'=>'117', 'vendor_status'=>'502','user_status'=>'232');
    if($status_code=='PND')
        return array('system_status'=>'117', 'vendor_status'=>'503','user_status'=>'232');
    if($status_code=='PKD')
        return array('system_status'=>'104', 'vendor_status'=>'504','user_status'=>'223');
    if($status_code=='IT')
        return array('system_status'=>'105', 'vendor_status'=>'505','user_status'=>'223');
    if($status_code=='RAD')
        return array('system_status'=>'105', 'vendor_status'=>'506','user_status'=>'223');
    if($status_code=='OFD')
        return array('system_status'=>'111', 'vendor_status'=>'507','user_status'=>'228');
    if($status_code=='DLVD')
        return array('system_status'=>'106', 'vendor_status'=>'508','user_status'=>'226');
    //Forward Status for Non Delivery
    if($status_code=='UD')
        return array('system_status'=>'105', 'vendor_status'=>'509','user_status'=>'223');
    if($status_code=='PUD')
        return array('system_status'=>'104', 'vendor_status'=>'517','user_status'=>'223');
    if($status_code=='STD')
        return array('system_status'=>'105', 'vendor_status'=>'518','user_status'=>'223');
    if($status_code=='STG')
        return array('system_status'=>'105', 'vendor_status'=>'519','user_status'=>'223');
    //Forward Status to RTO - Lifecycle
    if($status_code=='RTON')
        return array('system_status'=>'115', 'vendor_status'=>'510','user_status'=>'225');
    if($status_code=='RTO')
        return array('system_status'=>'115', 'vendor_status'=>'511','user_status'=>'225');
    if($status_code=='RTO-IT')
        return array('system_status'=>'115', 'vendor_status'=>'512','user_status'=>'225');
    if($status_code=='RAO')
        return array('system_status'=>'115', 'vendor_status'=>'513','user_status'=>'225');
    if($status_code=='RTO-OFD')
        return array('system_status'=>'115', 'vendor_status'=>'514','user_status'=>'225');
    if($status_code=='RTD')
        return array('system_status'=>'114', 'vendor_status'=>'515','user_status'=>'224');
    if($status_code=='RTU')
        return array('system_status'=>'115', 'vendor_status'=>'516','user_status'=>'225');
    //Reverse Status - Lifecycle
    if($status_code=='RPPickupPending')
        return array('system_status'=>'117', 'vendor_status'=>'520','user_status'=>'232');
    if($status_code=='RPOutForPickup')
        return array('system_status'=>'117', 'vendor_status'=>'522','user_status'=>'232');
    if($status_code=='RPAttemptNotPick')
        return array('system_status'=>'117', 'vendor_status'=>'524','user_status'=>'232');
    if($status_code=='RPPickDone')
        return array('system_status'=>'104', 'vendor_status'=>'521','user_status'=>'223');
    if($status_code=='RPCancel')
        return array('system_status'=>'109', 'vendor_status'=>'523','user_status'=>'227');
    if($status_code=='IT')
        return array('system_status'=>'105', 'vendor_status'=>'525','user_status'=>'223');
    if($status_code=='RAD')
        return array('system_status'=>'105', 'vendor_status'=>'526','user_status'=>'223');
    if($status_code=='OFD')
        return array('system_status'=>'111', 'vendor_status'=>'527','user_status'=>'228');
    if($status_code=='DLVD')
        return array('system_status'=>'106', 'vendor_status'=>'528','user_status'=>'226');
    if($status_code=='UD')
        return array('system_status'=>'105', 'vendor_status'=>'529','user_status'=>'223');
    else
        return array('system_status'=>'0', 'vendor_status'=>'0','user_status'=>'0');
    
}

function udaan_status($status_code,$status)
{
    // echo $status_code."$$".$status;
    //Forward Status - Lifecycle
    if($status_code=='FW' && $status=='PICKUP_CREATED')
        return array('system_status'=>'103', 'vendor_status'=>'601','user_status'=>'222');
    if($status_code=='FW' && $status=='OUT_FOR_PICKUP')
        return array('system_status'=>'117', 'vendor_status'=>'602','user_status'=>'232');
    if($status_code=='FW' && $status=='PICKED_UP')
        return array('system_status'=>'104', 'vendor_status'=>'603','user_status'=>'230');
    if($status_code=='FW' && $status=='PICKUP_FAILED')
        return array('system_status'=>'116', 'vendor_status'=>'604','user_status'=>'231');
    if($status_code=='FW' && $status=='PICKED_NOT_VERIFIED')
        return array('system_status'=>'116', 'vendor_status'=>'605','user_status'=>'231');
    if($status_code=='FW' && $status=='HUB_INSCAN')
        return array('system_status'=>'105', 'vendor_status'=>'606','user_status'=>'223');
    if($status_code=='FW' && $status=='HUB_OUTSCAN')
        return array('system_status'=>'105', 'vendor_status'=>'607','user_status'=>'223');
    if($status_code=='FW' && $status=='RAD')
        return array('system_status'=>'105', 'vendor_status'=>'608','user_status'=>'223');
    if($status_code=='FW' && $status=='OUT_FOR_DELIVERY')
        return array('system_status'=>'111', 'vendor_status'=>'609','user_status'=>'228');
    if($status_code=='FW' && $status=='DELIVERY_ATTEMPTED')
        return array('system_status'=>'111', 'vendor_status'=>'610','user_status'=>'228');
    if($status_code=='FW' && $status=='DELIVERED')
        return array('system_status'=>'106', 'vendor_status'=>'611','user_status'=>'226');
    if($status_code=='FW' && $status=='CANCELLED')
        return array('system_status'=>'109', 'vendor_status'=>'612','user_status'=>'227');
    //Forward Status to RTO - Lifecycle
    if($status_code=='RT' && $status=='RTO_MARKED')
        return array('system_status'=>'115', 'vendor_status'=>'613','user_status'=>'225');
    if($status_code=='RT' && $status=='HUB_INSCAN')
        return array('system_status'=>'115', 'vendor_status'=>'614','user_status'=>'225');
    if($status_code=='RT' && $status=='HUB_OUTSCAN')
        return array('system_status'=>'115', 'vendor_status'=>'615','user_status'=>'225');
    if($status_code=='RT' && $status=='RAD')
        return array('system_status'=>'115', 'vendor_status'=>'616','user_status'=>'225');
    if($status_code=='RT' && $status=='OUT_FOR_DELIVERY')
        return array('system_status'=>'115', 'vendor_status'=>'617','user_status'=>'225');
    if($status_code=='RT' && $status=='DELIVERED')
        return array('system_status'=>'114', 'vendor_status'=>'618','user_status'=>'224');
    else
        return array('system_status'=>'0', 'vendor_status'=>'0','user_status'=>'0');
}

function amazon_status($status_code,$rtoawb = '')
{
    //Forward Status - Lifecycle
    if($status_code=='ReadyForReceive')
        return array('system_status'=>'117', 'vendor_status'=>'801','user_status'=>'232');
    if($status_code=='PickupDone')
        return array('system_status'=>'104', 'vendor_status'=>'802','user_status'=>'230');
    if($status_code=='ArrivedAtCarrierFacility' && empty($rtoawb))
        return array('system_status'=>'105', 'vendor_status'=>'803','user_status'=>'223');
    if($status_code=='Departed' && empty($rtoawb))
        return array('system_status'=>'105', 'vendor_status'=>'804','user_status'=>'223');
    if($status_code=='OutForDelivery')
        return array('system_status'=>'111', 'vendor_status'=>'805','user_status'=>'228');
    if($status_code=='Delivered' && empty($rtoawb))
        return array('system_status'=>'106', 'vendor_status'=>'806','user_status'=>'226');
    if($status_code=='Rejected')
        return array('system_status'=>'115', 'vendor_status'=>'807','user_status'=>'225');
    if($status_code=='Undeliverable')
        return array('system_status'=>'115', 'vendor_status'=>'808','user_status'=>'225');
    if($status_code=='DeliveryAttempted')
        return array('system_status'=>'105', 'vendor_status'=>'809','user_status'=>'223');
    //Reverse Status - Lifecycle
    if($status_code=='ArrivedAtCarrierFacility' && !empty($rtoawb))
        return array('system_status'=>'115', 'vendor_status'=>'803','user_status'=>'225');
    if($status_code=='Departed' && !empty($rtoawb))
        return array('system_status'=>'115', 'vendor_status'=>'804','user_status'=>'225');
    if($status_code=='Delivered' && !empty($rtoawb))
        return array('system_status'=>'114', 'vendor_status'=>'806','user_status'=>'224');
    
    if($status_code=='PickupCancelled')
        return array('system_status'=>'109', 'vendor_status'=>'810','user_status'=>'227');
    if($status_code=='Destroyed')
        return array('system_status'=>'0', 'vendor_status'=>'811','user_status'=>'0');
    if($status_code=='Lost')
        return array('system_status'=>'0', 'vendor_status'=>'812','user_status'=>'0');
    else
        return array('system_status'=>'0', 'vendor_status'=>'0','user_status'=>'0');
}
?>