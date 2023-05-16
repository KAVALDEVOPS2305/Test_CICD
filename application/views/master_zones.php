<?php
$page_id = 'master_zones';
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
                                    <i class="fa fa-globe"></i>Manage Zones<br><small>Add, Edit zone matrix</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Master</li>
                            <li><a href="master_zones">Zone Matrix</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>Zone</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="#modal-add" data-id="" data-toggle="modal" title="Add/Upload Zone" data-original-title="Add/Upload Zone" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Add Zones</a>
                                        </div>
                                        
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchzone" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="source_city">Source City</label>
                                            <div class="col-md-4">
                                                <input type="text" id="source_city" name="source_city" class="form-control" placeholder="Search using city name...">
                                            </div>

                                            <label class="col-md-2 control-label" for="destination_pin">Destination Pincode</label>
                                            <div class="col-md-4">
                                                <input type="text" id="destination_pin" name="destination_pin" class="form-control" placeholder="Search destination pin...">
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
                            <div class="block-title" style="margin-bottom: 0px;">
                                <h2>Manage <strong>Zones</strong></h2>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata">
                                
                            </div>
                        </div>



                        <!-- Update Modal -->
                        <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Update Zone</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_updatezone" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="component-group">
                                                    <label class="col-md-1 control-label" for="f_source">Source<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <input type="text" id="f_source" name="f_source" class="form-control" placeholder="Enter source...">
                                                    </div>
                                                </div>
                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="f_destination_pin">Destination Pin<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <input type="text" id="f_destination_pin" name="f_destination_pin" class="form-control" placeholder="Enter Pin..." minlength="6" maxlength="6">
                                                    </div>
                                                </div>

                                                <input type="hidden" id="cid" name="cid" />
                                                <div class="component-group">
                                                    <label class="col-md-1 control-label" for="f_zone">Zone<span class="text-danger">*</span></label>
                                                    <div class="col-md-2">
                                                        <input type="text" id="f_zone" name="f_zone" class="form-control" placeholder="Enter zone...">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-1">
                                                    <button type="submit" class="btn btn-sm btn-warning" id="updatebtn"><i class="fa fa-edit"></i> Update</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Update Modal -->


                        <!-- Add Modal -->
                        <div id="modal-add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Add/Upload Zone</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_addzone" class="form-horizontal form-bordered" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="component-group">
                                                    <label class="col-md-3 control-label" for="zone_file">Upload Zone Excel<span class="text-danger">*</span></label>
                                                    <div class="col-md-4">
                                                        <input type="file" class="form-control" id="zone_file" name="zone_file" accept=".csv">
                                                        <span class="help-block">Upload CSV format file only.</span>
                                                    </div>
                                                </div>


                                                <label class="col-md-5 control-label" style="text-align: left; margin-top: -15px;">
                                                    <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="<?= base_url("assets/samples/Sample-ZoneFile.csv")?>" download>Download Sample</a>
                                                </label>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-1">
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
                        <!-- END Add Modal -->


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
                        <!-- END Add Modal -->

                    </div>
                    <!-- END Error Preview Content -->

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

            $('#form_addzone').on('submit', function(e)
            {
                var data = new FormData(this);
                if($("#form_addzone").valid()) {
                    $('#savebtn').prop('disabled', true);
                    review_data("form_addzone","<?= base_url();?>actioninsert/preview_zones",data);
                }
                else
                    e.preventDefault();
            });

            $('#form_updatezone').on('submit', function(e)
            {
                if($("#form_updatezone").valid() && $('#cid').val()) {
                    $('#updatebtn').prop('disabled', true);
                    update_data("form_updatezone","<?= base_url();?>actionupdate/master_zones"); 
                }
                else
                    e.preventDefault();
            });

            $('#form_searchzone').on('submit', function(e)
            {
                search_data("form_searchzone","<?= base_url();?>actionsearch/search_zones/0");
            });

            function reupload() {
                $('#modal-preview').modal('hide');
                $('#modal-add').modal('show');
                $('#savebtn').prop('disabled', false);
            }

            function saveanyway() {
                if($("#form_savezonesanyway").valid()) {
                    $('#continuebtn').prop('disabled', true);
                    ins_data("form_savezonesanyway","<?= base_url();?>actioninsert/master_zones");
                }
                else
                    e.preventDefault();
            }

            function getedit_data(rowid)
            {
                // alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/master_zones",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);
                        $('#modal-edit').modal('show'); 
                        $("#cid").val(r[0].trim());
                        $("#f_source").val(r[1].trim());
                        $("#f_destination_pin").val(r[2].trim());
                        $("#f_zone").val(r[3]).trim();
                        $("#f_source").focus();
                    }
                });
            }

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchzone","<?= base_url();?>actionsearch/search_zones/"+(page-1)*100);
            });
        </script>

    </body>
</html>