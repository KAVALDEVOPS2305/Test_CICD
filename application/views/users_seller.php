<?php
$page_id = 'users_seller';
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
                        <!-- Validation Header -->
                         <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="gi gi-user"></i>User's Seller<br><small>user's seller</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="users_seller">User's Seller</a></li>
                        </ul>
                        <!-- END Validation Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>User's Seller</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <!-- Filter for user's seller -->
                                    <form method="post" id="form_searchuserseller" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" autocomplete="off" placeholder="Search using username...">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Seller Name</label>
                                                <input type="text" id="seller_name" name="seller_name" class="form-control autocomplete-seller_name" placeholder="Search using seller name...">
                                            </div>                               
                                           <div class="col-md-3">
                                                <label>From Date</label>
                                                <input type="text" id="from_date" name="from_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 00:00:00" placeholder="dd-mm-yyyy hh:ii:ss">
                                            </div>
                                            <div class="col-md-3">
                                                <label>To Date</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 23:59:59" placeholder="dd-mm-yyyy hh:ii:ss">
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-search"></i> Search</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>
                        </div>
                         <div class="block full" id="table-div" style="display: none;">
                            <div class="block-title" style="margin-bottom: 0px;">
                                <h2>View User's <strong>Seller</strong></h2>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata">                               
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
                
                $('#from_date').datepicker('setDate', 'now');
                $('#to_date').datepicker('setDate', 'now');
                search_data("form_searchuserseller","<?= base_url();?>actionsearch/search_users_seller/0");
            });

            $('#form_searchuserseller').on('submit', function(e)
            {
                search_data("form_searchuserseller","<?= base_url();?>actionsearch/search_users_seller/0");
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchuserseller","<?= base_url();?>actionsearch/search_users_seller/"+(page-1)*100);
            });
        </script>
    </body>
</html>