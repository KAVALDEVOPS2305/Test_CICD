<?php
$page_id = 'shipments_mis';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
    </head>
     
     <style>
      .checkboxes input{
         margin: 10px 10px 10px 10px;
    }
      .checkboxes label{
         margin: 10px 10px 10px 10px;
     }
    </style>

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
                            <li>Report</li>
                            <li><a href="javascript:void">MIS </a></li>
                        </ul>
                        <!-- END Header -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title themed-background-dark">
                                        <h2 style="color: #fff;">Search <strong>MIS Reports</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                               
                                    <form method="post" id="form_reportmis" action="<?php echo base_url('Actionexport/reports_mis')?>" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                        <div class="form-group">
                                            <legend><i class="fa fa-angle-right"></i> Single Search</legend> 
                                            <div class="col-md-3">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control autocomplete-username" autocomplete="off" placeholder="Search using username...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Is MPS</label>
                                                <select name="is_mps" id="is_mps" class="form-control">
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Waybill Number</label>
                                                <input type="text" id="waybill_number" name="waybill_number" class="form-control" placeholder="Search using waybill number...">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Warehouses</label>
                                              <select name="address_title" id="address_title" class="form-control">
                                                    <option value="">List of all warehouses</option>
                                                    <?php
                                                    $result=$this->db->query('select UA.address_title,U.username from users_address UA JOIN users U on UA.user_id = U.user_id');
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->address_title; ?>"><?php echo $row->address_title; ?><?php echo " (" . $row->username . ")"; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                       </div>

                                        <div class="form-group">               
                                           <div class="col-md-3">
                                                <label>Status</label>
                                                <select name="user_status[]" id="user_status" class="select-chosen form-control" style="width: 100%;" data-placeholder="Search by status...." multiple>
                                                    <option></option>
                                                    <?php
                                                    $result=$this->db->where('status_for','User')->where_not_in('status_id','200,220,229', false)->get('shipments_status');
                                                    // print_r($this->db->last_query());
                                                   foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->status_id; ?>"><?php echo $row->status_title; ?></option>
                                                   <?php } ?>
                                                   <option value="0">Lost/Missed</option>
                                                </select>
                                            </div>
                                           
                                            <div class="col-md-3">
                                                <label>Payment Mode</label>
                                                <select name="payment_mode" id="payment_mode" class="form-control">
                                                    <option value="">Search by Mode</option>
                                                    <option value="COD">COD</option>
                                                    <option value="PPD">Prepaid</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Express</label>
                                                <select name="express_type" id="express_type" class="form-control">
                                                    <option value="">Search by express</option>
                                                    <option value="air">Air</option>
                                                    <option value="surface">Surface</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Order Type</label>
                                                <select name="shipment_type" id="shipment_type" class="form-control">
                                                    <option value="">Search by Type</option>
                                                    <option value="forward">Forward</option>
                                                    <option value="reverse">Reverse</option>
                                                </select>
                                            </div>
                                        </div>
                                           
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label>Fulfilled By</label>
                                                <select name="fulfilled_account" id="fulfilled_account" class="form-control">
                                                    <option value="">Search by courier partner</option>
                                                    <?php
                                                    $result = $this->db->select('account_id,account_name')->get('master_transitpartners_accounts');
                                                    // print_r($this->db->last_query());
                                                    foreach($result->result() as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Datetype</label>
                                                <select name="order_date" id="order_date" class="form-control" >
                                                    <option value="">Search by datetype</option>
                                                    <option value="placed" selected>Placed</option>
                                                    <option value="picked">Picked</option>
                                                </select>
                                           </div>  

                                           <div class="col-md-3">
                                                <label>From Date</label>
                                                <input type="text" id="from_date" name="from_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 00:00:00" placeholder="dd-mm-yyyy hh:ii:ss" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label>To Date</label>
                                                <input type="text" id="to_date" name="to_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy 23:59:59" placeholder="dd-mm-yyyy hh:ii:ss" required>
                                            </div>
                                            
                                        </div> 
                            
                                        <div class="form-group"> 
                                            <legend><i class="fa fa-angle-right"></i> Bulk Search</legend> 
                                            <div class="col-md-3 ">
                                                <label>Upload File</label>
                                                <select name="file_type" id="file_type" class="form-control" >
                                                    <option value="">Select File Type</option>
                                                    <option value="waybill_number">Waybill Number</option>
                                                    <option value="shipment_id">Parcelx Order Ids</option>
                                                    <option value="invoice_number">Invoice/Ref Nums</option>
                                                </select>                                             
                                            </div>  
                                            <div class="col-md-3 ">
                                               <label></label>
                                              <input type="file" id="mis_file" name="mis_file" class="form-control" accept=".csv" required>  
                                              <!-- <a class="btn btn-primary" href="</?php echo base_url('Actionexport/read_report_mis')?>">Import Data</a>                                      -->
                                           </div>                    
                                           <div>
                                            <label class="col-md-3 control-label col-md-offset-2" style="text-align: left; margin-top: -15px;">
                                                <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                <a href="<?= base_url("assets/samples/Sample-MISReport.csv")?>" download>Download Sample</a>
                                            </label>
                                           </div>
                                        </div>
                                                                  
                                        <div class="form-group">  
                                            <div class="col-md-12 checkboxes">
                                                <label>Fields you might need in report</label><br/>
                                                <label>Select All<input type="checkbox" id="checkAll"></label>  
                                                <div class="row">
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="shipment_length" id="checkItem"> Shipment Length</lable></div>
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="shipment_width" id="checkItem"> Shipment Width</lable></div>
                                                    <div class="col-md-2"><lable> <input type="checkbox" name="extrafields[]" value="shipment_height" id="checkItem"> Shipment Height</lable></div>
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="shipment_weight" id="checkItem"> Shipment Weight</lable></div>
                                                    <div class="col-md-2"> <lable> <input type="checkbox" name="extrafields[]" value="billing_weight" id="checkItem"> Billed Weight</lable></div>
                                                    <div class="col-md-2"><lable><input type="checkbox" name="extrafields[]" value="zone" id="checkItem"> Zone</lable></div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-md-2">  <lable><input type="checkbox" name="extrafields[]" value="address_title" id="checkItem"> Address Title</lable></div>
                                                    <div class="col-md-2">  <lable><input type="checkbox" name="extrafields[]" value="full_address" id="checkItem"> Pickup Address</lable></div>
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="phone" id="checkItem"> Pickup Phone</lable></div>
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="pincode" id="checkItem"> Pickup Pincode</lable></div>
                                                    <div class="col-md-2">  <lable><input type="checkbox" name="extrafields[]" value="address_city" id="checkItem"> Pickup City</lable></div>
                                                    <div class="col-md-2"> <lable><input type="checkbox" name="extrafields[]" value="address_state" id="checkItem"> Pickup State</lable></div>
                                                    <div class="col-md-2"></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><lable><input type="checkbox" name="extrafields[]" value="picked_on" id="checkItem"> Picked Date</lable></div>
                                                    <div class="col-md-2"><lable><input type="checkbox" name="extrafields[]" value="ofd1_on" id="checkItem"> 1<sup>st</sup> Attempt Date</lable></div>
                                                    <div class="col-md-2">  <lable> <input type="checkbox" name="extrafields[]" value="ofd2_on" id="checkItem"> 2<sup>nd</sup> Attempt Date</lable></div>
                                                    <div class="col-md-2">  <lable><input type="checkbox" name="extrafields[]" value="ofd3_on" id="checkItem">3<sup>rd</sup> Attempt Date</lable></div>
                                                    <div class="col-md-2">   <lable><input type="checkbox" name="extrafields[]" value="last_attempt_date" id="checkItem"> Last Attempt Date</lable></div>
                                                </div>  
                                        
                                                <div class="row">
                                                    <div class="col-md-2"><lable> <input type="checkbox" name="extrafields[]" value="turn_around_time" id="checkItem"> Turn Around Time</lable></div>
                                                    
                                                    <!-- <div class="col-md-2"> <lable>  <input type="checkbox" name="extrafields[]" value="sales_poc" id="checkItem"> Sales POC</lable></div>
                                                    <div class="col-md-2"><lable> <input type="checkbox" name="extrafields[]" value="ops_poc" id="checkItem"> Ops POC</lable></div> -->
                                                    <div class="col-md-4"> <lable> <input type="checkbox" name="extrafields[]" value="pod" id="checkItem"> Received By For Digital POD </lable></div>
                                                    <div class="col-md-2"></div>
                                                
                                                </div>
                                                <!-- <input type="checkbox" name="extrafields[]" value="is_mps"> Is MPS? -->
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <!-- <button type="button" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-search"></i> Search</button> -->
                                               
                                               <a href="javascript:void;"><button type="button" class="btn btn-sm btn-success" id="btn_exportexcel"><i class="fa fa-cloud-download"></i>Download Report</button></a>
                                
                                                <button type="reset" id="btnReset" class="btn btn-sm btn-primary" id="btn_reset"><i class="fa fa-repeat"></i> All Data</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
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
        <script src="<?= base_url();?>assets/js/autocomplete.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();

                $('#from_date').datepicker('setDate', 'now');
                $('#to_date').datepicker('setDate', 'now');
            });

            // $('#searchbtn').on('click', function()
            // {
            //     // $("#user_status").val($("#status").val());
            //     search_data("form_searchshipments","<?= base_url();?>actionsearch/search_shipments/0");
            // });

            $('#btn_exportexcel').on('click', function(e)
            {
                $('#form_reportmis').submit();
            });
             
            $("#checkAll").click(function () {
               $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $("lable").on("click", function(e){
                var checkbox = $(this).find(':checkbox');
                if ($(this).is(e.target))	
                    checkbox.prop('checked', !checkbox.is(':checked')); 
            });

        </script>

    </body>
</html>