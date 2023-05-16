<?php
$page_id = 'shipments';
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
                            <li><a href="javascript:void">Processed Shipments</a></li>
                        </ul>
                        <!-- END Validation Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>Processed Shipments</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchshipments" action="<?php echo base_url('Actionexport/reports_shipments')?>" class="form-horizontal form-bordered">
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
                                                <label>Order Type</label>
                                                <select name="shipment_type" id="shipment_type" class="form-control">
                                                    <option value="">Search by Type</option>
                                                    <option value="forward">Forward</option>
                                                    <option value="reverse">Reverse</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Order Id</label>
                                                <input type="text" id="shipment_id" name="shipment_id" class="form-control" placeholder="Search using order id...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>AWB #</label>
                                                <input type="text" id="waybill_number" name="waybill_number" class="form-control" placeholder="Search using AWB...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Payment Mode</label>
                                                <select name="payment_mode" id="payment_mode" class="form-control">
                                                    <option value="">Search by Mode</option>
                                                    <option value="COD">COD</option>
                                                    <option value="PPD">Prepaid</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Express</label>
                                                <select name="express_type" id="express_type" class="form-control">
                                                    <option value="">Search by express</option>
                                                    <option value="air">Air</option>
                                                    <option value="surface">Surface</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Fulfilled By</label>
                                                <select name="fulfilled_account" id="fulfilled_account" class="form-control">
                                                    <option value="">Search by courier partner</option>
                                                    <?php
                                                    // $result=$this->db->query('select transitpartner_id, transitpartner_name from master_transit_partners MTP JOIN master_transitpartners_accounts MTPA on MTP.transitpartner_id = MTPA.parent_id where account_id in (select DISTINCT priority_1 from ( select `priority_1` from users_courier_priority union all select `priority_2` from users_courier_priority union all select `priority_3` from users_courier_priority) m)');

                                                    $result = $this->db->select('account_id,account_name')->get('master_transitpartners_accounts');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Status</label>
                                                <select name="user_status[]" id="user_status" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by status...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->where('status_for','User')->where_not_in('status_id','200,220,229', false)->get('shipments_status');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->status_id; ?>"><?php echo $row->status_title; ?></option>
                                                    <?php } ?>
                                                    <option value="0">Lost/Missed</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>From Order Date</label>
                                                <input type="text" id="from_date" name="from_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>To Order Date</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Date Range</label>
                                                <select class="form-control" onchange="daterange(this.value);" onfocus="this.selectedIndex = 0;">
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
                                <h2>View <strong>All Shipments</strong></h2>
                                <div class="block-options pull-right">
                                    <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-file-excel-o"></i> Export</button></a>
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

                $('#from_date').datepicker('setDate', 'now');
                $('#to_date').datepicker('setDate', 'now');
                search_data("form_searchshipments","<?= base_url();?>actionsearch/search_shipments/0");
            });

            $('#searchbtn').on('click', function()
            {
                // $("#user_status").val($("#status").val());
                search_data("form_searchshipments","<?= base_url();?>actionsearch/search_shipments/0");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_searchshipments').submit();
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchshipments","<?= base_url();?>actionsearch/search_shipments/"+(page-1)*100);
            });

        </script>

    </body>
</html>