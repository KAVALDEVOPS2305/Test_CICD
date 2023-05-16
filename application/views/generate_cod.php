<?php
$page_id = 'generate_cod';
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
                                            Billing<br><small>Generate COD</small>
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
                            <li><a href="javascript:;">Generate COD</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Generate <strong>COD</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_generatecod" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <!-- <div class="form-group">
                                            <h4 class="col-md-offset-1">Generate COD for users having COD cycle <?php echo date('d-M-Y', strtotime("-1 day")) ?>.</h4>

                                            <input type="hidden" name="cod_cycle_date" id="cod_cycle_date" value="<?php echo date('Y-m-d', strtotime("-1 day")) ?>">
                                            <div class="col-md-offset-1">
                                                <button type="submit" class="btn btn-lg btn-success" id="savebtn"><i class="fa fa-save"></i> Generate COD</button>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="cod_cycle_date">Generate invoice for users having billing cycle<span class="text-danger">*</span></label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control input-datepicker-close" data-date-format="yyyy-mm-dd" name="cod_cycle_date" id="cod_cycle_date" placeholder="yyyy-mm-dd" required>              
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-1">
                                                <button type="submit" class="btn btn-lg btn-success" id="savebtn"><i class="fa fa-save"></i> Generate COD</button>
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
                $('#cod_cycle_date').datepicker('setDate', 'now');
            });

            $('#form_generatecod').on('submit', function(e)
            {
                if($("#form_generatecod").valid())
                {
                    // $('#savebtn').prop('disabled', true);
                    update_data("form_generatecod","<?= base_url();?>billing/generate_cod");
                }
                else
                    e.preventDefault();        
            });
        </script>

    </body>
</html>