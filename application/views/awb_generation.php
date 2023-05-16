<?php
$page_id = 'awb_generation';
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
                                    <i class="fa fa-barcode"></i>Upload AWBs<br><small>Upload waybill numbers</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>System Admin</li>
                            <li><a href="javascript:void();">Upload AWB</a></li>
                        </ul>
                        <!-- END Header -->


                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Search <strong>AWBs</strong></h2>

                                        <div class="block-options pull-right">
                                            <a href="#modal-add" data-id="" data-toggle="modal" title="Add pincode" data-original-title="Add pincode" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Upload AWBs</a>
                                        </div>
                                        
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_searchawb" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <label class="col-md-1 control-label">Partner</label>
                                            <div class="col-md-2">
                                                <select name="transit_partner" id="transit_partner" class="form-control" required="">
                                                <option value="">-- Select partner --</option>
                                                    <?php     
                                                    $result=$this->db->where('account_status','1')->where_in('parent_id','3,5,6',false)->order_by('2', 'ASC')->get('master_transitpartners_accounts');
                                                    foreach($result->result() as $rowtpa)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $rowtpa->account_id; ?>"><?php echo $rowtpa->account_name; ?></option>
                                                    <?php }?>
                                                    </select>
                                            </div>

                                            <label class="col-md-1 control-label">Type</label>
                                            <div class="col-md-2">
                                                <select name="shipment_type" id="shipment_type" class="form-control">
                                                    <option value="">-- Select type --</option>
                                                    <option value="forward">Forward</option>
                                                    <option value="reverse">Reverse</option>
                                                </select>
                                            </div>

                                            <label class="col-md-1 control-label">Mode</label>
                                            <div class="col-md-2">
                                                <select name="pay_mode" id="pay_mode" class="form-control">
                                                    <option value="">-- Select type --</option>
                                                    <option value="COD">COD</option>
                                                    <option value="PPD">Prepaid</option>
                                                </select>
                                            </div>

                                            <label class="col-md-1 control-label">Status</label>
                                            <div class="col-md-2">
                                                <select name="waybill_status" id="waybill_status" class="form-control">
                                                    <option value="">-- Select used type --</option>
                                                    <option value="1">Used</option>
                                                    <option value="0">Unused</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-1">
                                                <button type="submit" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-search"></i> Search</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>
                        </div>
                        <div class="block full" id="table-div" style="display: none;">
                            <div class="block-title themed-background-dark-fancy" style="margin-bottom: 0px;">
                                <h2 style="color: #fff;">View <strong>AWBs</strong></h2>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata">
                                
                            </div>
                        </div>                       

                        <!-- AWB Generation Modal -->
                        <div id="modal-add" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><b>Generate AWBs</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_generateawbs" class="form-horizontal form-bordered" onsubmit="return false;">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <label>Partner</label>
                                                    <select name="transit_partner" id="transit_partner" class="form-control" onchange="validate(this.value)">
                                                    <option value="">-- Select partner --</option>
                                                    <?php     
                                                    $result=$this->db->where('account_status','1')->where_in('parent_id','3,5,6',false)->order_by('2', 'ASC')->get('master_transitpartners_accounts');
                                                    foreach($result->result() as $rowtpa)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $rowtpa->account_id; ?>"><?php echo $rowtpa->account_name; ?></option>
                                                    <?php }?>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label>Shipment Type</label>
                                                    <select name="shipment_type" id="shipment_type" class="form-control">
                                                        <option value="">-- Select type --</option>
                                                        <option value="forward">Forward</option>
                                                        <option value="reverse">Reverse</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label>Pay Mode</label>
                                                    <select name="pay_mode" id="pay_mode" class="form-control">
                                                        <option value="">-- Select type --</option>
                                                        <option value="COD">COD</option>
                                                        <option value="PPD">Prepaid</option>
                                                        <option value="PKP">Pickup</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label>Upload AWB<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="awb_file" name="awb_file" accept=".csv">
                                                    <span class="help-block">Upload CSV format file only.</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>
                                                        <span class="text-success" style="font-size: 30px;"><i class="fi fi-csv"></i></span>
                                                    <a href="<?= base_url("assets/samples/Sample-UploadAWBs.csv")?>" download>Download Sample</a>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="extra_div">
                                                <div class="col-md-4">
                                                    <label>Express</label>
                                                    <select name="express" id="express" class="form-control">
                                                        <option value="">-- Select express --</option>
                                                        <option value="air">Air</option>
                                                        <option value="surface">Surface</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label>Count</label>
                                                    <input type="text" id="awb_count" name="awb_count" class="form-control" placeholder="AWBs Count...">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-12" id="xbees_info" style="display: none;">
                                                    <h5><b>For XPressBess</b></h5>
                                                    <ul>
                                                        <li>Shipment Type is required.</li>
                                                        <li>Pay Mode is required.</li>
                                                        <li>Upload AWB file in CSV format only.</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-8">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    
                                                    <button type="submit" style="display: none;" class="btn btn-sm btn-warning" id="updatebtn"><i class="fa fa-edit"></i> Update</button>
                                                    
                                                    <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END AWB Generation Modal -->
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
        <script src="<?= base_url();?>assets/js/pages/formsGeneral.js"></script>
        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                FormsGeneral.init();
                TablesDatatables.init();
            });

            $('#form_generateawbs').on('submit', function(e)
            {
                if($("#form_generateawbs").valid())
                {
                    // $('#savebtn').prop('disabled', true);
                    var data = new FormData(this);
                    // ins_data("form_generateawbs","<?= base_url();?>actioninsert/generate_awb");
                    upload_data("form_generateawbs","<?= base_url();?>actioninsert/generate_awb",data);
                }
                else
                    e.preventDefault();
            });

            $('#form_searchawb').on('submit', function(e)
            {
                search_data("form_searchawb","<?= base_url();?>actionsearch/pregenerated_awbs/0");
            });

            function validate(val)
            {
                // alert(val);
                if(val==3 || val==6 || val==7 || val==8) // For Epressbess
                {
                    $('#shipment_type').on('change', function()
                    {
                        if(this.value=="forward")
                        {
                            $('#pay_mode').val("");
                            $('#pay_mode').attr("style", "pointer-events: auto;");
                            var arr = ['COD', 'PPD'];
                            $('#pay_mode option').each(function(i)
                            {
                                if ($.inArray($(this).attr('value'), arr) == -1) {
                                    $(this).css('display', 'none');
                                } else {
                                    $(this).css('display', 'inline-block');
                                }
                            });
                        }
                        else
                        {
                            $('#pay_mode').val("PKP");
                            $('#pay_mode').attr("style", "pointer-events: none;");
                        }
                            
                    });
                    $('#xbees_info').show();
                    $('#extra_div').hide();
                }
                
            }


            $(document).on('click', '.pagination li a', function(event)
            {
                event.preventDefault();
                var page = $(this).data('ci-pagination-page');
                search_data("form_searchawb","<?= base_url();?>actionsearch/pregenerated_awbs/"+(page-1)*100);
            });
        </script>

    </body>
</html>