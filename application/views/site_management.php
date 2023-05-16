<?php
$page_id = 'site_management';
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
                        <!-- Header  -->
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Site Management</li>
                            <li><a href="javascript:;">Portal</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Admin/User <strong>Portal settings</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal FormContent  -->
                                    <form method="post" id="form_portal_settings" class="form-horizontal form-bordered" enctype="multipart/form-data" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Portal Type<span class="text-danger">*</span></label>
                                            <div class="col-md-4">
                                                <select name="site_portal" id="site_portal" class="form-control" data-placeholder="Select Portal..." required>
                                                    <option value="">-- Select Portal --</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                            <label class="col-md-2 control-label">Manage Site</label>
                                            <div class="col-md-4">
                                                <select name="admin_siteManage" id="admin_siteManage" class="form-control" data-placeholder="Select Site Manage..." required>
                                                    <option value="">-- Select Site Manage --</option>
                                                    <option value="wallpaper">Login Bg Wallpaper</option>
                                                    <option value="notice">Notifications</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div id="Wallpaper" style="display: none;">
                                                <label class="col-md-2 control-label" for="wallpaper">Login Wallpaper Image<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" id="wallpaper" name="wallpaper" class="form-control">
                                                    <!-- <span style="color:#ff6600;">1920*1280 pixels</span> -->
                                                    <div id="imgSize"></div>
                                                </div>
                                            </div>

                                            <div id="notification" style="display: none;">
                                                <label class="col-md-2 control-label" for="notice">Notifications<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <textarea rows="4" id="notice" name="notice" class="form-control" placeholder="Enter notice text..."></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn"> Submit</button>
                                                
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
                                <h2>View <strong>Portal settings</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-common" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Site Type</th>
                                            <th class="text-center">Update Type</th>
                                            <th class="text-center">Login Bg Image</th>
                                            <th class="text-center">Notification Text</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php     
                                        $result=$this->db->order_by(1, 'DESC')->get('tbl_sitemanagement');
                                        // print_r($this->db->last_query());
                                        $i=1;
                                        foreach($result->result() as $row)
                                        {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td class="text-center"><?php echo $row->site_type; ?></td>
                                            <td class="text-center"><?php echo $row->update_type; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($row->update_type == 'wallpaper')
                                                    {
                                                        $containerName = "ikrarfiles";
                                                        $bg_img = get_blob_file($containerName,$row->wallpaper_path);
                                                ?>
                                                        <div class="gallery gallery-widget" data-toggle="lightbox-gallery">
                                                            <a href="<?php echo $bg_img; ?>" class="gallery-link" title="<?=ucfirst($row->site_type)." Panel"; ?>">
                                                                View image
                                                            </a>
                                                        </div>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center"><?php echo $row->notice_text; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row->update_status==1)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->sitemgmt_id ?>','<?php echo $row->update_status ?>')" class="label label-success">Active</a> 

                                                <?php
                                                }
                                                else if($row->update_status==0)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->sitemgmt_id ?>','<?php echo $row->update_status ?>')" class="label label-danger">In-active</a>
                                                <?php }?>
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
        <!-- <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a> -->

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.0.0-beta.3/babel.min.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_portal_settings').on('submit', function(e)
            {
                if($("#form_portal_settings").valid())
                {
                    var data = new FormData(this);
                    // $("#savebtn").attr('disabled','disabled');
                    upload_data("form_portal_settings","<?= base_url();?>Actioninsert/portal_settings",data);
                }
                else
                    e.preventDefault();        
            });

            $("#admin_siteManage").change(function()
            {
                var selected = $(this).val();
                if(selected == 'wallpaper')
                {
                    $('#Wallpaper').show();
                    $("#wallpaper").attr("required", "true");
                    $("#notice").removeAttr("required", "false");
                    $('#notification').hide();
                    // alert("The image has been changed.");
                }
                else if(selected == 'notice')
                {
                    $('#notification').show();
                    $("#notice").attr("required", "true");
                    $("#wallpaper").removeAttr("required", "false");
                    $('#Wallpaper').hide();
                    // alert("The text has been changed.");
                }
                else
                {
                    $('#Wallpaper').hide();
                    $('#notification').hide();
                }

                $("#resetbtn").click(function(){
                    $('#Wallpaper').hide();
                    $('#notification').hide();
                });
            });

            function changestatus(row_id,curr_status)
            {
                var new_status;
                //alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                    new_status='0';
                else if (curr_status=='0')
                    new_status='1';
                // alert(new_status);
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/site_manage_status" );
            }
        </script>

    </body>
</html>