<?php
$page_id = 'users_agreement';
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
                            <li>Legal Terms</li>
                            <li><a href="javascript:void(0);">User's Agreement</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add <strong>Users Agreement docs</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal FormContent  -->
                                    <form method="post" id="form_users_agreement" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="agreement_title">Agreement Title<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="agreement_title" name="agreement_title" class="form-control" placeholder="Enter Agreement title...">
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="agreement_pdf">Agreement File<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="file" id="agreement_pdf" name="agreement_pdf"  class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>                                  
                                </div>                               
                            </div>
                        </div>

                        <div class="block full">
                            <div class="block-title">
                                <h2>Manage <strong>Agreement docs</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-adminmodule" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Agreement Title</th>
                                            <th class="text-center">View File</th>
                                            <th class="text-center">Added on</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Accepted By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $result=$this->db->order_by(1,'desc')->where('agreement_status <>','2')->get('tbl_agreements');
                                            $i=1;
                                            foreach($result->result() as $row)
                                            {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $row->agreement_title; ?></td>
                                                <td class="text-center">
                                                    <a href="<?php echo get_blob_file('useragreements',$row->agreement); ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-warning"></i></a>
                                                </td>
                                                <td class="text-center"><?php echo date('d-m-Y h:i:s A',strtotime($row->added_on)); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if($row->agreement_status == 1)
                                                        {
                                                        ?>
                                                            <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->agreement_id ?>','<?php echo $row->agreement_status ?>')" class="label label-success">Active</a>
                                                        <?php
                                                        }
                                                        else if($row->agreement_status == 0)
                                                        {
                                                        ?>
                                                            <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->agreement_id ?>','<?php echo $row->agreement_status ?>')" class="label label-danger">In-active</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url();?>Actionexport/user_agreement_accept?id=<?php echo $row->agreement_id; ?>"><i class="fi fi-csv fa-2x text-success"></i></a>
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

            $('#form_users_agreement').on('submit', function(e)
            {
                if($("#form_users_agreement").valid())
                {
                    var data = new FormData(this);
                    upload_data("form_users_agreement","<?= base_url();?>actioninsert/users_agreement",data);
                }
                else
                    e.preventDefault();        
            });

            function changestatus(row_id,curr_status)
            {
                var new_status;
                if(curr_status=='1')
                    new_status='0';
                else if (curr_status=='0')
                    new_status='1';
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/agreement_status" );
            }
        </script>

    </body>
</html>