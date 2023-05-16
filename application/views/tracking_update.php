<?php
$page_id = 'tracking_update';
?>
<!--view-->
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

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
                <?php //require_once('sidebar-right.php'); 
                ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Shipments <strong>Status Update</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->
                                    <div id="loader" class="text-center" style="display: none;">
                                        <i class="fa fa-spinner fa-3x fa-spin"></i><br />Updating Statuses, Please wait...
                                    </div>
                                    <div class="alert alert-danger alert-dismissable" id="alert" style="display:none;">
                                        <button type="button" class="close" style="color:#000;" data-dismiss="alert" aria-hidden="true">x</button>
                                        <h5 style="margin: 0px;" id="alert_message"></h5>
                                    </div>

                                    <form method="post" id="excel_error" style="display: none;" action="<?php echo base_url('Actionexport/tracking_update_errordownload') ?>" enctype="multipart/form-data">
                                    </form>

                                    <form method="post" id="form_trackingupdate" class="form-horizontal form-bordered" onsubmit="return false;">

                                        <!-- Horizontal Form Content -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-3 control-label" for="awb_file">Upload AWB Number<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="awb_file" name="awb_file" accept=".csv" required>
                                                    <span class="help-block">Upload CSV format file only.</span>
                                                </div>
                                            </div>

                                            <label class="col-md-3 control-label col-md-offset-2" style="text-align: left; margin-top: -15px;">
                                                <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                <a href="<?= base_url("assets/samples/Sample-UpdateTracking.csv") ?>" download>Download Sample</a>
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
        <script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/vendor/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/plugins.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?= base_url(); ?>assets/js/pages/formsValidation.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/tablesDatatables.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/uiProgress.js"></script>
        <script src="<?= base_url(); ?>assets/js/customjs.js"></script>
        <script>
            $(function() {
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_trackingupdate').on('submit', function(e) {
                var data = new FormData(this);
                if ($("#form_trackingupdate").valid()) {
                    $('#savebtn').prop('disabled', true);
                    excel_upload("form_trackingupdate", "<?= base_url(); ?>Update_tracking/via_awb", data);
                } else
                    e.preventDefault();
            });

            $(document).on('click', "#btn_downloaderror", function() {
                // alert("Error Submit");
                $("#excel_error").submit();
            });
        </script>
    </body>

</html>