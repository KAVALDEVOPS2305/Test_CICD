<?php
$page_id = 'master_pinservices';
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
                                    <i class="fa fa-map-marker"></i>Manage Pincode Services<br><small>Add, Edit pincode services</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Master</li>
                            <li><a href="javascript:void">Pincode Services</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Pincodes <strong>Services</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="#modal-add" data-toggle="modal" title="Add pincode" data-original-title="Add pincode" class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Add/Update Pincode services</a>
                                        </div>
                                        
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchpinservices" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="account_id">Transit Partner<span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <select name="account_id" id="account_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Transit Partner Account..." required>
                                                    <option></option>
                                                    <?php     
                                                    $result=$this->db->select('account_id,account_name')->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>

                                            <label class="col-md-2 control-label" for="pincode">Pincode</label>
                                            <div class="col-md-3">
                                                <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Search using pincode...">
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
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
                                <h2 style="color: #fff;">Pincodes<strong> Services</strong></h2>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata">
                                
                            </div>
                        </div>

                        <!-- Pin Services Add/Update Modal -->
                        <div id="modal-add" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Add/Update Pincode Services</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_pincodeservices" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="account_id">Transit Partner<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <select name="account_id" id="account_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Transit Partner..." required>
                                                            <option></option>
                                                            <?php     
                                                            $result=$this->db->select('account_id,account_name')->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                            // print_r($this->db->last_query());
                                                            foreach($result->result() as $row)
                                                            {
                                                            ?>
                                                            <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="pinservice_file">Upload Excel<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <input type="file" class="form-control" id="pinservice_file" name="pinservice_file" accept=".csv">
                                                        <span class="help-block">CSV format only.</span>
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label" style="text-align: left; margin-top: -15px;">
                                                    <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="<?= base_url("assets/samples/Sample-PinServices.csv")?>" download>Sample</a>
                                                </label>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    
                                                    <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat"></i> Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Add/Update Modal -->

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

            $('#form_pincodeservices').on('submit', function(e)
            {
                var data = new FormData(this);
                if($("#form_pincodeservices").valid())
                {
                    $('#savebtn').prop('disabled', true);
                    review_data("form_pincodeservices","<?= base_url();?>actioninsert/preview_pinservices",data);
                }
                else
                    e.preventDefault();
            });

            $('#form_searchpinservices').on('submit', function(e)
            {
                search_data("form_searchpinservices","<?= base_url();?>actionsearch/search_pinservices/0");
            });


            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchpinservices","<?= base_url();?>actionsearch/search_pinservices/"+(page-1)*100);
            });

            function reupload() {
                $('#modal-preview').modal('hide');
                $('#modal-add').modal('show');
                $('#savebtn').prop('disabled', false);
            }

            function saveanyway() {
                if($("#form_savepinservicesanyway").valid())
                {
                    $('#continuebtn').prop('disabled', true);
                    ins_data("form_savepinservicesanyway","<?= base_url();?>actioninsert/master_pinservices");
                }
                else
                    e.preventDefault();
            }
        </script>

    </body>
</html>