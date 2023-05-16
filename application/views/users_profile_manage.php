<?php
$page_id = 'users_manage';
?>
<!DOCTYPE html>
<!--[if IE 9]> <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
    </head>
    <body>
        <!-- Page Wrapper -->
        <div id="page-wrapper">
            <!-- Preloader -->
                <?php require_once('preloader.php'); ?>
            <!-- END Preloader -->

            <!-- Page Container -->
            <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">

                <!-- Main Sidebar -->
                 <?php require_once('sidebar-main.php'); ?>
                <!-- END Main Sidebar -->

                <!-- Main Container -->
                <div id="main-container">
                    <!-- Header -->
                    <?php require_once('topbar.php'); ?>
                    <!-- END Header -->

                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Validation Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-cubes"></i>User Profile<br><small>Edit Users Profile</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="javascript:void(0)">Manage Users</a></li>
                        </ul>
                        <!-- END Validation Header -->
                         <!-- END Header -->
                        <?php
                            $user_id = base64_decode($_GET['uid']);
                            $result_user=$this->db->where('users.user_id =', $user_id)
                                ->join('users_kyc UK','UK.user_id=users.user_id','LEFT')
                                ->limit(1)->get('users');
                            $user_data = $result_user->row_array();

                            $result_slab=$this->db->select('US.*,WS.slab_title,WS.base_weight')->join('master_weightslab WS', 'US.weightslab_id=WS.weightslab_id')->where('user_id =', $user_id)->get('users_weightslabs US');
                            $user_slab = $result_slab->result();

                            $agreement=$this->db->select('UA.accepted_on,TA.agreement_title,TA.agreement,TA.added_on,TA.agreement')->join('users_agreements UA', 'UA.agreement_id=TA.agreement_id')->where('user_id =', $user_id)->order_by('TA.agreement_id', 'DESC')->get('tbl_agreements TA');
                            $user_agreement = $agreement->result();
                        ?>
                        <!-- User Profile -->
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- Customer Info Block -->
                                <div class="block">
                                    <!-- Customer Info Title -->
                                    <div class="block-title">
                                        <h2><i class="gi gi-nameplate"></i> <strong>User</strong> Info</h2>
                                    </div>
                                    <!-- END Customer Info Title -->

                                    <!-- Customer Info -->
                                    <div class="block-section text-center">
                                        <a href="javascript:void(0)">
                                            <img src="https://ui-avatars.com/api/?name=<?php echo $user_data['business_name']?>&background=random&color=fff&bold=true&size=100" alt="InTargos" class="img-circle">
                                        </a>
                                        <h3>
                                            <strong><?php echo $user_data['business_name']?></strong><br>
                                            <small><?php echo $user_data['business_type']?></small>
                                        </h3>
                                    </div>
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            <tr>
                                                <td class="text-right" style="width: 50%;"><strong>Registered Name</strong></td>
                                                <td><?php echo $user_data['fullname']?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Registered Email</strong></td>
                                                <td><?php echo $user_data['email_id']?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Billing</strong></td>
                                                <td><?php echo ucwords($user_data['billing_type'])?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>KYC Status</strong></td>
                                                <td>
                                                    <?php
                                                        echo ($user_data['kyc_status']=='0' ?
                                                        '<span class="label label-warning"> Pending</span>' :
                                                        ($user_data['kyc_status']=='1' ?
                                                        '<span class="label label-success"> Approved</span>':
                                                        '<span class="label label-danger"> Rejected</span>'));
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Account Status</strong></td>
                                                <td>
                                                  <?php  if($user_data['account_status']==1) { ?>

                                                     <a href="javascript:void(0);" id="btnstatus" onclick="changestatus('<?php echo $user_data['user_id'] ?>','<?php echo $user_data['account_status'] ?>')" class="label label-success">Active</a>
                                                  <?php  } else if($user_data['account_status']==2){ ?>

                                                     <a href="javascript:void(0);" id="btnstatus" onclick="changestatus('<?php echo $user_data['user_id'] ?>','<?php echo $user_data['account_status'] ?>')" class="label label-danger">Inactive</a>
                                                   <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Registration On</strong></td>
                                                <td><?php echo date('d-M-Y H:i:s A', strtotime($user_data['added_on'])) ?></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Customer Info -->
                                </div>
                                <!-- END Customer Info Block -->
                            </div>
                            <div class="col-lg-8">
                                <!-- Working Tabs Block -->
                                <div class="block full">
                                    <!-- Working Tabs Title -->
                                    <div class="block-title">
                                        <h2><strong>User</strong> Details</h2>
                                        <div class="col-md-4 text-center" style="float:right;padding: 3px;width: 14%;">
                                            <div class="btn-group text-center">
                                                <a href="users_ratechart?uid=<?php echo base64_encode($user_data['user_id']) ?>" target="_blank" class="btn btn-success" data-toggle="tooltip" title="Manage Ratechart"><i class="fa fa-money"></i></a>
                                                <a href="users_courierpriority?uid=<?php echo base64_encode($user_data['user_id']) ?>" target="_blank" class="btn btn-alt btn-info" data-toggle="tooltip" title="Courier Priority"><i class="gi gi-cargo"></i></a>

                                                <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-alt btn-danger dropdown-toggle"><span class="caret"></span></a>
                                                <ul class="dropdown-menu text-center" style="min-width: 113px; margin-left:-21%">
                                                    <li><a href="users_weightslab?uid=<?php echo base64_encode($user_data['user_id']) ?>" target="_blank">Weight Slabs</a></li>
                                                <?php if($user_data['billing_type']=='postpaid'){ ?>

                                                    <li><a href="javascript:void(0);" onclick="changebilling_type('<?= $user_data['user_id'] ?>','prepaid')"> Convert to Prepaid</a></li>

                                                    <li><a href="javascript:void(0);" onclick="rectify_balance('<?= $user_data['user_id'] ?>')"> Rectify Balance</a></li>
                                                <?php }else if($user_data['billing_type']=='prepaid'){ ?>
                                                    <li><a href="javascript:void(0);" onclick="changebilling_type('<?= $user_data['user_id'] ?>','postpaid')"> Covert to Postpaid</a></li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Working Tabs Title -->
                                    <!-- Working Tabs Content -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Default Tabs -->
                                            <ul class="nav nav-tabs push" data-toggle="tabs">
                                                <li class="active"><a href="#tabs-charges">Charges Details</a></li>
                                                <li><a href="#tabs-weight">Weight Slab</a></li>
                                                <li><a href="#tabs-billing">Billing Details</Details></a></li>
                                                <li><a href="#tabs-account">Bank Account Details</Details></a></li>
                                                <li><a href="#tabs-kyc">KYC Details</Details></a></li>
                                                <li><a href="#tabs-agreement">Agreement Details</Details></a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active form-horizontal form-bordered" id="tabs-charges">
                                                    <!-- Step Info -->
                                                    <form id="tabcharges">
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="codadjust">Adjust COD<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="codadjust" id="codadjust" class="form-control" style="width: 100%;" data-placeholder="Select State..." disabled>
                                                                        <option id="original_val_codadjust" hidden><?php echo $user_data['codadjust']?></option>
                                                                        <option  value="">--select--</option>
                                                                        <option  value="yes">Yes</option>
                                                                        <option  value="no">No</option>
                                                                    </select> 
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('codadjust')" id="span_codadjust"  class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label  for="liability_amount">Liability Amount<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="liability_amount" name="liability_amount" class="form-control" value="<?= $user_data['liability_amount']?>" placeholder="Enter user's Liability Amount" disabled>
                                                                    <input type="hidden" id="original_val_liability_amount" name="liability_amount" class="form-control" value="<?= $user_data['liability_amount']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button"  onclick="changVal('liability_amount')" id="span_liability_amount"  class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="ndd_charges">NDD Charges<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="ndd_charges" name="ndd_charges" class="form-control" value="<?= $user_data['ndd_charges']?>" placeholder="Enter User's NDD Charges..." disabled>
                                                                    <input type="hidden" id="original_val_ndd_charges" value="<?= $user_data['ndd_charges']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('ndd_charges')" id="span_ndd_charges" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label  for="insurance_charges">Insurance Charges<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="insurance_charges" name="insurance_charges" class="form-control" value="<?= $user_data['insurance_charges']?>" placeholder="Enter user's Insurance Charges in %" disabled >
                                                                    <input type="hidden" id="original_val_insurance_charges" value="<?= $user_data['insurance_charges']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('insurance_charges')" id="span_insurance_charges" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="capping_amount">Capping Amount<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="capping_amount" name="capping_amount" class="form-control" value="<?php echo $user_data['capping_amount']?>" placeholder="Enter User's Capping Amount..." disabled>
                                                                    <input type="hidden" id="original_val_capping_amount" name="capping_amount" class="form-control" value="<?php echo $user_data['capping_amount']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('capping_amount')" id="span_capping_amount" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="restrict_amount">Restriction Amount<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="restrict_amount" name="restrict_amount" class="form-control" value="<?php echo $user_data['restrict_amount']?>" placeholder="Enter user's Restriction Amount" disabled>
                                                                    <input type="hidden" id="original_val_restrict_amount" name="restrict_amount" class="form-control" value="<?php echo $user_data['restrict_amount']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('restrict_amount')" id="span_restrict_amount" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>  
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label  for="credit_period">Credit Period<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="credit_period" name="credit_period" class="form-control" value="<?php echo $user_data['credit_period']?>" placeholder="Enter Credit Period in days..." disabled>
                                                                    <input type="hidden" id="original_val_credit_period" name="credit_period" class="form-control" value="<?php echo $user_data['credit_period']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('credit_period')" id="span_credit_period" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label  for="token_key">API Token<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="password" id="token_key" name="token_key" class="form-control" value="<?php echo $user_data['token_key']?>" disabled>
                                                                    <span class="input-group-addon" onclick="showhide()"><i class="fa fa-eye"></i></span>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" id="refresh_key" class="btn btn-default"><i class="fa fa-refresh"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div> 

                                                <div class="tab-pane" id="tabs-weight">
                                                    <table style="width: 100%;" class="table table-vcenter table-striped table-condensed table-bordered" >
                                                        <th style="text-align: center;">Express Mode</th>
                                                        <th style="text-align: center;">Weight Slabs</th>
                                                        <th style="text-align: center;">Base Weight</th>
                                                        
                                                        <tbody>
                                                        <?php
                                                        foreach($user_slab as $row)
                                                        {
                                                        ?>
                                                        <tr>
                                                        <td style="text-align: center;"><?php echo $row->express; ?></td>
                                                        <td style="text-align: center;"><?php echo $row->slab_title; ?></td>
                                                        <td style="text-align: center;"><?php echo $row->base_weight; ?>Kg.</td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>    
                                                    <!-- END Info Content -->
                                                </div>

                                                <div class="tab-pane form-horizontal form-bordered" id="tabs-billing">
                                                    <form id="tabsbilling">
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="billing_address">Billing Address<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="billing_address" name="billing_address" class="form-control" value="<?= $user_data['billing_address']?>" placeholder="Enter User's Billing Address..." disabled>
                                                                    <input type="hidden" id="original_val_billing_address" name="billing_address" class="form-control" value="<?= $user_data['billing_address']?>" placeholder="Enter User's Billing Address..." disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('billing_address')" id="span_billing_address" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="billing_state">Billing State<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="billing_state" id="billing_state" class="form-control" style="width: 100%;"  data-placeholder="Select State..." disabled>
                                                                        <option id="original_val_billing_state" hidden ><?= $user_data['billing_state']?></option>
                                                                        <?php     
                                                                        $result=$this->db->order_by('state_name', 'ASC')->get('tbl_state'); ?>

                                                                        <?php foreach($result->result() as $row)
                                                                        {
                                                                        ?>
                                                                        <option value="<?= $row->state_name; ?>"><?= $row->state_name; ?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    <span class="input-group-btn">
                                                                            <button type="button" onclick="changVal('billing_state')" id="span_billing_state"  class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>                                                  
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label  for="codgap">COD Gap<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="codgap" name="codgap" class="form-control" placeholder="D + n" value="<?php echo $user_data['codgap']?>" disabled>
                                                                    <input type="hidden" id="original_val_codgap" name="codgap" class="form-control" placeholder="D + n" value="<?php echo $user_data['codgap']?>" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('codgap')" id="span_codgap" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                                <span class="help-block" id="codgap_label"></span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="billing_cycle_id">Billing Cycle<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="billing_cycle_id" id="billing_cycle_id" class=" form-control" style="width: 100%;" data-placeholder="Select Billing Cycle..." onchange="getbillingdate(this.value)" disabled>
                                                                        <?php $result=$this->db->where('billing_cycle_status =','1')->where('billing_cycle_id',$user_data['billing_cycle_id'])->order_by('billing_cycle_title', 'ASC')->get('master_billing_cycle')->row_array();?>
                                                                        <option id="original_val_billing_cycle_id" hidden><?php echo $result['billing_cycle_title'] ?></option>
                                                                        <?php     
                                                                        $result_title=$this->db->where('billing_cycle_status =','1')->order_by('billing_cycle_title', 'ASC')->get('master_billing_cycle');
                                                                        // print_r($this->db->last_query());
                                                                        foreach($result_title->result() as $row)
                                                                        {
                                                                        ?>
                                                                        <option value="<?php echo $row->billing_cycle_id; ?>"><?php echo $row->billing_cycle_title; ?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('billing_cycle_id')" id="span_billing_cycle_id"  class="btn btn-primary" ><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                                <span class="help-block" id="billing_cycle_dates">Dates:</span> 
                                                                <span id="original_cycle_dates" style="display:none;">Dates: <?php echo $result['billing_cycle_dates'] ?></span> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="cod_cycle_id">COD Cycle<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="cod_cycle_id" id="cod_cycle_id" class="form-control" style="width: 100%;" data-placeholder="Select COD Cycle..." onchange="getcoddate(this.value)" disabled>
                                                                        <?php $result=$this->db->where('cod_cycle_status =','1')->where('cod_cycle_id',$user_data['cod_cycle_id'])->order_by('cod_cycle_title', 'ASC')->get('master_cod_cycle')->row_array();?>
                                                                        <option id="original_val_cod_cycle_id" hidden><?php echo $result['cod_cycle_title'] ?></option>
                                                                        <?php     
                                                                        $result_cod=$this->db->where('cod_cycle_status =','1')->order_by('cod_cycle_title', 'ASC')->get('master_cod_cycle');
                                                                        // print_r($this->db->last_query());
                                                                        foreach($result_cod->result() as $row)
                                                                        {
                                                                    ?>
                                                                        <option value="<?php echo $row->cod_cycle_id; ?>"><?php echo $row->cod_cycle_title; ?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('cod_cycle_id')" id="span_cod_cycle_id"  class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div> 
                                                                <span class="help-block" id="cod_cycle_dates">Dates:</span> 
                                                                <span id="original_cod_cycle_dates" style="display:none;">Dates: <?php echo $result['cod_cycle_dates'] ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="cod_fees_amt">COD Fees Amount<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="cod_fees_amt" name="cod_fees_amt" class="form-control" value="<?= $user_data['cod_fees_amt']?>" placeholder="Enter Minimum COD Fees"disabled>
                                                                    <input type="hidden" id="original_val_cod_fees_amt" name="cod_fees_amt" class="form-control" value="<?= $user_data['cod_fees_amt']?>" placeholder="Enter Minimum COD Fees"disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('cod_fees_amt')" id="span_cod_fees_amt" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="cod_fees_per">COD Fees %age<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="cod_fees_per" name="cod_fees_per" class="form-control" value="<?= $user_data['cod_fees_per']?>" placeholder="Enter COD Fees %" disabled>
                                                                    <input type="hidden" id="original_val_cod_fees_per" name="cod_fees_per" class="form-control" value="<?= $user_data['cod_fees_per']?>" placeholder="Enter COD Fees %" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('cod_fees_per')" id="span_cod_fees_per" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="awb_charges">AWB Charges</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="awb_charges" name="awb_charges" class="form-control" value="<?= $user_data['awb_charges']?>" placeholder="Enter AWB charges in amount" value="0" disabled>
                                                                    <input type="hidden" id="original_val_awb_charges" name="awb_charges" class="form-control" value="<?= $user_data['awb_charges']?>" placeholder="Enter AWB charges in amount" value="0" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('awb_charges')" id="span_awb_charges" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label  for="fsc_rate">FSC %</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="fsc_rate" name="fsc_rate" class="form-control" value="<?= $user_data['fsc_rate']?>" placeholder="Enter fuel surcharge %" value="0" disabled>
                                                                    <input type="hidden" id="original_val_fsc_rate" name="fsc_rate" class="form-control" value="<?= $user_data['fsc_rate']?>" placeholder="Enter fuel surcharge %" value="0" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('fsc_rate')" id="span_fsc_rate" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label  for="surcharge_3">Surcharge 3</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="surcharge_3" name="surcharge_3" class="form-control" value="<?= $user_data['surcharge_3']?>" placeholder="Enter Surcharge amount" value="0" disabled>
                                                                    <input type="hidden" id="original_val_surcharge_3" name="surcharge_3" class="form-control" value="<?= $user_data['surcharge_3']?>" placeholder="Enter Surcharge amount" value="0" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('surcharge_3')" id="span_surcharge_3" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">
                                                                <label  for="surcharge_4">Surcharge 4</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="surcharge_4" name="surcharge_4" class="form-control" value="<?= $user_data['surcharge_4']?>" placeholder="Enter Surcharge %" value="0" disabled>
                                                                    <input type="hidden" id="original_val_surcharge_4" name="surcharge_4" class="form-control" value="<?= $user_data['surcharge_4']?>" placeholder="Enter Surcharge %" value="0" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('surcharge_4')" id="span_surcharge_4" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane form-horizontal form-bordered" id="tabs-account">
                                                    <form id="tabsaccount">
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="beneficiary_name">Beneficiary Name<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="beneficiary_name" name="beneficiary_name" class="form-control" value="<?= $user_data['beneficiary_name']?>" placeholder="Enter User's Beneficiary Name..." disabled>
                                                                    <input type="hidden" id="original_val_beneficiary_name" name="beneficiary_name" class="form-control" value="<?= $user_data['beneficiary_name']?>" placeholder="Enter User's Beneficiary Name..." disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('beneficiary_name')" id="span_beneficiary_name" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-6">
                                                                <label for="account_number">Account Number<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="account_number" name="account_number" class="form-control" value="<?= $user_data['account_number']?>" placeholder="Enter user's Account Number" disabled>
                                                                    <input type="hidden" id="original_val_account_number" name="account_number" class="form-control" value="<?= $user_data['account_number']?>" placeholder="Enter user's Account Number" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('account_number')" id="span_account_number" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="ifsc_code">IFSC Code<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" value="<?= $user_data['ifsc_code']?>" placeholder="Enter User's IFSC Code..." minlength="11" maxlength="11" onblur="ifsclookup(this.value);" disabled>
                                                                    <input type="hidden" id="original_val_ifsc_code" name="ifsc_code" class="form-control" value="<?= $user_data['ifsc_code']?>" placeholder="Enter User's IFSC Code..." disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('ifsc_code')" id="span_ifsc_code" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="bank_branch_name">Bank Name/Branch Name<span class="text-danger">*</span></label>
                                                                <input type="text" id="bank_branch_name" name="bank_branch_name" class="form-control" value="<?= $user_data['bank_name'] .' / '. $user_data['branch_name']?>" placeholder="Enter user's Bank/Branch Name" readonly required>
                                                                <input type="hidden" id="bank_name"  name="bank_name" class="form-control " required >
                                                                <input type="hidden" id="branch_name" name="branch_name" class="form-control" required >
                                                            </div>
                                                        </div>
                                                        <div id="loader" class="text-center" style="margin-top: 10px; display:none;">
                                                            <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data... 
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane" id="tabs-kyc">
                                                    <table style="width: 100%;" class="table table-vcenter table-striped table-condensed table-bordered" > 
                                                        <th style="text-align: center;">Document Type</th>
                                                        <th style="text-align: center;">Document Number</Title></th>
                                                        <th style="text-align: center;">Status</th>                                                           
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center;">Adhaar</td>
                                                                <td style="text-align: center;"><?php echo $user_data['adhaar_number'] ?></td>
                                                                <td style="text-align: center;">
                                                                    <?php
                                                                        echo ($user_data['adhaar_status']=='0' ?
                                                                        '<span class="label label-warning"><i class="fa fa-minus"></i> Pending</span>' :
                                                                        ($user_data['adhaar_status']=='1' ?
                                                                        '<span class="label label-success"><i class="fa fa-check"></i> Approved</span>':
                                                                        '<span class="label label-danger"><i class="fa fa-times"></i> Unverified</span>'));
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;">GST</td>
                                                                <td style="text-align: center;"><?php echo $user_data['kyc_doc_number'] ?></td>
                                                                <td style="text-align: center;">
                                                                <?php
                                                                    echo ($user_data['kyc_gst_reg']=='no' ?
                                                                    '<span class="label label-warning"><i class="fa fa-minus"></i> Pending</span>' :
                                                                    ($user_data['kyc_gst_reg']=='yes' ?
                                                                    '<span class="label label-success"><i class="fa fa-check"></i> Approved</span>':
                                                                    '<span class="label label-danger"><i class="fa fa-times"></i> Unverified</span>'));
                                                                ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <form  id="tabskyc">
                                                        <div class="form-group">
                                                            <div class="col-md-2" style="text-align: center;">
                                                                <label for="kyc_pan">TAN Number<span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-6" style="align: center;">
                                                                <div class="input-group">
                                                                    <input type="text" id="tan_number" name="tan_number" class="form-control" value="<?= $user_data['tan_number']?>" placeholder="Enter TAN Number..." minlength="10" maxlength="10" disabled>
                                                                    <input type="hidden" id="original_val_tan_number" name="tan_number" class="form-control" value="<?= $user_data['tan_number']?>" placeholder="Enter TAN Number..." minlength="10" maxlength="10" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="changVal('tan_number')" id="span_tan_number" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane table-responsive" id="tabs-agreement">
                                                    <table style="width: 100%;" class="table table-vcenter table-striped table-condensed table-bordered" >
                                                        <th style="text-align: center;">Agreement Title</th>
                                                        <th style="text-align: center;">Accepted On</th>
                                                        <tbody>
                                                            <?php
                                                            foreach($user_agreement as $row)
                                                            {
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><a href="<?php echo get_agreement_pdf($row->agreement) ?>"  target="_blank"><?php echo $row->agreement_title; ?></a></td>
                                                                <td style="text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($row->accepted_on)) ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- END Default Tabs -->
                                        </div>
                                    </div>
                                    <!-- END Working Tabs Content -->
                                </div>
                                <!-- END Working Tabs Block -->
                            </div>
                        </div>
                        <!-- END Profile -->
                    </div>
                    <!-- END Page Content -->
                    <!-- Footer -->
                    <?php require_once('footer.php'); ?>
                    <!-- END Footer -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

        <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>
        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
        <script src="<?= base_url();?>assets/js/vendor/jquery.min.js"></script>
        <script src="<?= base_url();?>assets/js/vendor/bootstrap.min.js"></script>
        <script src="<?= base_url();?>assets/js/plugins.js"></script>
        <script src="<?= base_url();?>assets/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?= base_url();?>assets/js/pages/formsValidation.js"></script>
        <script src="<?= base_url();?>assets/js/pages/tablesDatatables.js"></script>
        <script src="<?= base_url();?>assets/js/pages/uiProgress.js"></script>
        <script src="<?= base_url();?>assets/js/pages/formsWizard.js"></script>
        <script src="<?= base_url();?>assets/js/autocomplete.js"></script>
        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        <script>
            $(document).ready(function(){
                FormsWizard.init();
                UiProgress.init();
                TablesDatatables.init();
                $("#billing_cycle_id").val('<?php echo $user_data['billing_cycle_id']?>').trigger("change");
                $("#cod_cycle_id").val('<?php echo $user_data['cod_cycle_id']?>').trigger("change");
                
            });

            function changebilling_type(row_id, new_status)
            {
                update_status(row_id, new_status,"<?= base_url();?>actionupdate/convert_billingtype");
            }

            function rectify_balance(row_id)
            {
                update_status(row_id, "", "<?= base_url();?>billing/reset_postpaidbalance")
            }

            $('#refresh_key').click(function()
            {
                var userid = '<?php echo $user_id ?>';
                $.ajax({
                    url: '<?= base_url();?>Actiongetdata/generate_apikey',
                    method:"POST",
                    data:{"userid":userid},
                    dataType : "json",
                    success: function(response)
                    { 
                        $("#token_key").val(response.token_key);
                        if(response.error)
                        {                          
                            $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                            type: 'danger',
                            delay: 3000,
                            allow_dismiss: true
                            });
                            //return false
                        }
                        else
                        {
                            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                            type: 'success',
                            delay: 2500,
                            allow_dismiss: true
                            });
                            setTimeout(function(){location.reload();}, 3000);
                        }
                    }
                });
            });

            function ifsclookup(ifsc)
            {
                //alert(ifsc);
                $.ajax({
                    url :  "https://ifsc.razorpay.com/"+ifsc,
                    datatype : "json",
                    beforeSend: function()
                    {
                        $('#loader').show();
                    },
                    complete: function()
                    {
                        $('#loader').hide();
                    },
                    success:function(res)
                    {
                        var bankname = res.BANK;
                        var barcnh_name = res.BRANCH;

                        $("#bank_branch_name").val(bankname+" / "+barcnh_name );
                        $("#bank_name").val(bankname);
                        $("#branch_name").val(barcnh_name);
                        // alert(${res.BANK});
                    },
                    error: function (res)
                    {
                        $("#bank_branch_name").val("");
                        $("#bank_name").val("");
                        $("#branch_name").val("");
                        $.bootstrapGrowl('<h4><i class="fa fa-times"></i> IFSC Error</h4> <p>'+res.responseText+'</p>', {
                            type: 'danger',
                            delay: 2500,
                            allow_dismiss: true
                        });
                    }
                });
            }

            function showhide() 
            {
                var token_keys = document.getElementById("token_key");
                if (token_keys.type === "password") {
                    token_keys.type = "text";
                } else {
                    token_keys.type = "password";
                }
            }

            function getbillingdate(rowid)
            {
                // alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/get_billingdates",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        // alert(r[0]);
                        $("#billing_cycle_dates").html('Dates: '+r[0].trim().replace(/,/g,", "));
                    }
                });
            }

            function getcoddate(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/get_coddates",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        $("#cod_cycle_dates").html('Dates: '+r[0].trim().replace(/,/g,", "));
                    }
                });
            }

            function changVal(id)
            {
                // alert(id);
                $('#span_'+id).hide();
                $("#"+id).attr('disabled',false);
                $('#span_'+id).after("<span class='input-group-btn'><button type='button'  id='"+id+"' onclick='UpdateValue(id)'  class='btn btn-success successbtn"+id+"'><i class='fa fa-check'></i></button></span><span class='input-group-btn'><button type='button' id='"+id+"'  class='btn btn-danger remove_timesbtn"+id+"' onclick='nochangValue(id)'><i class='fa fa-times'></i></button></span>");  
            }

            function nochangValue(id)
            {
                $('#span_'+id).show();
                $("#"+id).val($("#original_val_"+id).val());
                $("#billing_cycle_dates").text($("#original_cycle_dates").text());
                $("#cod_cycle_dates").text($("#original_cod_cycle_dates").text());
                $("#"+id).attr('disabled',true);
                $("#"+id+"-error").hide();
                $('.has-error').removeClass('has-error');
                $(".successbtn"+id).hide();
                $(".remove_timesbtn"+id).hide();
            }

            function UpdateValue(columname)
            {
                var userid = '<?php echo $user_id ?>';
                var columvalue = $('#'+columname).val();

                if (columname == 'ifsc_code')
                {
                    var bank_name   = $('#bank_name').val();
                    var branch_name = $('#branch_name').val();
                    var postData    = columname+'='+columvalue+'&userid'+'='+userid+'&bank_name'+'='+bank_name+'&branch_name'+'='+branch_name
                }
                else
                    var postData    = columname+'='+columvalue+'&userid'+'='+userid
                
                if($('#tabcharges').valid() && $('#tabsbilling').valid() && $('#tabsaccount').valid() && $('#tabskyc').valid()){
                    $.ajax({
                        url:"<?= base_url();?>/actionupdate/update_user_new",
                        method:"POST",
                        data:postData,
                        dataType: 'json',
                        beforeSend: function()
                        {
                            $( ".successbtn"+columname ).removeAttr( 'onclick' );
                        },
                        success:function(response)
                        {  
                            if(response.error)
                            {                          
                                $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'danger',
                                delay: 3000,
                                allow_dismiss: true
                                });
                                //return false
                            }
                            else
                            {
                                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'success',
                                delay: 2500,
                                allow_dismiss: true
                                });

                                setTimeout(function(){location.reload();}, 3000);
                            } 
                        }
                    })
                }
            }
            
            function changestatus(row_id,curr_status)
            {
                var new_status;
                // alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                    new_status='2';
                else if (curr_status=='2')
                    new_status='1';
                //alert(nst);
                $( "#btnstatus" ).removeAttr( 'onclick' );
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/master_users" );
            }

        </script>
    </body>
</html>
