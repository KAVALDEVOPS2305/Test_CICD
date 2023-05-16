<?php
$page_id = 'view_cods';
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
                                            Billing<br><small>View CODs</small>
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
                            <li><a href="javascript:;">View CODs</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark-default">
                                        <h2 style="color: white;">Search/View <strong>CODs</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_viewcods" action="<?php echo base_url('Actionexport/searched_cods')?>" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Business Name</label>
                                                <input type="text" id="business_name" name="business_name" class="form-control autocomplete-businessname" placeholder="Search by business...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>COD TRN</label>
                                                <input type="text" id="cod_id" name="cod_id" class="form-control" placeholder="Search by COD #...">
                                            </div> 
                                            
                                            <div class="col-md-3">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" placeholder="Search by username...">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label>Is COD Adjust?</label>
                                                <select name="codadjust" id="codadjust" class="form-control">
                                                    <option value="">Select to Search</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
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
                                                <label>COD Status</label>
                                                <select name="cod_status" id="cod_status" class="form-control">
                                                    <option value="">Search by status</option>
                                                    <option value="3">Pending (Accrue)</option>
                                                    <option value="0">Generated</option>
                                                    <option value="1">Remitted</option>
                                                    <option value="2">Adjusted</option>
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
                                                    <option value="7">Future CODs</option>
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
                                <h2>View <strong>CODs</strong></h2>

                                <div class="block-options pull-right">
                                <button type="button" class="btn btn-sm btn-warning" id="btn_exportexcel" data-toggle="tooltip" title data-original-title="Export Excel"><i class="fa fa-file-excel-o"></i> Export</button>

                                <button type="button" class="btn btn-sm btn-info" id="btn_exportall" data-toggle="tooltip" title data-original-title="Export All COD"><i class="fa fa-file-excel-o"></i> Export All CODs</button>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata"></div>
                        </div>

                        <!-- Remit Modal -->
                        <div id="modal-remit" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Add Remit</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_remit" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="action_amount">Amount<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="action_amount" name="action_amount" class="form-control" placeholder="Enter amount...">
                                                </div>                                           
                                                <label class="col-md-1 control-label" for="action_date">Date<span class="text-danger">*</span></label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" name="action_date" id="action_date" placeholder="dd-mm-yyyy" required>              
                                                </div>                                                
                                            </div>
                                            <input type="hidden" id="cid" name="cid" />
                                            <input type="hidden" id="userid" name="userid" />
                                            <input type="hidden" id="action_amount_check" name="action_amount_check" />                                           
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="action_against">UTR #<span class="text-danger">*</span></label>
                                                <div class="col-md-10">
                                                    <input type="text" id="action_against" name="action_against" class="form-control" placeholder="Enter UTR #...">
                                                </div>                                              
                                            </div>
                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    <!-- <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button> -->
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Remit Modal -->

                        <!-- Bulk Remit COD Modal -->
                        <div id="modal-bulk" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Add Bulk Remit CODs</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" enctype="multipart/form-data" id="form_bulk_remit" class="form-horizontal form-bordered" action="<?php echo base_url('Actioninsert/bulk_remit_cods')?>">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="bulk_excel">Bulk COD</label>
                                                <div class="col-md-6">
                                                    <input type="file" id="bulk_excel" name="bulk_excel" class="form-control" accept=".csv" required>
                                                </div>
                                                <label class="col-md-4 control-label" style="text-align: left; margin-top: -15px;">
                                                <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                <a href="<?= base_url("assets/samples/Sample-Bulk_Remit_COD.csv")?>" download>Download Sample</a>
                                            </label>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebulk"><i class="fa fa-save"></i> Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Bulk Remit COD Modal -->
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
                search_sum_data("form_viewcods","<?= base_url();?>actionsearch/search_cods/0");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_viewcods').submit();
            });

            $('#btn_exportall').on('click', function(e)
            {
                var from_date   = $("#from_date").val();
                var to_date     = $("#to_date").val();
                window.open('<?= base_url();?>Actionexport/export_all_cods_awbs?from_date='+from_date+'&to_date='+to_date);
            });

            function getcod_data(cod_id, user_id)
            {
                var postData = {cod_id:cod_id,user_id:user_id};
                $.ajax({
                    url: "<?= base_url();?>actiongetdata/get_coddata",
                    type: "POST",
                    data: postData,
                    dataType:"json",
                    success: function(codData) 
                    {
                        var due_amt = parseFloat(codData.cod_amount) - (parseFloat(codData.total_remitted) + parseFloat(codData.total_adjusted));
                        $('#action_date').datepicker('setDate', 'now');
                        $('#cid').val(codData.cod_id);
                        $('#userid').val(codData.user_id);
                        $('#action_amount').val(due_amt);
                        $('#action_amount_check').val(due_amt);
                    }
                });
            }

            $('#form_remit').on('submit', function(e)
            {
                if($("#form_remit").valid())
                {  
                    $('#savebtn').prop('disabled', true);
                    ins_data("form_remit","<?= base_url();?>actioninsert/remit_cods");
                }
                else
                    e.preventDefault();        
            });

            $('#modal-remit').on('hidden.bs.modal', function (e)
            {
                $('#form_remit')[0].reset();
                $('#savebtn').prop('disabled', false);
                search_data("form_viewcods","<?= base_url();?>actionsearch/search_cods/0");
            });

            // $('#form_bulk_remit').on('submit', function(e)
            // {
            //     if($("#form_bulk_remit").valid())
            //     {
            //         var data = new FormData(this);
            //         upload_data("form_bulk_remit","<?= base_url();?>actioninsert/bulk_remit_cods",data);
            //     }
            //     else
            //         e.preventDefault();
            // });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_viewcods","<?= base_url();?>actionsearch/search_cods/"+(page-1)*100);
            });
        </script>
    </body>
</html>