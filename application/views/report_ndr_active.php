<?php
$page_id = 'report_ndr_active';
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
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Report</li>
                            <li><a href="javascript:void">NDR</a></li>
                        </ul>
                        <!-- END Validation Header -->
                        <div class="row">
                            <!-- Settings Tabs -->
                            <?php require_once('tabs-ndr.php'); ?>
                            <!-- END Settings Tabs -->
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Search <strong>NDR Shipments</strong></h2>
                                        <!-- <div class="block-options pull-right">
                                            <a href="javascript:void;"><button type="button" class="btn btn-sm btn-warning" id="btn_ndrupload"><i class="fa fa-upload"></i> Bulk NDR Upload</button></a>
                                        </div> -->
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchactivendrshipments" action="<?php echo base_url('Actionexport/reports_ndr')?>" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                                <select name="user_id[]" id="user_id" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by username...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->get('users');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->user_id; ?>"><?php echo $row->username; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>AWB #</label>
                                                <input type="text" id="waybill_number" name="waybill_number" class="form-control" placeholder="Search using AWB...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Order Id</label>
                                                <input type="text" id="shipment_id" name="shipment_id" class="form-control" placeholder="Search using order id...">
                                            </div>
                                        </div>
                                        <input type="hidden" name="ndr_status" value="1">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>NDR Reason</label>
                                                <select name="ndr_status_id[]" id="ndr_status_id" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by NDR Reason...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->get('ndr_status');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->ndr_status_id; ?>"><?php echo $row->status_remark; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Fulfilled By</label>
                                                <select name="fulfilled_by[]" id="fulfilled_by" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by courier partner...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->query('select transitpartner_id, transitpartner_name from master_transit_partners');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->transitpartner_id; ?>"><?php echo $row->transitpartner_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Fulfilled Account</label>
                                                <select name="fulfilled_account[]" id="fulfilled_account" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by courier partner name...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->query('select account_id, account_name from master_transitpartners_accounts');
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
                                                <label>Payment Mode</label>
                                                <select name="payment_mode" id="payment_mode" class="form-control">
                                                    <option value="">Search by Mode</option>
                                                    <option value="COD">COD</option>
                                                    <option value="PPD">Prepaid</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Action-Date from</label>
                                                <input type="text" id="from_date" name="from_date"  class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 00:00:00" placeholder="dd-mm-yyyy hh:mm:ss">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Action-Date to</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 23:59:59" placeholder="dd-mm-yyyy hh:mm:ss">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Date Range</label>
                                                <select class="form-control" id="date_range" onchange="datetimerange(this.value);">
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
                            <div class="block-title" style="margin-bottom: 0px;">
                                <h2>View <strong>NDR Shipments</strong></h2>
                                <div class="block-options pull-right">
                                    <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-file-excel-o"></i> Export</button></a>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata"></div>
                        </div>

                        <!-- Reschedule Modal -->
                        <div id="modal-reschedule" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Re-Schedule Shipment</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_ndr_reschedule" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="waybill_num">Waybill Number</label>
                                                <div class="col-md-8">
                                                    <label class="col-md-4 control-label" id="waybill_num"></label>
                                                    <input type="hidden" id="waybill_number_modal" name="waybill_num" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="future_delivery">Re-schedule On<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" name="future_delivery" id="future_delivery" placeholder="dd-mm-yyyy" required>
                                                </div>                                                
                                            </div>
                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    <!-- <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button> 
                                                    onclick="" -->
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Reschedule Modal -->

                        <!-- Edit Details Modal -->
                        <div id="modal-update" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Update Shipment Details</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_ndr_updatedetails" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="updt_modal_waybill_num">Waybill Number<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" id="updt_modal_waybill_number" name="updt_modal_waybill_number" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="consignee_name">Consignee Name<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="consignee_name" id="consignee_name" placeholder="Consignee Name" required>
                                                </div>                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="consignee_phone">Consignee Phone<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="consignee_phone" id="consignee_phone" placeholder="Consignee Phone" required>
                                                </div>                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="consignee_address">Consignee Address<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea type="text" class="form-control" name="consignee_address" id="consignee_address" placeholder="Consignee Address" required></textarea>

                                                    <input type="hidden" class="form-control" name="consignee_pincode" id="consignee_pincode">
                                                </div>                                                
                                            </div>
                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-4">
                                                    <button type="submit" class="btn btn-sm btn-warning" id="updatebtn"><i class="fa fa-pencil"></i> Update</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Edit Details Modal -->
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
        <script src="<?= base_url();?>assets/js/ndrjs.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();

                $('#from_date').val(moment().format('DD-MM-YYYY 00:00:00'));
                $('#to_date').val(moment().format('DD-MM-YYYY 23:59:59'));

                search_data("form_searchactivendrshipments","<?= base_url();?>actionsearch/search_active_ndrshipments/0");
            });

            $('#searchbtn').on('click', function()
            {
                search_data("form_searchactivendrshipments","<?= base_url();?>actionsearch/search_active_ndrshipments/0");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_searchactivendrshipments').submit();
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchactivendrshipments","<?= base_url();?>actionsearch/search_active_ndrshipments/"+(page-1)*1000);
            });

            $('#modal-reschedule').on('show.bs.modal', function (e) {
                var waybill = $(e.relatedTarget).attr('data-awbn');
                $("#waybill_num").html(waybill);
            });

            $('#form_ndr_reschedule').on('submit', function(e)
            {
                $("#waybill_number_modal").val($("#waybill_num").html());
                reschedule("form_ndr_reschedule",$("#waybill_number_modal").val());
                $('#modal-reschedule').modal('toggle');
            });

            $('#modal-update').on('show.bs.modal', function (e) {
                var waybill = $(e.relatedTarget).attr('data-wbn');
                var name = $(e.relatedTarget).attr('data-name');
                var phone = $(e.relatedTarget).attr('data-phone');
                var add = $(e.relatedTarget).attr('data-add');
                var pincode = $(e.relatedTarget).attr('data-pin');
                
                $("#updt_modal_waybill_number").val(waybill);
                $("#consignee_name").val(name);
                $("#consignee_phone").val(phone);
                $("#consignee_address").val(add);
                $("#consignee_pincode").val(pincode);
            });

            $('#form_ndr_updatedetails').on('submit', function(e)
            {
                updatedetails("form_ndr_updatedetails",$("#waybill_number_modal").val());
                $('#modal-update').modal('toggle');
            });

        </script>

    </body>
</html>