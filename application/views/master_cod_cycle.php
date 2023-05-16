<?php
$page_id = 'master_cod_cycle';
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
                                    <i class="gi gi-money"></i>Manage COD Cycles<br><small>Add, Edit COD Cycles</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Master</li>
                            <li><a href="admin_modules">COD Cycles</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add/Update <strong>COD Cycles</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_codcycle" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="codcycle_title">Title<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="codcycle_title" name="codcycle_title" class="form-control" placeholder="Enter COD Cycle Title...">
                                                    <span class="help-block">Title helps you to identify the cycle.</span>
                                                </div>
                                            </div>

                                            <div class="component-group">
                                                <label class="col-md-2 control-label" for="codcycle_dates">COD Dates<span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="codcycle_dates" name="codcycle_dates" class="form-control" placeholder="Enter COD Cycle Dates...">
                                                    <span class="help-block">Enter multiple dates seperated by comma.</span>
                                                </div>
                                            </div>

                                        </div>

                                        <input type="hidden" id="cid" name="cid" />

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
                                <h2>Manage <strong>COD Cycles</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-codcycle" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Cycle Dates</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php     
                                    $result=$this->db->order_by(2, 'ASC')->get('master_cod_cycle');
                                    // print_r($this->db->last_query());
                                    $i=1;
                                    foreach($result->result() as $row)
                                    {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++;?></td>
                                            <td><?php echo $row->cod_cycle_title; ?></td>
                                            <td><?php echo $row->cod_cycle_dates; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row->cod_cycle_status==1)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->cod_cycle_id ?>','<?php echo $row->cod_cycle_status ?>')" class="label label-success">Active</a> 

                                                <?php
                                                }
                                                else if($row->cod_cycle_status==0)
                                                {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="changestatus('<?php echo $row->cod_cycle_id ?>','<?php echo $row->cod_cycle_status ?>')" class="label label-danger">In-active</a>
                                                <?php }?>


                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" onclick="getedit_data('<?php echo $row->cod_cycle_id ?>')"><i class="fa fa-pencil"></i></a>
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

            $('#form_codcycle').on('submit', function(e)
            {
                if($("#form_codcycle").valid())
                {
                    if($('#cid').val()) {
                        $('#updatebtn').prop('disabled', true);
                        update_data("form_codcycle","<?= base_url();?>actionupdate/master_codcycles"); 
                    }
                    else {
                        $('#savebtn').prop('disabled', true);
                        ins_data("form_codcycle","<?= base_url();?>actioninsert/master_codcycles");
                    }
                }
                else
                    e.preventDefault();        
            });

            function getedit_data(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/master_codcycles",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtn").show();
                        
                        $("#cid").val(r[0].trim());
                        $("#codcycle_title").val(r[1].trim());
                        $("#codcycle_dates").val(r[2].trim());

                        $("#savebtn").hide();
                        $("#resetbtn").hide();
                        $("#codcycle_title").focus();
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
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/master_codcycles" );
            }
        </script>

    </body>
</html>