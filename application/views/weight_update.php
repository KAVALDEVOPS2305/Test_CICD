<?php
$page_id = 'weight_update';
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
                <?php //require_once('sidebar-right.php'); ?>
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
                                            Billing<br><small>Weight Update</small>
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
                            <li><a href="javascript:;">Weight Update</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Shipment  <strong>Weight reconciliation</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="<?= base_url()?>user_weight_request" target="_blank" title="view Weight Requests" data-original-title="view Weight Requests" class="btn btn-sm btn-warning"><i class="fa fa-users"></i> View User's Requests</a>
                                        </div>
                                    </div>
                                    <!-- END Horizontal Form Title -->
                                    <div id="loader" class="text-center" style="display: none;">
                                        <i class="fa fa-spinner fa-3x fa-spin"></i><br/>Updating Data...
                                    </div>
                                    <div class="alert alert-danger alert-dismissable" id="alert" style="display:none;">
                                        <button type="button" class="close" style="color:#000;" data-dismiss="alert" aria-hidden="true">x</button>
                                        <h5 style="margin: 0px;" id="alert_message">
                                            
                                        </h5>
                                    </div>
                                    <form method="post" id="excel_error" style="display: none;" action="<?php echo base_url('Actionexport/weight_update_errordownload')?>" enctype="multipart/form-data">
                                    </form>

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_weightupdate" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-3 control-label" for="weight_file">Upload weight reconciliation excel<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="weight_file" name="weight_file" accept=".csv" required>
                                                    <span class="help-block">Upload CSV format file only.</span>
                                                </div>
                                            </div>

                                            <label class="col-md-3 control-label col-md-offset-2" style="text-align: left; margin-top: -15px;">
                                                <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                <a href="<?= base_url("assets/samples/Sample-UpdateWeight.csv")?>" download>Download Sample</a>
                                            </label>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-3">
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
                        <!-- Error Preview Modal -->
                        <div id="modal-preview" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Preview error records</b></h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="table-responsive" id="render_errordata"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Error Preview Modal -->
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

            $('#form_weightupdate').on('submit', function(e)
            {
                var data = new FormData(this);
                if($("#form_weightupdate").valid())
                {
                    // $('#savebtn').prop('disabled', true);
                    review_excelupdate("form_weightupdate","<?= base_url();?>billing/preview_weightupdate",data);
                }
                else
                    e.preventDefault();        
            });

            function reupload() {
                $('#modal-preview').modal('hide');
                $('#savebtn').prop('disabled', false);
            }

            function saveanyway() {
                if($("#form_weightupdateanyway").valid())
                {
                    $('#continuebtn').prop('disabled', true);
                    excel_update("form_weightupdateanyway","<?= base_url();?>billing/weightupdate");
                }
                else
                    e.preventDefault();
            }
        
            $(document).on('click',"#btn_downloaderror",function(){
                // alert("Error Submit");
                $("#excel_error").submit();
            });
        </script>
    </body>
</html>