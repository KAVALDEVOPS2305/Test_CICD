<?php
$page_id = 'manual_invoice';
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
                <!-- Alternative Sidebar -->
                <?php // require_once('sidebar-right.php'); ?>
                <!-- END Alternative Sidebar -->

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
                        <!-- Header  -->
                        <div class="content-header">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="header-section">
                                        <h1>
                                            Billing<br><small>Manual Invoice</small>
                                        </h1>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <?php require_once('billing_navbar.php'); ?>
                                </div>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Billing</li>
                            <li><a href="javascript:;">Manual Invoice</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Manual <strong>Invoice</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_manualinvoice" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label>Username</label>
                                                <select name="username" id="username" class="select-select2 form-control" style="width: 100%;" data-placeholder="Username..." required>
                                                    <option></option>
                                                    <?php     
                                                    $result=$this->db->where('account_status', '1')->where('billing_type', 'postpaid')->get('users');
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->user_id; ?>"><?php echo $row->username; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label>Invoice Date</label>
                                                <input type="text" id="invoice_date" name="invoice_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Invoice Amount</label>
                                                <input type="text" id="invoice_amount" name="invoice_amount" class="form-control" placeholder="Invoice Amount..." onkeyup="calcgst()" required>
                                            </div>

                                            <div class="col-md-2">
                                                <label>GST</label>
                                                <input type="text" id="gst" name="gst" class="form-control" placeholder="GST" readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Total Amount</label>
                                                <input type="text" id="total_amount" name="total_amount" class="form-control" placeholder="Total Amount" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-sm btn-success" id="searchbtn"> Submit</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="btn_reset"><i class="fa fa-repeat"></i> Reset</button>
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
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
                $('#billing_date').datepicker('setDate', 'now');
            });

            $('#form_manualinvoice').on('submit', function(e)
            {
                if($("#form_manualinvoice").valid())
                {
                    var data = new FormData(this);
                    update_data("form_manualinvoice","<?= base_url();?>billing/manualinvoice",data);
                }
                else
                    e.preventDefault();
            });

            function calcgst()
            {
                inv_amt    = $("#invoice_amount").val();
                gst        = inv_amt * 18/100;
                $("#gst").val(gst.toFixed(2));
                $("#total_amount").val((parseFloat(inv_amt) + parseFloat(gst)).toFixed(2));
            }
        </script>

    </body>
</html>