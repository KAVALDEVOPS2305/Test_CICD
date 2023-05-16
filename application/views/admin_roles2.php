<?php
$page_id = 'admin_roles';
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
                                    <i class="fa fa-address-card"></i>Manage Roles<br><small>Add, Edit Roles to operate</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Administration</li>
                            <li><a href="admin_roles">Roles</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add/Update <strong>Roles</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_adminrole" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="role_name">Role Name<span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="role_name" name="role_name" class="form-control" placeholder="Enter Role name...">
                                            </div>

                                            <input type="hidden" id="cid" name="cid" />

                                            <label class="col-md-2 control-label">Role Description</label>
                                            <div class="col-md-4">
                                                <input type="text" id="role_description" name="role_description" class="form-control" placeholder="Enter Description...">
                                            </div>

                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save" id="save"></i> Submit</button>
                                                <button type="submit" style="display: none;" class="btn btn-sm btn-warning"><i class="fa fa-edit" id="update"></i> Update</button>
                                                <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat" id="resetbtn"></i> Reset</button>
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
                                <h2><strong>Datatables</strong> integration</h2>
                            </div>
                            

                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Role</th>
                                            <th>Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                     <?php     
                                    $result=$this->db->where('role_status !=','2')->order_by(1, 'DESC')->get('administrator_roles');

                                    // $query = $this->db->select()->from('administrator_roles')->where('role_name', 'text')->limit(1)->get();
                                    print_r($this->db->last_query());
                                    $i=1;
                                    foreach($result->result() as $row)
                                    {
                                    ?>

                                        <tr>
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td class="text-center"><?php echo $row->role_name; ?></td>
                                            <td><?php echo $row->role_description; ?></td>
                                            <td>
                                                <?php
                                                    if($row->role_status==1)
                                                    {
                                                    ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_role_id ?>','<?php echo $row->role_status ?>')" class="label label-success">Active</a> 

                                                    <?php
                                                    }
                                                    else if($row->role_status==0)
                                                    {
                                                    ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_role_id ?>','<?php echo $row->role_status ?>')" class="label label-danger">In-active</a>
                                                <?php }?></td>
                                            <td><span class="label label-info">Business</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
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


            $('#form_adminrole').on('submit', function(e)
            {
                if($("#form_adminrole").valid())
                {
                    if($('#cid').val())
                    {
                        alert("update");
                        update_data("form_adminrole","<?= base_url();?>actionupdate/college_category");   
                    }
                    else
                    {
                        alert("insert");
                        ins_data("form_adminrole","<?= base_url();?>actioninsert/administrator_roles");  
                    } 
                }
                else
                    e.preventDefault();        
            });

            

            function getedit_data(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/Get_Category",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                            
                        $("#update").show();
                        
                        $("#cid").val(r[0].trim());
                        $("#college_category_name").val(r[1]);
                        $("#college_category_icon").val(r[2]);

                        //CKEDITOR.instances['courseDetails'].setData(r[2])
                        
                        //$("#image_one").val(r[7]);
                        $("#save").hide();
                        $("#resetbtn").hide();
                        $("#college_category_name").focus();
                    }
                });
            }

            function changestatus(row_id,curr_status)
            {
                var new_status;
                //alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                {
                    new_status='0';
                }
                else if (curr_status=='0')
                {
                    new_status='1';
                }
                //alert(nst);
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/college_category" );
            }

        </script>

    </body>
</html>