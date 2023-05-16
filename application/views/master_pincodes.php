<?php
$page_id = 'master_pincodes';
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
                        <!-- Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-map-marker"></i>Manage Pincodes<br><small>Add, Edit master pincode list</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Master</li>
                            <li><a href="javascript:void();">Pincodes</a></li>
                        </ul>
                        <!-- END Header -->


                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Search <strong>Pincodes</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="#modal-add-edit" data-id="" data-toggle="modal" title="Add pincode" data-original-title="Add pincode" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Add Pincode</a>
                                        </div>
                                        <div class="block-options pull-right">
                                            <a href="#modal-add-bulk" data-id="" data-toggle="modal" title="Add bulk pincode" data-original-title="Add bulk pincode" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Add Bulk Pincode</a>
                                        </div>
                                        
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchpin" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-1 control-label" for="pincode">Pincode</label>
                                            <div class="col-md-3">
                                                <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Search using pincode...">
                                            </div>

                                            <label class="col-md-1 control-label" for="pin_city">City</label>
                                            <div class="col-md-3">
                                                <input type="text" id="pin_city" name="pin_city" class="form-control" placeholder="Search using city...">
                                            </div>

                                            <label class="col-md-1 control-label" for="pin_state">State</label>
                                            <div class="col-md-3">
                                                <select name="pin_state" id="pin_state" class="select-select2 form-control" style="width: 100%;" data-placeholder="Search using state...">
                                                    <option></option>
                                                    <?php     
                                                    $result=$this->db->order_by('state_name', 'ASC')->get('tbl_state');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo strtoupper($row->state_name); ?>"><?php echo $row->state_name; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-1">
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
                            <div class="block-title themed-background-dark-fancy" style="margin-bottom: 0px;">
                                <h2 style="color: #fff;">Manage <strong>Pincodes</strong></h2>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata">
                                
                            </div>
                        </div>                       

                        <!-- Pincode Add/Update Modal -->
                        <div id="modal-add-edit" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Add/Update Pincode</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_pincode" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="f_pincode">Pincode<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="f_pincode" name="f_pincode" class="form-control" placeholder="Enter pincode..." minlength="6" maxlength="6">
                                                </div>

                                                <label class="col-md-1 control-label" for="f_pin_city">City<span class="text-danger">*</span></label>
                                                <div class="col-md-5">
                                                    <input type="text" id="f_pin_city" name="f_pin_city" class="form-control" placeholder="Enter city...">
                                                </div>
                                            </div>

                                            <input type="hidden" id="cid" name="cid" />

                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="f_pin_state">State<span class="text-danger">*</span></label>
                                                <div class="col-md-10">
                                                    <select name="f_pin_state" id="f_pin_state" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select state...">
                                                        <option></option>
                                                        <?php     
                                                        $result=$this->db->order_by('state_name', 'ASC')->get('tbl_state');
                                                        // print_r($this->db->last_query());
                                                        foreach($result->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo strtoupper($row->state_name); ?>"><?php echo $row->state_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    
                                                    <button type="submit" style="display: none;" class="btn btn-sm btn-warning" id="updatebtn"><i class="fa fa-edit"></i> Update</button>
                                                    
                                                    <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="modal-add-bulk" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Bulk Pincodes</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_pincode_excel" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label>Upload Pincodes<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="pincodes_file" name="pincodes_file" accept=".csv" required="">
                                                    <span class="help-block">Upload CSV format file only.</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>
                                                        <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="<?= base_url("assets/samples/Sample-PincodeList.csv")?>" download>Download Sample</a>
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
        <script src="<?= base_url();?>assets/js/pages/formsGeneral.js"></script>
        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                FormsGeneral.init();
                TablesDatatables.init();
            });

            $('#form_pincode').on('submit', function(e)
            {
                if($("#form_pincode").valid())
                {
                    if($('#cid').val()) {
                        $('#updatebtn').prop('disabled', true);
                        update_data("form_pincode","<?= base_url();?>actionupdate/master_pincodes"); 
                    }
                    else {
                        $('#savebtn').prop('disabled', true);
                        ins_data("form_pincode","<?= base_url();?>actioninsert/master_pincodes");
                    }
                }
                else
                    e.preventDefault();        
            });

            $('#form_pincode_excel').on('submit', function(e)
            {
                if($("#form_pincode_excel").valid())
                {
                    var data = new FormData(this);
                    upload_data("form_pincode_excel","<?= base_url();?>actioninsert/bulk_master_pincodes",data);
                }
                else
                    e.preventDefault();
            });

            $('#form_searchpin').on('submit', function(e)
            {
                search_data("form_searchpin","<?= base_url();?>actionsearch/search_pincodes/0");
            });

            function getedit_data(rowid)
            {
                // alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/master_pincodes",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtn").show();
                        
                        $("#cid").val(r[0].trim());
                        $("#f_pincode").val(r[1].trim());
                        $("#f_pin_city").val(r[2].trim());
                        $("#f_pin_state").val(r[3]).trigger('change');

                        $("#savebtn").hide();
                        $("#resetbtn").hide();
                        $("#f_pincode").focus();
                    }
                });
            }

            $('#modal-add-edit').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).attr('data-id');
                // alert(rowid);
                if(rowid!='')
                {
                    // alert('update');
                    getedit_data(rowid);
                }
                else
                {
                    $('#cid').val('');
                    $("#updatebtn").hide();
                    $("#savebtn").show();
                    $("#resetbtn").show();
                    $("#f_pin_state").val('').trigger('change');
                    $('#resetbtn').trigger("click");
                }
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchpin","<?= base_url();?>actionsearch/search_pincodes/"+(page-1)*100);
            });
        </script>

    </body>
</html>