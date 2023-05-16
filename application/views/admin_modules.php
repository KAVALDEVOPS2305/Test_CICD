<?php
$page_id = 'admin_modules';
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
                <?php require_once('sidebar-right.php'); ?>
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
                                    <i class="fa fa-cubes"></i>Manage Modules<br><small>Add, Edit Modules to operate</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Administration</li>
                            <li><a href="admin_modules">Modules</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add/Update <strong>Modules</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_adminmodule" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="module_parent">Parent<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="module_parent" name="module_parent" class="form-control" placeholder="Enter Parent menu...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="module_name">Module Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="module_name" name="module_name" class="form-control" placeholder="Enter Module Name...">
                                                </div>
                                            </div>

                                        </div>

                                        <input type="hidden" id="cid" name="cid" />

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="module_route">Module Route<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="module_route" name="module_route" class="form-control" placeholder="Enter Module Route...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label">Module Description</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="module_description" name="module_description" class="form-control" placeholder="Enter Description...">
                                                </div>
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
                                <!-- END Horizontal Form Block -->                                
                            </div>
                        </div>


                         <div class="block full">
                            <div class="block-title">
                                <h2>Manage <strong>Modules</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-adminmodule" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Parent</th>
                                            <th class="text-center">Module Name</th>
                                            <th class="text-center">Route</th>
                                            <th>Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php     
                                    $result=$this->db->order_by(1, 'DESC')->get('administrator_modules');
                                    // print_r($this->db->last_query());
                                    $i=1;
                                    foreach($result->result() as $row)
                                    {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td><?php echo $row->parent_menu; ?></td>
                                            <td><?php echo $row->module_name; ?></td>
                                            <td><?php echo $row->module_route; ?></td>
                                            <td><?php echo $row->module_description; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row->module_status==1)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_module_id ?>','<?php echo $row->module_status ?>')" class="label label-success">Active</a> 

                                                <?php
                                                }
                                                else if($row->module_status==0)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_module_id ?>','<?php echo $row->module_status ?>')" class="label label-danger">In-active</a>
                                                <?php }?>


                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" onclick="getedit_data('<?php echo $row->admin_module_id ?>')"><i class="fa fa-pencil"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
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
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_adminmodule').on('submit', function(e)
            {
                if($("#form_adminmodule").valid())
                {
                    if($('#cid').val()) {
                        $('#updatebtn').prop('disabled', true);
                        update_data("form_adminmodule","<?= base_url();?>actionupdate/administrator_modules"); 
                    }
                    else {
                        $('#savebtn').prop('disabled', true);
                        ins_data("form_adminmodule","<?= base_url();?>actioninsert/administrator_modules");
                    }
                }
                else
                    e.preventDefault();        
            });

            function getedit_data(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/administrator_modules",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtn").show();
                        
                        $("#cid").val(r[0].trim());
                        $("#module_parent").val(r[1].trim());
                        $("#module_name").val(r[2].trim());
                        $("#module_route").val(r[3].trim());
                        $("#module_description").val(r[4].trim());
                        $("#savebtn").hide();
                        $("#resetbtn").hide();
                        $("#module_name").focus();
                    }
                });
            }

            function changestatus(row_id,curr_status)
            {
                var new_status;
                //alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                    new_status='0';
                else if (curr_status=='0')
                    new_status='1';
                //alert(nst);
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/administrator_modules" );
            }
        </script>

    </body>
</html>