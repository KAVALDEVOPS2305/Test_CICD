<?php
$page_id = 'master_transit_partners';
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
                                    <i class="fa fa-truck"></i>Manage Transit Partners<br><small>Add, Edit Transit Partners & their accounts to operate</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>System Admin</li>
                            <li><a href="admin_roles">Transit Partners</a></li>
                        </ul>
                        <!-- END Header -->

                        <!-- Tabs Block -->
                        <div class="block">
                            <!-- Tabs Title -->
                            <div class="block-title themed-background-dark">
                                <ul class="nav nav-tabs" data-toggle="tabs" style="font-size: 15px;">
                                    <li class="active"><a href="#tab-parent"><b>Courier Partner</b></a></li>
                                    <li><a href="#tab-child"><b>Courier Partner Accounts</b></a></li>
                                </ul>
                            </div>
                            <!-- END Tabs Title -->

                            <!-- Tabs Content -->
                            <div class="tab-content">
                                <!-- Parent Courier Partner -->
                                <div class="tab-pane active" id="tab-parent">
                                    <!-- Tab Content -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Horizontal Form Block -->
                                            <div class="block">
                                                <!-- Horizontal Form Title -->
                                                <div class="block-title">
                                                    <h2>Add/Update <strong>Transit Partners</strong></h2>
                                                </div>
                                                <!-- END Horizontal Form Title -->

                                                <!-- Horizontal Form Content -->
                                                <form method="post" id="form_transitpartner" class="form-horizontal form-bordered" onsubmit="return false;">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label" for="transitpartner_name">Transit Partner<span class="text-danger">*</span></label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="transitpartner_name" name="transitpartner_name" class="form-control" placeholder="Enter Transit Partner name...">
                                                        </div>

                                                        <label class="col-md-1 control-label" for="logo_name">Logo<span class="text-danger">*</span></label>
                                                        <div class="col-md-2">
                                                            <input type="text" id="logo_name" name="logo_name" class="form-control" placeholder="Enter Logo file name">
                                                        </div>

                                                        <input type="hidden" id="cid" name="cid" />

                                                        <label class="col-md-1 control-label">Description</label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="transitpartner_description" name="transitpartner_description" class="form-control" placeholder="Enter Description...">
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
                                            <h2>Manage <strong>Transit Partners</strong></h2>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datatable-transitpartner" class="table table-vcenter table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Transit Partner</th>
                                                        <th class="text-center">Logo file</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php     
                                                $result=$this->db->order_by(2, 'ASC')->get('master_transit_partners');
                                                // print_r($this->db->last_query());
                                                $i=1;
                                                foreach($result->result() as $row)
                                                {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $row->transitpartner_id;?></td>
                                                        <td><?php echo $row->transitpartner_name; ?></td>
                                                        <td><?php echo $row->transitpartner_logo; ?></td>
                                                        <td><?php echo $row->transitpartner_description; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if($row->transitpartner_status==1)
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" onclick="changestatus_tp('<?php echo $row->transitpartner_id ?>','<?php echo $row->transitpartner_status ?>')" class="label label-success">Active</a> 

                                                            <?php
                                                            }
                                                            else if($row->transitpartner_status==0)
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" onclick="changestatus_tp('<?php echo $row->transitpartner_id ?>','<?php echo $row->transitpartner_status ?>')" class="label label-danger">In-active</a>
                                                            <?php }?>


                                                        </td>

                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" onclick="getedit_data_tp('<?php echo $row->transitpartner_id ?>')"><i class="fa fa-pencil"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- End Tab Content -->                                    
                                </div>
                                <!-- END Parent Courier Partner -->

                                <!-- Custom Child Courier Partner -->
                                <div class="tab-pane" id="tab-child">
                                    <!-- Tab Content -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Horizontal Form Block -->
                                            <div class="block">
                                                <!-- Horizontal Form Title -->
                                                <div class="block-title">
                                                    <h2>Add/Update <strong>Transit Partners Accounts</strong></h2>
                                                </div>
                                                <!-- END Horizontal Form Title -->

                                                <!-- Horizontal Form Content -->
                                                <form method="post" id="form_transitpartneraccounts" class="form-horizontal form-bordered" onsubmit="return false;">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label" for="parent_id">Transit Partner<span class="text-danger">*</span></label>
                                                        <div class="col-md-4">
                                                            <select name="parent_id" id="parent_id" class="form-control">
                                                            <option value="">-- Select transit partner --</option>
                                                            <?php     
                                                            $result=$this->db->where('transitpartner_status =','1')->order_by('2', 'ASC')->get('master_transit_partners');
                                                            foreach($result->result() as $rowtpa)
                                                            {
                                                            ?>
                                                            <option value="<?php echo $rowtpa->transitpartner_id; ?>"><?php echo $rowtpa->transitpartner_name; ?></option>
                                                            <?php }?>
                                                            </select>
                                                        </div>

                                                        <label class="col-md-2 control-label" for="account_name">Account Name<span class="text-danger">*</span></label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="account_name" name="account_name" class="form-control" placeholder="Enter account name">
                                                        </div>

                                                        <input type="hidden" id="cid_acc" name="cid_acc" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Description</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="account_description" name="account_description" class="form-control" placeholder="Enter Description...">
                                                        </div>

                                                        <label class="col-md-2 control-label">Base Weight<span class="text-danger">*</span></label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="base_weight" name="base_weight" class="form-control" placeholder="Enter Base weight...">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Token API Key</label>
                                                        <div class="col-md-10">
                                                            <input type="text" id="account_key" name="account_key" class="form-control" placeholder="Enter API Key...">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Account Username</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="account_username" name="account_username" class="form-control" placeholder="Enter account username...">
                                                        </div>

                                                        <label class="col-md-2 control-label">Account Password</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="account_password" name="account_password" class="form-control" placeholder="Enter account password...">
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-actions">
                                                        <div class="col-md-12 col-md-offset-2">
                                                            <button type="submit" class="btn btn-sm btn-success" id="savebtntpa"><i class="fa fa-save"></i> Submit</button>
                                                            
                                                            <button type="submit" style="display: none;" class="btn btn-sm btn-warning" id="updatebtntpa"><i class="fa fa-edit"></i> Update</button>
                                                            
                                                            <button type="reset" class="btn btn-sm btn-primary" id="resetbtntpa"><i class="fa fa-repeat"></i> Reset</button>
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
                                            <h2>Manage <strong>Transit Partners Accounts</strong></h2>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datatable-common" class="table table-vcenter table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Partner</th>
                                                        <th class="text-center">Account</th>
                                                        <th class="text-center">Username</th>
                                                        <th class="text-center">Password</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php  
                                                $result=$this->db->select('mtpa.*,mtp.transitpartner_name')
                                                ->join('master_transit_partners mtp', 'mtpa.parent_id=mtp.transitpartner_id')
                                                ->get('master_transitpartners_accounts mtpa');
                                                // print_r($this->db->last_query());
                                                foreach($result->result() as $rowtpa)
                                                {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $rowtpa->account_id;?></td>
                                                        <td><?php echo $rowtpa->transitpartner_name; ?></td>
                                                        <td><?php echo $rowtpa->account_name; ?></td>
                                                        <td><?php echo $rowtpa->account_username; ?></td>
                                                        <td><?php echo $rowtpa->account_password; ?></td>
                                                        <td><?php echo $rowtpa->account_description; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if($rowtpa->account_status==1)
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" onclick="changestatus_tpa('<?php echo $rowtpa->account_id ?>','<?php echo $rowtpa->account_status ?>')" class="label label-success">Active</a> 

                                                            <?php
                                                            }
                                                            else if($rowtpa->account_status==0)
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" onclick="changestatus_tpa('<?php echo $rowtpa->account_id ?>','<?php echo $rowtpa->account_status ?>')" class="label label-danger">In-active</a>
                                                            <?php }?>
                                                        </td>

                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" onclick="getedit_data_tpa('<?php echo $rowtpa->account_id ?>')"><i class="fa fa-pencil"></i></a>

                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="Register Warehouses" class="btn btn-xs btn-info" onclick="bulk_registerwarehouse('<?php echo $rowtpa->account_id ?>')"style="margin-left: 5px;"><i class="gi gi-shop"></i></a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <div id="loader" class="text-center" style="display: none;">
                                                    <i class="fa fa-spinner fa-3x fa-spin"></i><br/>Registering Warehouse...
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- End Tab Content -->
                                </div>
                                <!-- END Custom Child Courier Partner -->
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

            $('#form_transitpartner').on('submit', function(e)
            {
                if($("#form_transitpartner").valid())
                {
                    if($('#cid').val()) {
                        $('#updatebtn').prop('disabled', true);
                        update_data("form_transitpartner","<?= base_url();?>actionupdate/master_transitpartners"); 
                    }
                    else {
                        $('#savebtn').prop('disabled', true);
                        ins_data("form_transitpartner","<?= base_url();?>actioninsert/master_transitpartners");
                    }
                }
                else
                    e.preventDefault();        
            });

            $('#form_transitpartneraccounts').on('submit', function(e)
            {
                if($("#form_transitpartneraccounts").valid())
                {
                    if($('#cid_acc').val()) {
                        $('#updatebtntpa').prop('disabled', true);
                        update_data("form_transitpartneraccounts","<?= base_url();?>actionupdate/master_transitpartners_accounts"); 
                    }
                    else {
                        $('#savebtntpa').prop('disabled', true);
                        ins_data("form_transitpartneraccounts","<?= base_url();?>actioninsert/master_transitpartners_accounts");
                    }
                }
                else
                    e.preventDefault();        
            });

            function getedit_data_tp(rowid)
            {
                //alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/master_transitpartners",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtn").show();
                        $("#cid").val(r[0].trim());
                        $("#transitpartner_name").val(r[1].trim());
                        $("#logo_name").val(r[2].trim());
                        $("#transitpartner_description").val(r[2].trim());
                        $("#savebtn").hide();
                        $("#resetbtn").hide();
                        $("#transitpartner_name").focus();
                    }
                });
            }

            function getedit_data_tpa(rowid)
            {
                // alert(rowid);
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/master_transitpartners_accounts",
                    type : "POST",
                    datatype : "json",
                    data : { 'id'   : rowid },
                    success:function(res)
                    {
                        var r = res.split("#");
                        //alert(r);    
                        $("#updatebtntpa").show();
                        
                        $("#cid_acc").val(r[0].trim());
                        $("#parent_id").val(r[1].trim());
                        $("#account_name").val(r[2].trim());
                        $("#account_description").val(r[3].trim());
                        $("#base_weight").val(r[7].trim());
                        $("#account_key").val(r[4].trim());
                        $("#account_username").val(r[5].trim());
                        $("#account_password").val(r[6].trim());
                        $("#savebtntpa").hide();
                        $("#resetbtntpa").hide();
                        $("#account_name").focus();
                    }
                });
            }

            function changestatus_tp(row_id,curr_status)
            {
                var new_status;
                //alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                    new_status='0';
                else if (curr_status=='0')
                    new_status='1';
                //alert(nst);
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/master_transitpartners" );
            }

            function changestatus_tpa(row_id,curr_status)
            {
                var new_status;
                //alert(row_id+"#"+curr_status);
                if(curr_status=='1')
                    new_status='0';
                else if (curr_status=='0')
                    new_status='1';
                //alert(nst);
                update_status(row_id, new_status,"<?= base_url();?>actionstatusupdate/master_transitpartners_accounts" );
            }

            function bulk_registerwarehouse($accountid)
            {
                // alert('Bulk Register' + $accountid);
                var aid = $accountid;
                $.ajax({
                    url :  "<?= base_url();?>administrator/register_address",
                    type : "POST",
                    datatype : "json",
                    data : { 'accountid'   : aid },
                    beforeSend: function()
                    {
                        $('#loader').show();
                    },
                    complete: function()
                    {
                        $('#loader').hide();

                    },
                    success:function(res)
                    {
                        // alert(res);
                        var response = JSON.parse(res);
                        if(response.error)
                        {
                            //alert("error");                          
                            $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'danger',
                                delay: 2500,
                                allow_dismiss: true
                            });
                        }
                        else
                        {
                            // alert("success");
                            // alert(response.title);
                            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'success',
                                delay: 2500,
                                allow_dismiss: true
                            });

                            // setTimeout(function(){location.reload();}, 3000);
                        }
                    }
                });
                
            }
        </script>

    </body>
</html>