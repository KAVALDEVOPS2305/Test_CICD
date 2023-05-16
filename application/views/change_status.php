<?php
$page_id = 'change_status';
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
                        <!-- Header  -->
                        <div class="content-header">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="header-section">
                                        <h1>
                                            Billing<br><small>Change status</small>
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
                            <li><a href="javascript:;">Change status</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Change <strong>Shipment status</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_changestatus" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-1 control-label" for="awb_num">AWB #<span class="text-danger">*</span></label>
                                            <div class="col-md-2">
                                                <input type="text" id="awb_num" name="awb_num" class="form-control" placeholder="Enter AWB #..." required>
                                            </div>

                                            <label class="col-md-1 control-label">Status</label>
                                            <div class="col-md-2">
                                                <select name="order_status" id="order_status" class="form-control" data-placeholder="Select status..." required>
                                                    <option value="">-- Select Status --</option>
                                                    <option value="226">Delivered</option>
                                                    <option value="225">RTO</option>
                                                </select>
                                            </div>

                                            <label class="col-md-1 control-label">Date</label>
                                            <div class="col-md-2">
                                                <input type="text" id="status_date" name="status_date" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="Select Date" required>
                                            </div>

                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-1">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Update</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>

                                    <hr/>

                                    <form method="post" id="form_changestatus_bulk" enctype="multipart/form-data" class="form-horizontal form-bordered" action="<?php echo base_url('Billing/change_status_bulk')?>">
                                        <div class="form-group">
                                            <label class="col-md-1 control-label" for="awb_num">Bulk Updt<span class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <input type="file" id="awb_file" name="awb_file" class="form-control" placeholder="Enter AWB file #..." accept=".csv">
                                            </div>

                                            <div class="col-md-4 col-md-offset-1">
                                                <label class="control-label" style="text-align: left; margin-top: -15px;">
                                                    <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="assets/samples/Sample-Change_status.csv" download>Sample</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-1">
                                                <button type="submit" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-upload"></i> Upload</button>
                                                
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
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_changestatus').on('submit', function(e)
            {
                if($("#form_changestatus").valid())
                {
                    // $('#savebtn').prop('disabled', true);
                    update_data("form_changestatus","<?= base_url();?>billing/change_status");
                }
                else
                    e.preventDefault();        
            });
        </script>

    </body>
</html>