<?php
$page_id = 'permissions';
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
                        <!-- Header -->
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Administration</li>
                            <li><a href="javascript:void;">Permissions</a></li>
                        </ul>
                        <!-- END Header -->

                        <!-- Tabs Block -->
                        <div class="block">
                            <!-- Tabs Title -->
                            <div class="block-title">
                                <ul class="nav nav-tabs" data-toggle="tabs">
                                    <li class="active"><a href="#tab-permissions">Permissions</a></li>
                                    <li><a href="#tab-custompermissions">Custom Permissions</a></li>
                                </ul>
                            </div>
                            <!-- END Tabs Title -->

                            <!-- Tabs Content -->
                            <div class="tab-content">
                                <?php     
                                    $modules=$this->db->where('module_status','1')->order_by('admin_module_id', 'ASC')
                                    ->get('administrator_modules');

                                    // get all unique parent menu
                                    $categories = array_unique(array_map(function($val) {
                                        return $val->parent_menu;
                                    }, $modules->result()));

                                    // get only parent menu not exist in module_name column
                                    foreach($categories as $parentKay => $parentValue){
                                        if(!in_array($parentValue,array_column($modules->result(), 'module_name'))){
                                            $parent_menu[$parentKay]= $parentValue;
                                        }
                                    }
                                ?>
                                <!-- Permissions -->
                                <div class="tab-pane active" id="tab-permissions">
                                    <!-- Tab Content -->
                                    <form method="post" id="role_based_permission" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="roles_id">Select Role<span class="text-danger">*</span></label>
                                            
                                                <div class="col-md-4">
                                                    <select name="roles_id" id="roles_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Choose role..">
                                                        <option></option>
                                                            <?php     
                                                            $result=$this->db->where('role_status','1')->order_by('role_name', 'ASC')->get('administrator_roles');
                                                            foreach($result->result() as $row)
                                                            {
                                                            ?>
                                                                <option value="<?php echo $row->admin_role_id; ?>" <?php echo set_select('roles_id',$row->admin_role_id); ?>><?php echo $row->role_name; ?></option>
                                                            <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="permission_type" value="role_based_permission">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label">Access Permission</label>
                                                <div class="col-md-10" id="check_roles_id">
                                                <?php
                                                    foreach($parent_menu as $key=>$pname)
                                                    {
                                                    ?>
                                                    <div class="col-md-3">
                                                    <?php
                                                        echo '<b>'.$pname.'</b>';
                                                        foreach($modules->result() as $key => $row)
                                                        {
                                                            if($pname == $row->parent_menu)
                                                            {
                                                            ?>
                                                            <ul>
                                                                <?php
                                                                    if(in_array($row->module_name,array_column($modules->result(), 'parent_menu'))){
                                                                    echo $row->module_name;
                                                                    }else
                                                                    {?>
                                                                        <div class="checkbox">
                                                                        <label for="modules_id">
                                                                        <input type="checkbox" id="modules_id" name="modules_id[]" value="<?php echo $row->admin_module_id; ?>" <?php echo set_checkbox('modules_id', $row->admin_module_id)?>> <?php echo $row->module_name; ?>
                                                                        </label>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    foreach($modules->result() as $keyname => $keyvalue)
                                                                    {
                                                                        if($row->module_name == $keyvalue->parent_menu){?><ul>
                                                                            
                                                                            <div class="checkbox">
                                                                            <label for="modules_id">
                                                                            <input type="checkbox" id="modules_id" name="modules_id[]" value="<?php echo $keyvalue->admin_module_id; ?>" <?php echo set_checkbox('modules_id', $keyvalue->admin_module_id)?>> <?php echo $keyvalue->module_name; ?>
                                                                            </label>
                                                                            </div></ul>
                                                                        <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </ul>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="role_savebtn"><i class="fa fa-save"></i> Grant Permission</button>
                                                
                                                <!-- <button type="submit" style="display: none;" class="btn btn-sm btn-warning" id="roles_id_updatebtn"><i class="fa fa-edit"></i> Update</button> -->
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Tab Content -->                                    
                                </div>
                                <!-- END Permissions -->

                                <!-- Custom Permissions -->
                                <div class="tab-pane" id="tab-custompermissions">
                                    <!-- Tab Content -->
                                    <form method="post" id="custom_based_permission" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="admin_role">Select User<span class="text-danger">*</span></label>

                                                <div class="col-md-8">
                                                    <select name="admin_id" id="admin_id" class="select-select2 form-control" style="width: 100%;" data-placeholder="Choose user..">
                                                    <option></option>
                                                        <?php     
                                                        $result=$this->db->where('admin_status','1')->order_by('admin_name', 'ASC')->get('admin_users');
                                                        foreach($result->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->admin_uid; ?>" <?php echo set_select('admin_id',$row->admin_uid); ?>><?php echo $row->admin_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="permission_type" value="custom_based_permission">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label">Access Permission</label>
                                                <div class="col-md-10" id="check_admin_id">
                                                <?php
                                                    foreach($parent_menu as $key=>$pname)
                                                    {
                                                    ?>
                                                    <div class="col-md-3">
                                                    <?php
                                                        echo '<b>'.$pname.'</b>';
                                                        foreach($modules->result() as $key => $row)
                                                        {
                                                            if($pname == $row->parent_menu)
                                                            {
                                                            ?>
                                                            <ul>
                                                            <?php
                                                                if(in_array($row->module_name,array_column($modules->result(), 'parent_menu'))){
                                                                    echo $row->module_name;
                                                                }else
                                                                {?>
                                                                    <div class="checkbox">
                                                                        <label for="modules_id">
                                                                        <input type="checkbox" id="modules_id" name="modules_id[]" value="<?php echo $row->admin_module_id; ?>" <?php echo set_checkbox('modules_id', $row->admin_module_id)?>> <?php echo $row->module_name; ?>
                                                                        </label>
                                                                    </div>
                                                                <?php
                                                                }
                                                                foreach($modules->result() as $keyname => $keyvalue)
                                                                {
                                                                    if($row->module_name == $keyvalue->parent_menu)
                                                                    {
                                                                    ?>
                                                                    <ul>
                                                                        <div class="checkbox">
                                                                            <label for="modules_id">
                                                                            <input type="checkbox" id="modules_id" name="modules_id[]" value="<?php echo $keyvalue->admin_module_id; ?>" <?php echo set_checkbox('modules_id', $keyvalue->admin_module_id)?>> <?php echo $keyvalue->module_name; ?>
                                                                            </label>
                                                                        </div>
                                                                    </ul>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="custom_savebtn"><i class="fa fa-save"></i> Grant Permission</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Tab Content -->
                                </div>
                                <!-- END Custom Permissions -->

                            </div>
                            <!-- END Tabs Content -->
                        </div>
                        <!-- END Tabs Block -->
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

            $('#role_based_permission').on('submit', function(e)
            {
                if($("#role_based_permission").valid())
                {
                    // $('#role_savebtn').prop('disabled', true);
                    update_data("role_based_permission","<?= base_url();?>actionupdate/set_permissions");
                }
                else
                    e.preventDefault();        
            });

            $('#custom_based_permission').on('submit', function(e)
            {
                if($("#custom_based_permission").valid())
                {
                    // $('#custom_savebtn').prop('disabled', true);
                    update_data("custom_based_permission","<?= base_url();?>actionupdate/set_permissions");
                }
                else
                    e.preventDefault();        
            });

            $('#roles_id').on('change', function(e)
            {
                permissionFuction('roles_id','adminusers_roles_permissions');
            });

            $('#admin_id').on('change', function(e)
            {
                permissionFuction('admin_id','adminusers_custom_permissions');
            });



       
            // $(document).ready(function()
            // {
            //     $("#role_based_permission").validate();
            //     $("#custom_based_permission").validate();

            //     var error = `<?php //echo $errors?$errors:"noerror"; ?>`;
            //     if(error != "noerror"){
            //         $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> Error</h4> <p>'+error+'</p>', {
            //             type: 'danger',
            //             delay: 2500,
            //             allow_dismiss: true
            //         });
            //     }

            //     var testResult = <?php //echo json_encode($per_output); ?>;
            //     if(testResult){
            //         $.bootstrapGrowl(testResult.error==true?'<h4><i class="fa fa-ban"></i> ':'<i class="fa fa-check-circle"></i> '+testResult.title+'</h4> <p>'+testResult.message+'</p>', {
            //             type: testResult.error==true?'danger':'success',
            //             delay: 2500,
            //             allow_dismiss: true
            //         });
            //     }
            // });

            function permissionFuction(ptype,table)
            {
                // var value = document.getElementById(ptype).value;
                var data = {};
                data[ptype] = $('#'+ptype).val();
                data['table'] = table;
                // $('#'+ptype+'_savebtn').show();
                // $('#'+ptype+'_updatebtn').hide();
                $.ajax({
                    url :  "<?= base_url();?>Actiongetdata/get_permission",
                    type : "POST",
                    datatype : "json",
                    data : data,
                    success:function(response)
                    {
                        var data = JSON.parse(response);
                        if(data[0])
                        {
                            // $('#'+ptype+'_savebtn').hide();
                            // $('#'+ptype+'_updatebtn').show();
                            var initValues = data[0].modules_id.split(',').map(function(item) {
                                return parseInt(item, 10);
                            });

                            $('#check_'+ptype).find(':checkbox[name="modules_id[]"]').each(function () {
                                $(this).prop("checked", $.inArray(parseInt($(this).val()), initValues) == -1 ? false : true );
                            });
                        }
                        else
                        {
                            $("#check_"+ptype+" input[type=checkbox]").attr('checked', false);
                        }
                    }
                });
            }
        </script>

    </body>
</html>