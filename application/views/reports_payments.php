<?php
$page_id = 'all_payments';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css"/>
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
                        <!-- <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-truck"></i>All Shipments<br><small>Search/View all shipments</small>
                                </h1>
                            </div>
                        </div> -->
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Report</li>
                            <li><a href="javascript:void">All Payments</a></li>
                        </ul>
                        <!-- END Validation Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>Payments</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_allpayments" action="<?php echo base_url('Actionexport/allpayments')?>" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" autocomplete="off" placeholder="Search using username...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Business Name</label>
                                                <input type="text" id="business_name" name="business_name" class="form-control autocomplete-businessname" placeholder="Search using business name...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Billing Type</label>
                                                <select name="billing_type" id="billing_type" class="form-control">
                                                    <option value="">Search by billing</option>
                                                    <option value="prepaid">Prepaid</option>
                                                    <option value="postpaid">Postpaid</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Transaction Type</label>
                                                <select name="transaction_type[]" id="transaction_type" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by transaction type...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->where_in('transaction_type_id','1001,1011,1013', false)->get('transaction_types');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->transaction_type_id; ?>"><?php echo $row->transaction_remark; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Transaction Reference #</label>
                                                <input type="text" id="transaction_reference_id" name="transaction_reference_id" class="form-control" placeholder="Search by reference #...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Gateway Order Id</label>
                                                <input type="text" id="gateway_order_id" name="gateway_order_id" class="form-control" placeholder="Search using Gateway Id...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Amount From</label>
                                                <input type="text" id="amount_from" name="amount_from" class="form-control" placeholder="Search using balance amount...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Amount To</label>
                                                <input type="text" id="amount_to" name="amount_to" class="form-control" placeholder="Search using balance amount...">
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Gateway Payment Id</label>
                                                <input type="text" id="gateway_payment_id" name="gateway_payment_id" class="form-control" placeholder="Search using Gateway Id...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Transaction Date From</label>
                                                <input type="text" id="from_date" name="from_date"  class="form-control datetimepicker" data-date-format="dd-mm-yyyy 00:00:00" placeholder="dd-mm-yyyy hh:ii:ss" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Transaction Date To</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control datetimepicker" data-date-format="dd-mm-yyyy 23:59:59" placeholder="dd-mm-yyyy hh:mm:ss" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Date Range</label>
                                                <select class="form-control" onchange="datetimerange(this.value);" onfocus="this.selectedIndex = -1;">
                                                    <option value="0">All Data</option>
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
                                                
                                                <button type="reset" id="btnReset" class="btn btn-sm btn-primary" id="btn_reset"><i class="fa fa-repeat"></i> All Data</button>
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
                                <h2>View <strong>Payments</strong></h2>
                                <div class="block-options pull-right">
                                    <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="allpayments"><i class="fa fa-file-excel-o"></i> Export</button></a>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="" id="render_searchdata"></div>
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
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();

                $('#from_date').val(moment().format('DD-MM-YYYY 00:00:00'));
                $('#to_date').val(moment().format('DD-MM-YYYY 23:59:59'));

                search_sum_data("form_allpayments","<?= base_url();?>actionsearch/search_allpayments/0");
            });

            $('#searchbtn').on('click', function()
            {
                search_sum_data("form_allpayments","<?= base_url();?>actionsearch/search_allpayments/0");
            });

            $('#allpayments').on('click', function(e)
            {
                $('#form_allpayments').submit();
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_sum_data("form_allpayments","<?= base_url();?>actionsearch/search_allpayments/"+(page-1)*100);
            });
        </script>

    </body>
</html>