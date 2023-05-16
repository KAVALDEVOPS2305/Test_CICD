<?php
$page_id = 'admin_users';
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
                                    <i class="fa fa-user-secret"></i>Manage Sub-Admins<br><small>Add, Edit Sub-Admin to operate</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Administration</li>
                            <li><a href="admin_modules">Sub-Admins</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add/Update <strong>Sub-Admins</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_adminuser" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_name">Full Name<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="admin_name" name="admin_name" class="form-control" placeholder="Enter full name...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_phone">Contact Number<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="admin_phone" name="admin_phone" class="form-control" placeholder="Enter mobile number...">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_email">Email<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="email" id="admin_email" name="admin_email" class="form-control" placeholder="Enter email id...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_role">Role<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select name="admin_role" id="admin_role" class="select-select2 form-control" style="width: 100%;" data-placeholder="Choose role..">
                                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                        <?php     
                                                            $result=$this->db->where('role_status =','1')->order_by('role_name', 'ASC')->get('administrator_roles');
                                                            // print_r($this->db->last_query());

                                                            foreach($result->result() as $row)
                                                            {
                                                        ?>
                                                        <option value="<?php echo $row->admin_role_id; ?>"><?php echo $row->role_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <input type="hidden" id="cid" name="cid" />

                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_username">Username<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="admin_username" name="admin_username" class="form-control" placeholder="Enter username...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_password">Password<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="password" id="admin_password" name="admin_password" class="form-control" placeholder="Enter password...">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default show"><i class="fa fa-eye"></i></button>
                                                        </span>
                                                    </div>
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
                                <h2>Manage <strong>Sub-Admins</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-adminuser" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Fullname</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php     
                                    $result=$this->db->join('administrator_roles','administrator_roles.admin_role_id=admin_users.admin_role')->get('admin_users');
                                    // print_r($this->db->last_query());
                                    $i=1;
                                    foreach($result->result() as $row)
                                    {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td><?php echo $row->admin_name; ?></td>
                                            <td><?php echo $row->admin_phone; ?></td>
                                            <td><?php echo $row->admin_email; ?></td>
                                            <td><?php echo $row->admin_username; ?></td>
                                            <td><?php echo $row->role_name; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row->admin_status==1)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_uid ?>','<?php echo $row->admin_status ?>')" class="label label-success">Active</a> 

                                                <?php
                                                }
                                                else if($row->admin_status==0)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->admin_uid ?>','<?php echo $row->admin_status ?>')" class="label label-danger">In-active</a>
                                                <?php }?>


                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" onclick="getedit_data('<?php echo $row->admin_uid ?>')"><i class="fa fa-pencil"></i></a>
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

            $('#form_adminuser').on('submit', function(e)
            {
                if($("#form_adminuser").valid())
                {
                    if($('#cid').val()) {
                        $('#updatebtn').prop('disabled', true);
                        update_data("form_adminuser","<?= base_url();?>actionupdate/administrator_users");
                    } 
                    else {
                        $('#savebtn').prop('disabled', true);
                        ins_data("form_adminuser","<?= base_url();?>actioninsert/administrator_users");
                    }
                }
                else
                    e.preventDefault();        
            });

            function getedit_data(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/administrator_users",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtn").show();
                        
                        $("#cid").val(r[0].trim());
                        $("#admin_name").val(r[1].trim());
                        $("#admin_phone").val(r[2].trim());
                        $("#admin_email").val(r[3].trim());
                        $("#admin_username").val(r[4].trim());
                        $("#admin_password").val(r[5].trim());
                        $("#admin_role").val(r[6]);
                        $('#admin_role').trigger('change');

                        $("#savebtn").hide();
                        $("#resetbtn").hide();
                        $("#admin_name").focus();
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
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/administrator_users" );
            }


            $(".show").on('click',function() {
                var $pwd = $("#admin_password");
                if ($pwd.attr('type') === 'password')
                    $pwd.attr('type', 'text');
                else
                    $pwd.attr('type', 'password');
            });


        </script>

    </body>
</html>