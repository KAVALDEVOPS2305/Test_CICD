<?php
$page_id = 'user_weight_request';
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
                            <li>Billing</li>
                            <li><a href="javascript:void">Manage Weight Requests</a></li>
                        </ul>
                        <!-- END Validation Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Search <strong>User's Weight Request</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary" data-toggle="block-toggle-content"><i class="fa fa-arrows-v"></i></a>
                                            <!-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary" data-toggle="block-hide"><i class="fa fa-times"></i></a> -->
                                        </div>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <div id="spinner" class="text-center" style="display: none;">
                                        <i class="fa fa-spinner fa-3x fa-spin"></i><br/>Processing Request...
                                    </div>
                                    <div class="block-content">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_userweight_request" class="form-horizontal form-bordered" action="<?php echo base_url('Actionexport/weight_request')?>">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label>Username</label>
                                                    <input type="text" id="username" name="username" class="form-control autocomplete-username" placeholder="Search by username....">
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Waybill Number</label>
                                                    <input type="text" id="waybill_number" name="waybill_number" class="form-control" placeholder="Search by AWB...">
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Request Status</label>
                                                    <select name="request_status[]" id="request_status" class="select-chosen form-control" style="width: 100%;" data-placeholder="All" multiple>
                                                        <option value="0">Pending</option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Rejected</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label>Request-Date from</label>
                                                    <input type="text" id="from_date" name="from_date"  class="form-control datetimepicker" data-date-format="dd-mm-yyyy 00:00:00" placeholder="dd-mm-yyyy hh:ii:ss">
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Request-Date to</label>
                                                    <input type="text" id="to_date" name="to_date" class="form-control datetimepicker" data-date-format="dd-mm-yyyy 23:59:59" placeholder="dd-mm-yyyy hh:mm:ss">
                                                </div>

                                                <div class="col-md-4">
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
                                </div>
                                <!-- END Horizontal Form Block -->
                            </div>
                        </div>

                        <div class="block full" id="table-div">
                            <div class="block-title themed-background-dark">
                                <h2 style="color: #fff;"><strong>Manage Weight Requests</strong></h2>
                                <div class="block-options pull-right">
                                    <a href="javascript:void(0)" id="block-toggle-fullscreen" class="btn btn-alt btn-sm btn-primary" title="Enlarge to FullScreen" data-placement="top" data-toggle="tooltip"><i class="fa fa-desktop"></i></a>

                                    <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-file-excel-o"></i> Export</button></a>
                                    <a href="#modal-add-bulk" data-id="" data-toggle="modal" title="Add bulk pincode" data-original-title="Add bulk pincode" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Update Bulk Request</a>

                                    <button type="button" class="btn btn-sm btn-success" id="btn_bulkprocess" style="display: none;"><i class="fa fa-check"></i> Approve</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="btn_bulkprocessreject" style="display: none;"><i class="fa fa-ban"></i> Reject</button>
                                </div>

                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alert" style="display:none;">
                                <button type="button" class="close" style="color:#000;" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5 style="margin: 0px;" id="alert_message">

                                </h5>
                            </div>
                            <form method="post" id="excel_error" style="display: none;" action="<?php echo base_url('Actionexport/request_weight_update_errordownload')?>" enctype="multipart/form-data">
                            </form>


                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata"></div>
                        </div>

                        <!-- Bulk Request update model open -->
                        <div id="modal-add-bulk" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Bulk Request Upadte</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_request_excel" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label>Upload Request<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="requestweight_file" name="requestweight_file" accept=".csv" required="">
                                                    <span class="help-block">Upload CSV format file only.</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>
                                                        <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="<?= base_url("assets/samples/Sample-RequestWeight.csv")?>" download>Download Sample</a>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>

                                                    <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Add/Update Modal -->
                        <!-- bulk request update model close-->


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

                        <!-- Cancel Order Modal -->
                        <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3 class="modal-title">Please confirm?</h3>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to reject this request? This action is irreversible.
                                    </div>

                                    <div id="add_loaderreject" style="margin-top: 0px; padding-left: 130px; margin-bottom: 10px; display: none;">
                                        <i class="fa fa-spinner fa-2x fa-spin"></i><br/>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <input type="hidden" name="userrequestid" id="userrequestid">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">No</button>
                                        <button type="button" onclick="single_process(document.getElementById('userrequestid').value,'<?= base_url();?>Actionupdate/single_update_request','reject')" class="btn btn-sm btn-primary">Yes, Cancel.</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Cancel Order Modal -->

                        <!-- Cancel Order Modal -->
                        <div id="modal-approve" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3 class="modal-title">Please confirm?</h3>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to approve this request? This action is irreversible.
                                    </div>
                                    <div id="add_loaderapprove" style="margin-top: 0px; padding-left: 130px; margin-bottom: 10px; display: none;">
                                        <i class="fa fa-spinner fa-2x fa-spin"></i><br/>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="requestid" id="requestid">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">No</button>
                                        <button type="button" onclick="single_process(document.getElementById('requestid').value,'<?= base_url();?>Actionupdate/single_update_request','approve')" class="btn btn-sm btn-primary">Yes, Approve.</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Cancel Order Modal -->
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

                $('#from_date').val(moment().format('DD-MM-YYYY 00:00:00'));
                $('#to_date').val(moment().format('DD-MM-YYYY 23:59:59'));
                $('#order_status').val("0").trigger('chosen:updated');
                search_data("form_userweight_request","<?= base_url();?>actionsearch/search_users_weight_request/0");
            });


            $(document).on("change", "thead input[type='checkbox']", function () {
                var checkedStatus   = $(this).prop('checked');
                var table           = $(this).closest('table');
                $('tbody input:checkbox', table).each(function() {
                    $(this).prop('checked', checkedStatus);
                });
            });

            $(document).on("change", "input[type='checkbox']", function () {
                if($("#form_bulkprocess input:checkbox:checked").length){
                    $("#btn_bulkprocess").show();
                    $("#btn_bulkprocessreject").show();
                }
                else
                {
                    $("#btn_bulkprocess").hide();
                    $("#btn_bulkprocessreject").hide();
                }
            });

            $('#searchbtn').on('click', function()
            {
                search_data("form_userweight_request","<?= base_url();?>actionsearch/search_users_weight_request/0");
            });

            $('#btn_reset').click(function() {
                $("#order_status").val('').trigger("chosen:updated");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_userweight_request').submit();
                setTimeout(function(){$("#searchbtn").click();}, 5000);
            });

            //bulk reject process
            $('#btn_bulkprocessreject').on('click', function(e)
            {
                bulk_process("form_bulkprocess","<?= base_url();?>actionupdate/bulk_approve_update_request","reject");
            });

            //bulk approve process
            $('#btn_bulkprocess').on('click', function(e)
            {
                bulk_process("form_bulkprocess","<?= base_url();?>actionupdate/bulk_approve_update_request","approve");
            });

            $('#modal-confirm').on('show.bs.modal', function (e) {
                var userrequestid = $(e.relatedTarget).attr('data-id');
                $('#userrequestid').val(userrequestid);
            });

            $('#modal-approve').on('show.bs.modal', function (e) {
                var userrequestid = $(e.relatedTarget).attr('data-id');
                $('#requestid').val(userrequestid);
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_userweight_request","<?= base_url();?>actionsearch/search_users_weight_request/"+(page-1)*1000);
            });

            $(window).scroll(function()
            {
                if($(document).scrollTop() > 600)
                {
                    $("#btn_bulkprocessreject").css({"position":"fixed", "top":"10%", "right":"2%"});
                    $("#btn_bulkprocess").css({"position":"fixed", "top":"10%", "right":"8%"});
                    $("#spinner").css({"position":"fixed", "top":"50%", "right":"40%"});
                }
                else
                {
                    $("#btn_bulkprocessreject").css({"position":"", "top":"", "right":""});
                    $("#btn_bulkprocess").css({"position":"", "top":"", "right":""});
                    $("#spinner").css({"position":"fixed", "top":"50%", "right":"40%"});
                }

            });
        </script>

        <script>
            $('#form_request_excel').on('submit', function(e)
            {
                if($("#form_request_excel").valid())
                {
                    var data = new FormData(this);
                    // review_excelupWeightRequest("form_request_excel","<?= base_url();?>actioninsert/bulk_request_updates",data);
                    review_excelupdate("form_request_excel","<?= base_url();?>actionupdate/bulk_request_updates",data);
                    $('#modal-add-bulk').modal('hide');
                    $('#searchbtn').trigger("click");
                    
                }
                else
                    e.preventDefault();
            });

            function saveanyway() {
                if($("#form_weightupdateanyway").valid())
                {
                    $('#continuebtn').prop('disabled', true);
                    // excel_weight_update_request("form_weightupdateanyway","<?= base_url();?>actioninsert/excelUpdateRequestWeight");
                    excel_update("form_weightupdateanyway","<?= base_url();?>actionupdate/excelUpdateRequestWeight");
                    $('#modal-add-bulk').modal('hide');
                    $('#searchbtn').trigger("click");
                }
                else
                    e.preventDefault();
            }

            $(document).on('click',"#btn_downloaderror",function(){
                $("#excel_error").submit();
            });

            function reupload() {
                $('#modal-preview').modal('hide');
                $('#savebtn').prop('disabled', false);
            }

            /**
             * Author   : Kamlesh
             * Date     : 13/02/2023
             * Purpose  : bulk process or checkbox process (update weight and reject weight)
            **/
            function bulk_process(formid,url,type)
            {

            var data = $('#'+formid).serialize();
            data += '&process_type='+type;

            $.ajax({
                url: url,
                type: "POST",
                data : data,
                dataType: 'json',
                beforeSend: function()
                {
                    $('#spinner').show();
                },
                complete: function()
                {
                    $('#spinner').hide();
                },
                success: function(response)
                {
                if(response.error)
                {
                    $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                    type: 'danger',
                    delay: 3500,
                    allow_dismiss: true
                    });
                }
                else
                {
                    $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                    type: 'success',
                    delay: 2500,
                    allow_dismiss: true
                    });
                    setTimeout(function(){$("#searchbtn").click();}, 3000);
                }
                }
            });
            }

            /**
             * Author   : Kamlesh
             * Date     : 13/02/2023
             * Purpose  : This function used for reject and approve single user request
            **/
            function single_process(row_id,url,type)
            {

                $.ajax({
                url: url,
                type: "POST",
                data : {'id' : row_id ,'process_type' : type},
                dataType: 'json',
                beforeSend: function(){
                    $('#add_loader'+type).show();
                },
                complete: function(){
                    $('#add_loader'+type).hide();
                },
                success: function(response)
                {
                    if(response.error)
                    {
                    $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                        type: 'danger',
                        delay: 2500,
                        allow_dismiss: true
                    });
                    //return false
                    }
                    else
                    {
                    $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                        type: 'success',
                        delay: 2500,
                        allow_dismiss: true
                    });

                    setTimeout(function(){location.reload();}, 3000);
                    }
                }
            });
            }
        </script>

    </body>
</html>