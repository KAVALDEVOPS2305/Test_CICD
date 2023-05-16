<?php
$page_id = 'get_pickupid';
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
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Report</li>
                            <li><a href="javascript:void(0);">Pickup Id</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Search Pickup Id</h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal FormContent  -->
                                    <form method="post" id="form_get_pickupid" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="order_id">Order Ids<span class="text-danger">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" id="order_id" name="order_id" class="form-control" placeholder="Enter order ids (Comma separated)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-cubes"></i> Get Pickup Ids</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->                                    
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>

                            <div class="col-md-12">
                                <!-- Description List Horizontal Block -->
                                <div class="block full" id="table-div" style="display: none;">
                                    <div class="block-title" style="margin-bottom: 0px;">
                                        <h2>View <strong>Pickup id</strong></h2>
                                    </div>
                                    <div id="loader" class="text-center" style="margin-top: 10px;">
                                        <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                                    </div>
                                    <div class="table-responsive" id="render_searchdata"></div>
                                </div>
                                <!-- END Description List Horizontal Block -->
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
        <!-- <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a> -->

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.0.0-beta.3/babel.min.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_get_pickupid').on('submit', function(e)
            {
                search_data("form_get_pickupid","<?= base_url();?>actionsearch/search_pickup_id");
            });
        </script>

    </body>
</html>