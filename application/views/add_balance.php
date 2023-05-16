<?php
$page_id = 'add_balance';
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
                                    <i class="gi gi-wallet"></i>Manage Balance<br><small>Debit, Credit Prepaid user balance from wallet</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Billing</li>
                            <li><a href="javascript:void;">Manage Balance</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Manage <strong>Balance</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_managebalance" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="username">Username<span class="text-danger">*</span></label>
                                                <div class="col-md-3">
                                                    <!-- <input type="text" id="username" name="username" class="form-control autocomplete-username" placeholder="Enter email id..." onblur="getprepaid_user(this.value);"> -->
                                                    <div class="input-group">
                                                        <input type="text" id="username" name="username" class="form-control autocomplete-username" placeholder="Enter email id...">
                                                        <span class="input-group-btn">
                                                            <button type="button" id="get_user_details" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-4 control-label" id="business_name" style="text-align: left;">Business Name</label>
                                                <label class="col-md-3 control-label" id="full_name" style="text-align: left;">Full Name</label>
                                            </div>
                                            <input type="hidden" name="user_id" id="user_id" />
                                            <input type="hidden" name="total_balance" id="total_balance" />
                                        </div>


                                        <div class="form-group">
                                            <div class="component-group">
                                            <label class="col-md-2 control-label">Balances</label>
                                                <div class="col-md-2">
                                                    <input type="text" id="main_bal" name="main_bal" class="form-control" readonly>
                                                    <span class="help-text">Main</span>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" id="promo_bal" name="promo_bal" class="form-control" readonly>
                                                    <span class="help-text">Promo</span>
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="balance_type">Balance<span class="text-danger">*</span></label>
                                                <div class="col-md-2">
                                                    <select name="balance_type" id="balance_type" class="form-control" data-placeholder="Select Balace..." readonly>
                                                        <option value="">-- Select Balance --</option>
                                                        <option value="main" selected>Main</option>
                                                        <option value="promo">Promo</option>
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="action_type">Action<span class="text-danger">*</span></label>
                                                <div class="col-md-2">
                                                    <select name="action_type" id="action_type" class="form-control" data-placeholder="Select Action...">
                                                        <option value="">-- Select Action --</option>
                                                        <option value="credit">Credit</option>
                                                        <option value="debit">Debit</option>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="transaction_amount">Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-3">
                                                    <input type="text" id="transaction_amount" name="transaction_amount" class="form-control" placeholder="Enter amount...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-1 control-label" for="transaction_remark">Remark<span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" id="transaction_remark" name="transaction_remark" class="form-control" placeholder="Enter transaction remark...">
                                                </div>
                                            </div>                                           
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
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
         <script src="<?= base_url();?>assets/js/pages/tablesDatatables.js"></script>
        <script src="<?= base_url();?>assets/js/pages/uiProgress.js"></script>
        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        <script src="<?= base_url();?>assets/js/autocomplete.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_managebalance').on('submit', function(e)
            {
                if($("#form_managebalance").valid())
                {
                    $('#savebtn').prop('disabled', true);
                    ins_data("form_managebalance","<?= base_url();?>billing/manage_balances");
                }
                else
                    e.preventDefault();        
            });

            // function getprepaid_user(userid)
            $("#get_user_details").click(function()
            {
                userid = $("#username").val();
                // alert(userid);
                $.ajax({
                    url :  "<?= base_url();?>billing/get_prepaidusers",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : userid },
                    success:function(response)
                    {
                        if(response!='0')
                        {
                            var r = response.split("#");
                            // alert(r);
                            $("#user_id").val(r[0].trim());
                            $("#full_name").html(r[1].trim());
                            $("#business_name").html(r[2].trim());
                            $("#main_bal").val(r[3].trim());
                            $("#promo_bal").val(r[4].trim());
                            $("#total_balance").val(r[5].trim());
                            $("#balance_type").focus();
                        }
                        else
                        {
                            $('#form_managebalance')[0].reset();
                            $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> Not found</h4> <p>Invalid username or account is postpaid.</p>', {
                                type: 'danger',
                                delay: 2500,
                                allow_dismiss: true
                            });
                        }
                    }
                });
            });
        </script>

    </body>
</html>