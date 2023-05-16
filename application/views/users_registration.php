<?php
$page_id = 'users_registration';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
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
                                <i class="fa fa-user-plus"></i>Register User<br><small>Add/Register User</small>
                            </h1>
                        </div>
                    </div>
                    <ul class="breadcrumb breadcrumb-top">
                        <li>Users</li>
                        <li><a href="admin_modules">Registration</a></li>
                    </ul>
                    <!-- END Validation Header -->

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Horizontal Form Block -->
                            <div class="block">
                                <!-- Horizontal Form Title -->
                                <div class="block-title">
                                    <h2>Register <strong>User</strong></h2>
                                </div>
                                <!-- END Horizontal Form Title -->

                                <!-- Clickable Wizard Content -->
                                <form id="form_userregistration" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data" onsubmit="return false;">
                                    <!-- First Step - User Details -->
                                    <div id="clickable-first" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                    
                                                    

                                                    <!-- <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>3. Extras</strong></a></li> -->
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="fullname">Fullname<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter User's fullname...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="email_id">Email<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="email" id="email_id" name="email_id" class="form-control" placeholder="Enter user's email...">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="cid" name="cid" />

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="contact">Contact<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="contact" name="contact" class="form-control" placeholder="Enter User's contact..." minlength="10" maxlength="10">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="alt_contact">Alt. Contact</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="alt_contact" name="alt_contact" class="form-control" placeholder="Enter user's alt contact">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="business_name">Business Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="business_name" name="business_name" class="form-control" placeholder="Enter User's Business name...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="business_type">Business Type<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="business_type" id="business_type" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Business type...">
                                                        <option></option>
                                                        <option value="Sole Proprietorship">Sole Proprietorship</option>
                                                        <option value="Partnership Firm">Partnership Firm/LLP</option>
                                                        <option value="Private Limited Company">Private Limited Company</option>
                                                        <option value="Public Limited Company">Public Limited Company</option>
                                                        <option value="Educational Institution">Educational Institution</option>
                                                        <option value="Political Party">Political Party</option>
                                                        <option value="NGO">NGO</option>
                                                        <option value="Nationalised Bank">Nationalised Bank</option>
                                                        <option value="Private Bank">Private Bank</option>
                                                        <option value="Life Insurance Company">Life Insurance Company</option>
                                                        <option value="General Insurance Company">General Insurance Company</option>
                                                        <option value="Others">Others</option>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END First Step -->

                                    <!-- Second Step - Account Settings -->
                                    <div id="clickable-second" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="billing_type">Billing Type<span class="text-danger">*</span></label>
                                                <div class="col-md-3">
                                                    <select name="billing_type" id="billing_type" class="form-control" data-placeholder="Select Billing type...">
                                                        <option value="">-- Select Bill Type --</option>
                                                        <option value="prepaid">Prepaid</option>
                                                        <option value="postpaid">Postpaid</option>
                                                    </select> 
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="switch switch-info">
                                                        <input type="checkbox" id="val_terms" name="val_terms">
                                                        <span data-toggle="tooltip" title="Adjust COD?" data-original-title="Switch on to adjust COD"></span>
                                                    </label>

                                                <input type="hidden" id="codadjust" name="codadjust" value="no" />
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="liability_amount">Liability Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="liability_amount" name="liability_amount" class="form-control" placeholder="Enter user's Liability Amount">
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="ndd_charges">NDD Charges<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="ndd_charges" name="ndd_charges" class="form-control" placeholder="Enter User's NDD Charges...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="insurance_charges">Insurance Charges<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="insurance_charges" name="insurance_charges" class="form-control" placeholder="Enter user's Insurance Charges in %">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="capping_amount">Capping Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="capping_amount" name="capping_amount" class="form-control" placeholder="Enter User's Capping Amount...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="restrict_amount">Restriction Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="restrict_amount" name="restrict_amount" class="form-control" placeholder="Enter user's Restriction Amount">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="credit_period">Credit Period<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="credit_period" name="credit_period" class="form-control" placeholder="Enter Credit Period in days...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="agreement_doc">Agreement Doc<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="agreement_doc" name="agreement_doc">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="referral_type">Referrer Type<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="referral_type" id="referral_type" class="form-control" data-placeholder="Select Referal type...">
                                                        <option value="">-- Select Referrer Type --</option>
                                                        <option value="Affiliate">Affiliate</option>
                                                        <option value="Loyalty">Loyalty</option>
                                                        <option value="Facebook">Facebook</option>
                                                        <option value="Google">Google</option>
                                                        <option value="Web">Web</option>
                                                        <option value="BNI">BNI</option>
                                                        <option value="Others">Others</option>
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="referred_by">Reffered By<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="referred_by" id="referred_by" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Reffered By...">
                                                        <option></option>
                                                        <option value="0" selected>None</option>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Second Step -->

                                    <!-- Third Step - Weight Slab -->
                                    <div id="clickable-third" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->

                                        <div id="div_add_slab">
                                            <div class="form-group">
                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="express_type[]">Express Type<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <select name="express_type[]" id="express_type" class="form-control">
                                                            <option value="">-- Select Express --</option>
                                                            <option value="air">Air</option>
                                                            <option value="surface">Surface</option>
                                                        </select> 
                                                    </div>
                                                </div>

                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="weight_slab_id[]">Weight Slab<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <select name="weight_slab_id[]" id="weight_slab_id" class="form-control">
                                                            <option value=""> -- Select Weight Slab -- </option>
                                                            <?php     
                                                            $result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');
                                                            // print_r($this->db->last_query());
                                                            foreach($result->result() as $row)
                                                            {
                                                            ?>
                                                            <option value="<?php echo $row->weightslab_id; ?>"><?php echo $row->slab_title; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="component-group">
                                                    <div class="col-md-1 col-md-offset-1">
                                                        <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Add more slabs" id="btn_add_slab" name="btn_add_slab"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Third Step -->

                                    <!-- Fourth Step - Billing Settings -->
                                    <div id="clickable-fourth" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="category_level">Category<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="category_level" id="category_level" class="form-control" data-placeholder="Select Billing type...">
                                                        <option value="">-- Select Category --</option>
                                                        <option value="Bronze">Bronze</option>
                                                        <option value="Silver">Silver</option>
                                                        <option value="Gold">Gold</option>
                                                        <option value="Platinum">Platinum</option>
                                                        <option value="Diamond">Diamond</option>
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="codgap">COD Gap<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="codgap" name="codgap" class="form-control" placeholder="D + n">
                                                    <span class="help-block" id="codgap_label"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="billing_cycle_id">Billing Cycle<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="billing_cycle_id" id="billing_cycle_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Billing Cycle..." onchange="getbillingdate(this.value)">
                                                        <option></option>
                                                        <?php     
                                                        $result=$this->db->where('billing_cycle_status =','1')->order_by('billing_cycle_title', 'ASC')->get('master_billing_cycle');
                                                        // print_r($this->db->last_query());

                                                        foreach($result->result() as $row)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $row->billing_cycle_id; ?>"><?php echo $row->billing_cycle_title; ?></option>
                                                        <?php }?>
                                                    </select>

                                                    <span class="help-block" id="billing_cycle_dates">Dates:</span>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="cod_cycle_id">COD Cycle<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="cod_cycle_id" id="cod_cycle_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select COD Cycle..." onchange="getcoddate(this.value)">
                                                        <option></option>
                                                        <?php     
                                                        $result=$this->db->where('cod_cycle_status =','1')->order_by('cod_cycle_title', 'ASC')->get('master_cod_cycle');
                                                        // print_r($this->db->last_query());

                                                        foreach($result->result() as $row)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $row->cod_cycle_id; ?>"><?php echo $row->cod_cycle_title; ?></option>
                                                        <?php }?>
                                                    </select>
                                                    <span class="help-block" id="cod_cycle_dates">Dates:</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="cod_fees_amt">COD Fees Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="cod_fees_amt" name="cod_fees_amt" class="form-control" placeholder="Enter Minimum COD Fees">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="cod_fees_per">COD Fees %age<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="cod_fees_per" name="cod_fees_per" class="form-control" placeholder="Enter COD Fees %">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="awb_charges">AWB Charges</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="awb_charges" name="awb_charges" class="form-control" placeholder="Enter AWB charges in amount" value="0">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="fsc_rate">FSC %</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="fsc_rate" name="fsc_rate" class="form-control" placeholder="Enter fuel surcharge %" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="surcharge_3">Surcharge 3</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="surcharge_3" name="surcharge_3" class="form-control" placeholder="Enter Surcharge amount" value="0">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="surcharge_4">Surcharge 4</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="surcharge_4" name="surcharge_4" class="form-control" placeholder="Enter Surcharge %" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Fourth Step -->

                                    <!-- Fifth Step - Billing Details -->
                                    <div id="clickable-fifth" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="billing_address">Billing Address<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="billing_address" name="billing_address" class="form-control" placeholder="Enter User's Billing Address...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="billing_state">Billing State<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="billing_state" id="billing_state" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select State...">
                                                        <option></option>
                                                        <?php     
                                                        $result=$this->db->order_by('state_name', 'ASC')->get('tbl_state');
                                                        // print_r($this->db->last_query());

                                                        foreach($result->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->state_name; ?>"><?php echo $row->state_name; ?></option>
                                                        <?php }?>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="cancelled_cheque">Cancelled Cheque<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="cancelled_cheque" name="cancelled_cheque">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="beneficiary_name">Beneficiary Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="beneficiary_name" name="beneficiary_name" class="form-control" placeholder="Enter User's Beneficiary Name...">
                                                </div>
                                            </div>                                                
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="account_number">Account Number<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Enter user's Account Number">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="ifsc_code">IFSC Code<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" placeholder="Enter User's IFSC Code..." minlength="11" maxlength="11" onblur="ifsclookup(this.value);">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Enter user's Bank">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="branch_name">Branch Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="branch_name" name="branch_name" class="form-control" placeholder="Enter Bank Branch...">
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                    <!-- END Fifth Step -->

                                    <!-- Sixth Step - KYC Details -->
                                    <div id="clickable-sixth" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_pan">PAN<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="kyc_pan" name="kyc_pan" class="form-control" placeholder="Enter PAN..." minlength="10" maxlength="10">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_pan_doc">Upload PAN<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="kyc_pan_doc" name="kyc_pan_doc">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_gst_reg">Is GST Registered<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select id="kyc_gst_reg" name="kyc_gst_reg" class="form-control">
                                                        <option value="">-- Is GST Registered? --</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_doctype">Document Type<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="kyc_doctype" name="kyc_doctype" class="form-control input-typeahead_docs" autocomplete="off" placeholder="Enter KYC Document type...">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_doc_number">KYC Doc Number<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="kyc_doc_number" name="kyc_doc_number" class="form-control" placeholder="Enter KYC Document Number...">
                                                    <span class="help-block" id="verifygst" style="display: none;"><a href="https://services.gst.gov.in/services/searchtp" target="_blank">Verify GST</a> </span>
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="kyc_document">Upload KYC Doc<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="kyc_document" name="kyc_document">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="tan_number">TAN Number</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="tan_number" name="tan_number" class="form-control" placeholder="Enter TAN Number..." minlength="10" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Sixth Step -->

                                    <!-- Seventh Step - POCs -->
                                    <div id="clickable-seventh" class="step">
                                        <!-- Step Info -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <ul class="nav nav-pills nav-justified clickable-steps">
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-first"><strong>1. User Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-second"><strong>2. Account Setup</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-third"><strong>3. Weight Slab</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fourth"><strong>4. Billing Settings</strong></a></li>

                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-fifth"><strong>5. Billing Details</strong></a></li>
                                                    
                                                    <li><a href="javascript:void(0)" data-gotostep="clickable-sixth"><strong>6. KYC Details</strong></a></li>

                                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-seventh"><strong>7. POCs</strong></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END Step Info -->
                                        <!-- Sales POC -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="sales_poc_id">Sales<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="sales_poc_id" id="sales_poc_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Sales POC..." onchange="getpocdetails(this.value, this.id)">
                                                        <option></option>
                                                        <?php
                                                            $sales=$this->db->select('admin_uid,admin_name')
                                                                    ->where('admin_role =','3')->where('admin_status =','1')
                                                                    ->order_by('admin_name', 'ASC')->get('admin_users');
                                                        
                                                        foreach($sales->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>"><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                    <!-- <?php //print_r($this->db->last_query());?> -->
                                                </div>

                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-3">
                                                    <input type="text" id="sales_mobile" class="form-control" placeholder="Sales POC Mobile Number" readonly>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-4">
                                                    <input type="text" id="sales_email" class="form-control" placeholder="Sales POC Email Id" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Operations POC-->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="ops_poc_id">Operations<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="ops_poc_id" id="ops_poc_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Operations POC..." onchange="getpocdetails(this.value, this.id)">
                                                        <option></option>
                                                        <?php
                                                            $sales=$this->db->select('admin_uid,admin_name')
                                                                    ->where('admin_role =','2')->where('admin_status =','1')
                                                                    ->order_by('admin_name', 'ASC')->get('admin_users');
                                                        
                                                        foreach($sales->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>"><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-3">
                                                    <input type="text" id="ops_mobile" class="form-control" placeholder="Operations POC Mobile Number" readonly>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-4">
                                                    <input type="text" id="ops_email" class="form-control" placeholder="Operations POC Email Id" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- NDR POC -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="ndr_poc_id">NDR<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="ndr_poc_id" id="ndr_poc_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select NDR POC..." onchange="getpocdetails(this.value, this.id)">
                                                        <option></option>
                                                        <?php
                                                            $sales=$this->db->select('admin_uid,admin_name')
                                                                    ->where('admin_role =','4')->where('admin_status =','1')
                                                                    ->order_by('admin_name', 'ASC')->get('admin_users');
                                                        
                                                        foreach($sales->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>"><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-3">
                                                    <input type="text" id="ndr_mobile" name="ndr_mobile" class="form-control" placeholder="NDR POC Mobile Number" readonly>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-4">
                                                    <input type="text" id="ndr_email" name="ndr_email" class="form-control" placeholder="NDR POC Email Id" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pickup POC -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="pickup_poc_id">Pickup<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="pickup_poc_id" id="pickup_poc_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select pickup POC..." onchange="getpocdetails(this.value, this.id)">
                                                        <option></option>
                                                        <?php
                                                            $sales=$this->db->select('admin_uid,admin_name')
                                                                    ->where('admin_role =','5')->where('admin_status =','1')
                                                                    ->order_by('admin_name', 'ASC')->get('admin_users');
                                                        
                                                        foreach($sales->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>"><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-3">
                                                    <input type="text" id="pickup_mobile" name="pickup_mobile" class="form-control" placeholder="Pickup POC Mobile Number" readonly>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-4">
                                                    <input type="text" id="pickup_email" name="pickup_email" class="form-control" placeholder="Pickup POC Email Id" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="finance_poc_id">Finance<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="finance_poc_id" id="finance_poc_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Finance POC..." onchange="getpocdetails(this.value, this.id)">
                                                        <option></option>
                                                        <?php
                                                            $sales=$this->db->select('admin_uid,admin_name')
                                                                    ->where('admin_role =','6')->where('admin_status =','1')
                                                                    ->order_by('admin_name', 'ASC')->get('admin_users');
                                                        
                                                        foreach($sales->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>"><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-3">
                                                    <input type="text" id="finance_mobile" name="finance_mobile" class="form-control" placeholder="Finance POC Mobile Number" readonly>
                                                </div>
                                            </div>
                                            <div class="component-group">
                                                <div class="col-md-4">
                                                    <input type="text" id="finance_email" name="finance_email" class="form-control" placeholder="Finance POC Email Id" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Seventh Step -->


                                    <!-- Form Buttons -->
                                    <div class="form-group form-actions">
                                        <div class="col-md-8 col-md-offset-5">
                                            <button type="reset" class="btn btn-sm btn-warning" id="back3">Previous</button>
                                            <!-- <button type="submit" class="btn btn-sm btn-primary" id="next3">Next</button> -->
                                            <input type="submit" class="btn btn-sm btn-primary" id="next3" value="Next">
                                        </div>
                                    </div>
                                    <!-- END Form Buttons -->
                                </form>
                                <!-- END Clickable Wizard Content -->
                            </div>
                            <!-- END Horizontal Form Block -->                                
                        </div>
                    </div>

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
    <!-- <script src="<?= base_url();?>assets/js/pages/tablesDatatables.js"></script> -->
    <script src="<?= base_url();?>assets/js/pages/uiProgress.js"></script>
    <script src="<?= base_url();?>assets/js/pages/formsWizard.js"></script>
    <script src="<?= base_url();?>assets/js/pages/formsGeneral.js"></script>
    <script src="<?= base_url();?>assets/js/customjs.js"></script>


    <script>
        
        $(function(){
            FormsValidation.init();
            FormsWizard.init();
            UiProgress.init();
            FormsGeneral.init();
            // TablesDatatables.init();
        });


        
        $('#val_terms').on('change', function() {
            $('#codadjust').val($('#val_terms').is(':checked')?'yes':'no')
            // alert($('#codadjust').val());
        });


        $('#form_userregistration').on('submit', function(e)
        {
            if($("#form_userregistration").valid())
            {
                var data = new FormData(this);
                if($('#cid').val())
                    update_data("form_userregistration","<?= base_url();?>actionupdate/users_registercomplete"); 
                else
                    upload_data("form_userregistration","<?= base_url();?>actioninsert/users_registercomplete",data);
            }
            else
                e.preventDefault();
        });



        $('#billing_type').change(function()
        {
            // alert($("#kyc_gst_reg").val());
            if($("#billing_type").val()!='prepaid')
            {
                $("#capping_amount").val('0').prop("readonly", true);
                $("#restrict_amount").val('0').prop("readonly", true);
                $("#credit_period").val('').prop("readonly", false);
            }
            else
            {
                $("#capping_amount").val('100').prop("readonly", false);
                $("#restrict_amount").val('100').prop("readonly", false);
                $("#credit_period").val('0').prop("readonly", true);
            }
        });


        $('#kyc_gst_reg').change(function()
        {
            // alert($("#kyc_gst_reg").val());
            if($("#kyc_gst_reg").val()=='yes')
            {
                $("#kyc_doctype").val('GST Certificate').prop("readonly", true);
                $("#verifygst").show();
            }
            else
            {
                $("#kyc_doctype").val('').prop("readonly", false);
                $("#verifygst").hide();
            }
        });


        $('#codgap').keyup(function()
        {
            //alert($("#codgap").val());

            if ($("#codgap").val()!='')
                $("#codgap_label").html('D + ' + $("#codgap").val());
            else
                $("#codgap_label").text('');
        });



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


        function ifsclookup(ifsc)
        {
            //alert(ifsc);
            $.ajax({
                url :  "https://ifsc.razorpay.com/"+ifsc,
                datatype : "json",
                success:function(res)
                {
                    //alert(res);
                    $("#bank_name").val(res.BANK).prop("readonly", true);
                    $("#branch_name").val(res.BRANCH).prop("readonly", true);
                    // alert(${res.BANK});
                },
                error: function (res) {
                    //alert(res.responseText);
                    $("#bank_name").val("").prop("readonly", false);
                    $("#branch_name").val("").prop("readonly", false);

                    $.bootstrapGrowl('<h4><i class="fa fa-times"></i> IFSC Error</h4> <p>'+res.responseText+'</p>', {
                        type: 'danger',
                        delay: 2500,
                        allow_dismiss: true
                    });


                }
            });
        }

        function getpocdetails(value,field)
        {
            // alert(value +"##"+ field);
            $.ajax({
                url :  "<?= base_url();?>actiongetdata/get_pocdetails",
                type : "POST",
                datatype : "json",
                data : { 'id'   : value },
                success:function(res)
                {
                    var r = res.split("#");
                    // alert(r[0]);
                    if(field=="sales_poc_id")
                    {
                        $("#sales_email").val(r[0].trim());
                        $("#sales_mobile").val(r[1].trim());
                    }
                    else if(field=="ops_poc_id")
                    {
                        $("#ops_email").val(r[0].trim());
                        $("#ops_mobile").val(r[1].trim());
                    }
                    else if(field=="ndr_poc_id")
                    {
                        $("#ndr_email").val(r[0].trim());
                        $("#ndr_mobile").val(r[1].trim());
                    }
                    else if(field=="pickup_poc_id")
                    {
                        $("#pickup_email").val(r[0].trim());
                        $("#pickup_mobile").val(r[1].trim());
                    }
                    else if(field=="finance_poc_id")
                    {
                        $("#finance_email").val(r[0].trim());
                        $("#finance_mobile").val(r[1].trim());
                    }

                }
            });
        }


        var i=0;  
        $('#btn_add_slab').click(function()
        {  
            i++;
            // alert(i);
            var append_text='';

            append_text += '<div class="form-group" id="row'+i+'"><div class="component-group">';
            append_text += '<label class="col-md-2 control-label" for="express_type[]">Express Type<span class="text-danger">*</span></label>';

            append_text += '<div class="col-md-3"><select name="express_type[]" id="express_type" class="form-control">';

            append_text += '<option value="">-- Select Express --</option><option value="air">Air</option><option value="surface">Surface</option>';
            append_text += '</select> </div></div>';
            append_text += '<div class="component-group"><label class="col-md-2 control-label" for="weight_slab_id[]">Weight Slab<span class="text-danger">*</span></label>';

            append_text += '<div class="col-md-3"><select name="weight_slab_id[]" id="weight_slab_id" class="form-control">';
            append_text += '<option value="">-- Select weight slab --</option>';

            append_text += '<?php $result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');foreach($result->result() as $row){?>';

            append_text += '<option value="<?php echo $row->weightslab_id; ?>"><?php echo $row->slab_title; ?></option><?php }?>';

            append_text += '</select></div></div>';
            append_text += '<div class="component-group"><div class="col-md-1">';
                            
            append_text += '<button type="button" class="btn btn-sm btn-danger btn_remove_slab" data-toggle="tooltip" title="Remove Slab" id="'+i+'" name="btn_remove_slab"><i class="fa fa-trash-o"></i></button>';
            append_text += '</div></div></div>';

            // alert(i);
            $('#div_add_slab').append(append_text);
        });


        $(document).on('click', '.btn_remove_slab', function ()
        {  
            var button_id = $(this).attr("id");
            // alert(button_id);
            $('#row'+button_id+'').remove(); 
        });
    </script>

</body>
</html>