<?php
$page_id = 'view_invoice';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
        <style>
        .table thead > tr > th {
            font-size: 12px;
            font-weight: 600;
        }
        </style>
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
                                            Billing<br><small>View Invoice</small>
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
                            <li><a href="javascript:;">View Invoice</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark-default">
                                        <h2 style="color: white;">Search/View <strong>Invoice</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_viewinvoice" action="<?php echo base_url('Actionexport/searched_invoices')?>" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Invoice #</label>
                                                <input type="text" id="px_invoice_number" name="px_invoice_number" class="form-control" placeholder="Search by invoice #...">
                                            </div> 
                                            
                                            <div class="col-md-3">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" placeholder="Search by username...">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label>Business Name</label>
                                                <input type="text" id="business_name" name="business_name" class="form-control autocomplete-businessname" placeholder="Search by business...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Billing Type</label>
                                                <select name="billing_type" id="billing_type" class="form-control">
                                                    <option value="">Search by billing</option>
                                                    <option value="prepaid">Prepaid</option>
                                                    <option value="postpaid">Postpaid</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Invoice Status</label>
                                                <select name="invoice_status" id="invoice_status" class="form-control">
                                                    <option value="">Search by status</option>
                                                    <option value="2">Pending (Accrue)</option>
                                                    <option value="0">Due</option>
                                                    <option value="1">Paid</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>From Date</label>
                                                <input type="text" id="from_date" name="from_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>To Date</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Date Range</label>
                                                <select class="form-control" onchange="daterange(this.value);" onfocus="this.selectedIndex = -1;">
                                                    <option value="1" selected>Today</option>
                                                    <option value="2">Yesterday</option>
                                                    <option value="3">This Week</option>
                                                    <option value="4">Last week</option>
                                                    <option value="5">This Month</option>
                                                    <option value="6">Last Month</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-search"></i> Search</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="btn_reset"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>
                        </div>

                        <div class="block full" id="table-div" style="display: none;">
                            <div class="block-title">
                                <h2>View <strong>Invoices</strong></h2>

                                <div class="block-options pull-right">
                                    <button type="button" class="btn btn-sm btn-success" id="btn_exportexcel" data-toggle="tooltip" title data-original-title="Export Excel"><i class="fa fa-file-excel-o"></i> Export</button>

                                    <button type="button" class="btn btn-sm btn-success" id="btn_exportall" data-toggle="tooltip" title data-original-title="Export All AWBs"><i class="fa fa-file-excel-o"></i> Export All AWBs</button>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata"></div>
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
            });

            $('#searchbtn').on('click', function()
            {
                search_sum_data("form_viewinvoice","<?= base_url();?>actionsearch/search_invoice/0");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_viewinvoice').submit();
            });

            $('#btn_exportall').on('click', function(e)
            {
                var from_date   = $("#from_date").val();
                var to_date     = $("#to_date").val();
                window.open('<?= base_url();?>Actionexport/export_all_invoices_awbs?from_date='+from_date+'&to_date='+to_date);
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_viewinvoice","<?= base_url();?>actionsearch/search_invoice/"+(page-1)*100);
            });

            // $(document).ready(function() {
            //     $(window).on("load", function () {
            //         search_data("form_viewinvoice","<?= base_url();?>actionsearch/search_invoice/0");
            //     });
            // });

            // $('#form_viewinvoice').on('submit', function(e)
            // {
            //     if($("#form_viewinvoice").valid())
            //     {
            //         $('#savebtn').prop('disabled', true);
            //         // ins_data("form_viewinvoice","<?= base_url();?>actioninsert/administrator_roles");
            //     }
            //     else
            //         e.preventDefault();        
            // });

        </script>

    </body>
</html>