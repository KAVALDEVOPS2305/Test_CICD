<?php
$page_id = 'complete_registration';
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
                        <!-- Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-edit"></i>Complete Registration<br><small>Complete user registeration</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="javascript:void">Complete Registration</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="block full">
                            <div class="block-title">
                                <h2>View <strong>Pending Users</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-common" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Business Name</th>
                                            <th class="text-center">Full Name</th>
                                            <th class="text-center">Email Id</th>
                                            <th class="text-center">Mobile Number</th>
                                            <th class="text-center">Registered On</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php     
                                    $result=$this->db->where('account_status','1')->order_by('1','desc')->get('users_temp');
                                    // print_r($this->db->last_query());
                                    $i=1;
                                    foreach($result->result() as $row)
                                    {
                                        $mobile_status =  $row->mobile_verify==1 ? '<span class="label label-success">Verified</span>':'<span class="label label-danger">Un-Verified</span>';
                                    ?>
                                        <tr class="text-center">
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td><?php echo $row->business_name; ?></td>
                                            <td><?php echo $row->fullname; ?></td>
                                            <td><?php echo $row->email_id; ?></td>
                                            <td><?php echo $row->contact."<br/>".$mobile_status; ?></td>
                                            <td><?php echo date('d-m-Y h:i:s A', strtotime($row->added_on)); ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="self_registration?uid=<?php echo base64_encode($row->tmp_userid); ?>" target="_blank" data-toggle="tooltip" title="Fill All details" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
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

        </script>

    </body>
</html>