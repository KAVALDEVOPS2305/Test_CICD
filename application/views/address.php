<?php
$page_id = 'user_address';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css"/>
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
                            <li>User</li>
                            <li><a href="javascript:void(0)">Addresses/Warehouses</a></li>
                        </ul>
                        <!-- END Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>Addresses/Warehouses</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_user_addresses" action="<?php echo base_url('Actionexport/reports_addresses')?>" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" autocomplete="off" placeholder="Search using username...">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Address Title</label>
                                                <input type="text" id="address_title" name="address_title" class="form-control" placeholder="Search using address title...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Status</label>
                                                <select name="address_status" id="address_status" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Pincode</label>
                                                <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Search using pincode...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>City</label>
                                                <input type="text" id="address_city" name="address_city" class="form-control" placeholder="Search using city name...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>State</label>
                                                <select name="address_state" id="address_state" class="select-select2 form-control" style="width: 100%;" data-placeholder="Search using state...">
                                                    <option></option>
                                                    <?php     
                                                    $result=$this->db->order_by('state_name', 'ASC')->get('tbl_state');
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->state_name; ?>"><?php echo $row->state_name; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-search"></i> Search</button>
                                                
                                                <button type="reset" id="btnReset" class="btn btn-sm btn-primary" id="btn_reset"><i class="fa fa-repeat"></i> All Data</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>
                        </div>

                        <div class="block full" id="table-div" style="display: none;">
                            <div class="block-title" style="margin-bottom: 0px;">
                                <h2>View <strong>All Addresses/Warehouses</strong></h2>
                                <div class="block-options pull-right">
                                    <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-file-excel-o"></i> Export</button></a>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="" id="render_searchdata"></div>
                        </div>

                    <!-- View response model -->
                    <div class="modal fade" id="ModalviewResponse" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">API Response for Address Id <b><span id="addr_id"></span></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="view_res_loader" style="margin-top: 10px;text-align: center;">
                                        <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                                    </div>
                                    <span id="api_response" class="justify-content-between"></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END View response model -->

                    <!-- Register Address  Modal start -->
                    <div class="modal fade" id="modal-register" role="dialog">
                        <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><b>Register Address/Warehouse for <u class="text-warning">Address Id: <span id="reg_addr_id"></span></u></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <form method="post" id="form_update_address" class="form-horizontal form-bordered" onsubmit="return false;" style="padding-left: 15px;">
                                                <div class="form-group">
                                                    <label for="updt_address_title">Address Title</label>
                                                    <input type="text" id="updt_address_title" name="updt_address_title" class="form-control" placeholder="Enter address title..." readonly>
                                                    
                                                    <label for="updt_addressee">Addressee</label>
                                                    <input type="text" id="updt_addressee" name="updt_addressee" class="form-control editable" placeholder="Enter addressee..." readonly>
                                                    <input type="hidden" id="updt_address_id" name="updt_address_id">

                                                    <input type="text" id="updt_full_address" name="updt_full_address" class="form-control editable" placeholder="Enter full address..." readonly>

                                                    <input type="text" id="updt_phone" name="updt_phone" class="form-control editable" placeholder="Enter contact number..." readonly>

                                                    <input type="text" id="updt_pincode" name="updt_pincode" class="form-control editable" placeholder="Enter pincode..." onblur="pincodelookup()" readonly>

                                                    <input type="text" id="updt_address_city" name="updt_address_city" class="form-control" placeholder="Enter city..." readonly>

                                                    <input type="text" id="updt_address_state" name="updt_address_state" class="form-control" placeholder="Enter state..." readonly>
                                                </div>

                                                <div class="form-group">
                                                    <!-- <div class="col-md-12"> -->
                                                        <button type="submit" class="btn btn-sm btn-warning" id="btn_update" style="display:none;"><i class="fa fa-save"></i> Update Address</button>
                                                        
                                                        <button type="button" class="btn btn-sm btn-info" id="btn_edit"><i class="fa fa-pencil"></i> Edit Address</button>
                                                    <!-- </div> -->
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-7">
                                            <form method="post" id="form_register_address" class="form-horizontal form-bordered" onsubmit="return false;">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="courierPartner">Select Account<span class="text-danger">*</span></label>
                                                        <select name="courierPartner[]" id="courierPartner" class="select-chosen form-control" style="width: 100%;" data-placeholder="Select account" multiple required>
                                                            <option></option>
                                                            <option id="all_sel" value="0">All Accounts</option>
                                                            <?php
                                                                $result = $this->db->where_in('parent_id',[1,7,13,14])->get('master_transitpartners_accounts')->result();
                                                                foreach($result as $row)
                                                                {
                                                                ?>
                                                                    <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="error" class="text-danger"></div>
                                                        <input type="hidden" id="address_id" name="address_id" />
                                                    </div>
                                                </div>
                                                <div id="add_loader" style="margin-top: 10px; display:none;">
                                                    <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" id="btn_register"><i class="fa fa-check"></i> Register</button>

                                    <button type="button" class="btn btn-info" id="Reg_close" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END warehouse register model -->
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
        <script src="<?= base_url();?>assets/js/autocomplete.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();

                search_data("form_user_addresses","<?= base_url();?>actionsearch/address_user/0");
            });

            $("#savebtn").click(function(){
                var data_check = $('#courierPartner').find(":selected").val();
                if(data_check == undefined)
                {
                    $("#error").html("Please select courier partner");
                }
                else{
                    $("#error").empty();
                    update_data("form_manual_warehouse_register","<?= base_url();?>Actionupdate/manual_add_warehouse");
                }
            });

            $('#searchbtn').on('click', function()
            {
                // $("#user_status").val($("#status").val());
                search_data("form_user_addresses","<?= base_url();?>actionsearch/address_user/0");
            });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_user_addresses').submit();
            });

            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_user_addresses","<?= base_url();?>actionsearch/address_user/"+(page-1)*100);
            });

            function viewAPIResponse(address_id)
            {
                // alert(address_id)
                $.ajax({
                    url :  "<?= base_url();?>actiongetdata/get_address_response",
                    type : "POST",
                    datatype : "json",
                    data : { 'address_id' : address_id },
                    beforeSend: function(){
                        $('#view_res_loader').show();
                    },
                    complete: function(){
                        $('#view_res_loader').hide();
                    },
                    success:function(res)
                    {
                        $("#api_response").html(res);
                        $("#addr_id").html(address_id);
                    }
                });
            }

            function viewAddress(address_id)
            {
                $("#btn_edit").show();
                $("#btn_update").hide();
                $(".editable").attr("readonly",true);
                $('#btn_register').prop('disabled', false);
                $('#courierPartner').val([]).trigger("chosen:updated");
                $("#updt_address_title, #updt_addressee,#updt_full_address,#updt_phone,#updt_pincode,#updt_address_city,#updt_address_state,#updt_address_id,#address_id").val('');

                $.ajax({
                    url : "<?= base_url();?>actiongetdata/get_addressdetails",
                    type: "POST",
                    datatype : "json",
                    data : { 'address_id' : address_id },
                    beforeSend: function(){
                        $('#add_loader').show();
                    },
                    complete: function(){
                        $('#add_loader').hide();
                    },
                    success:function(response)
                    {
                        var res = response.split("@");
                        $("#updt_address_title").val(res[0].trim());
                        $("#updt_addressee").val(res[1].trim());
                        $("#updt_full_address").val(res[2].trim());
                        $("#updt_phone").val(res[3].trim());
                        $("#updt_pincode").val(res[4].trim());
                        $("#updt_address_city").val(res[5].trim());
                        $("#updt_address_state").val(res[6].trim());
                        $("#updt_address_id").val(address_id);
                        $("#address_id").val(address_id);
                        $("#reg_addr_id").html(address_id);
                    }
                });
            }

            $("#btn_edit").click(function()
            {
                $("#btn_edit").hide();
                $("#btn_update").show();
                $(".editable").removeAttr("readonly");
            });

            $('#updt_pincode').keyup(function()
            {
                if(this.value.length >= 6)
                {
                    var pincode = $("#updt_pincode").val();
                    $.ajax({
                        url :  "<?= base_url();?>actiongetdata/pincodelookup",
                        type : "POST",
                        datatype : "json",
                        data : { 'pincode' : pincode },
                        beforeSend: function(){
                            $('#add_loader').show();
                            $('#btn_update').attr("disabled", true);
                        },
                        complete: function(){
                            $('#add_loader').hide();
                        },
                        success:function(res)
                        {
                            if(res!="")
                            {
                                var r = res.split("#");
                                // alert(r);
                                $("#updt_address_city").val(r[0]);
                                $("#updt_address_state").val(r[1]);
                                $('#btn_update').attr("disabled", false);
                            }
                            else
                            {
                                $('#btn_update').attr("disabled", true);
                                $("#updt_pincode").focus();
                                $("#updt_address_city").val('');
                                $("#updt_address_state").val('');
                                $.bootstrapGrowl('<h4><i class="fa fa-times"></i> Pincode Error</h4> <p>The pincode is not serviceable or invalid.</p>', {
                                    type: 'danger',
                                    delay: 3000,
                                    allow_dismiss: true
                                });
                            }
                        }
                    });
                }
                else
                {
                    $("#updt_address_city").val("");
                    $("#updt_address_state").val("");
                    $('#btn_update').attr("disabled", true);
                }
            });

            $("#btn_update").click(function()
            {
                $.ajax({
                    url :  "<?= base_url();?>Actionupdate/update_warehouse",
                    type : "POST",
                    datatype : "json",
                    data : $("#form_update_address").serialize(),
                    beforeSend: function(){
                        $('#add_loader').show();
                    },
                    complete: function(){
                        $('#add_loader').hide();
                    },
                    success:function(responsed)
                    {
                        const response = JSON.parse(responsed)
                        if(response.error)
                        {                          
                            $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'danger',
                                delay: 2500,
                                allow_dismiss: true
                            });
                        }
                        else
                        {
                            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                                type: 'success',
                                delay: 2500,
                                allow_dismiss: true
                            });

                            $("#btn_edit").show();
                            $("#btn_update").hide();
                            $(".editable").attr("readonly",true);
                        }
                    }
                });
            });

            $("#btn_register").click(function()
            {
                var data_check = $('#courierPartner').find(":selected").val();
                if(data_check == undefined)
                {
                    $("#error").html("Please select courier account");
                }
                else
                {
                    $("#error").empty();
                    $('#btn_register').prop('disabled', true);
                    
                    $.ajax({
                        url :  "<?= base_url();?>Actionupdate/register_warehouse",
                        type : "POST",
                        datatype : "json",
                        data : $("#form_register_address").serialize(),
                        beforeSend: function(){
                            $('#add_loader').show();
                        },
                        complete: function(){
                            $('#add_loader').hide();
                        },
                        success:function(response_data)
                        {
                            response = JSON.parse(response_data);
                            var success = response.response_data.success_cnt;
                            var errors = response.response_data.error_cnt;
                            if(success > 0 && errors == 0)
                            {
                                $('#modal-register').modal('toggle');
                                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> Congrats</h4> <p>'+response.message+' registered Successfully.<br/>'+success+' Success '+errors+' Errors</p>', {
                                    type: 'success',
                                    delay: 4500,
                                    allow_dismiss: true
                                });
                            }
                            else if(success > 0 && errors > 0)
                            {
                                $('#modal-register').modal('toggle');
                                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> Congrats</h4> <p>'+response.message+' registered Successfully.<br/>'+success+' Success '+errors+' Errors</p>', {
                                    type: 'warning',
                                    delay: 4500,
                                    allow_dismiss: true
                                });
                            }
                            else if(success == 0 && errors > 0)
                            {
                                $('#modal-register').modal('toggle');
                                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> Sorry</h4> <p>'+response.message+' Not registered.<br/>'+errors+' Error(s)</p>', {
                                    type: 'danger',
                                    delay: 4500,
                                    allow_dismiss: false
                                });
                            }
                            
                        }
                    });
                }
            });
        </script>

    </body>
</html>