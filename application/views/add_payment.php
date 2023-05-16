<?php
$page_id = 'add_payment';
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
                        <div class="content-header">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="header-section">
                                        <h1>
                                            Billing<br><small>Add Payment</small>
                                        </h1>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <?php require_once('billing_navbar.php'); ?>
                                </div>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Billing</li>
                            <li><a href="javascript:;">Add Payment</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2><strong>Invoice</strong> Details</h2>

                                        <div class="block-options pull-right">
                                            <span id="invoice_status" class="label"></span>
                                        </div>
                                    </div>
                                    <!-- END Horizontal Form Title -->
                                    <?php
                                    $inv_num = '';
                                    if(isset($_GET['inv']))
                                        $inv_num = base64_decode($_GET['inv']);
                                    ?>
                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_viewinvoice" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="component-group">
                                                <div class="col-md-2">
                                                    <label>Invoice #</label>
                                                    <input type="text" id="invoice_number" name="invoice_number" class="form-control" value="<?php echo $inv_num; ?>" placeholder="Search by invoice #..." onblur="get_invoicedata();">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Invoice Date</label>
                                                <input type="text" id="invoice_date" name="invoice_date" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Invoice Amount</label>
                                                <input type="text" id="total_amount" name="total_amount" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Paid Amount</label>
                                                <input type="text" id="paid_amount" name="paid_amount" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Due Amount</label>
                                                <input type="text" id="due_amount" name="due_amount" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Shipments Counts</label>
                                                <input type="text" id="shipments_count" name="shipments_count" class="form-control" readonly>
                                            </div>                                            
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                                <input type="text" id="username" name="username" class="form-control" readonly>
                                            </div>
                                            <input type="hidden" name="user_id" id="user_id" readonly>
                                            <input type="hidden" name="tan_number" id="tan_number" readonly>
                                            <div class="col-md-6">
                                                <label>Business Name</label>
                                                <input type="text" id="business_name" name="business_name" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <fieldset id="div-payment" style="display: none;">
                                            <legend><i class="fa fa-angle-right"></i> <b>Add Payment</b></legend>
                                            <div class="form-group">
                                                <div class="component-group">
                                                    <div class="col-md-2">
                                                        <label>Payment Amount<span class="text-danger">*</span> </label>
                                                        <input type="text" id="payment_amount" name="payment_amount" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="component-group">
                                                    <div class="col-md-3">
                                                        <label>Payment Mode<span class="text-danger">*</span></label>
                                                        <select name="payment_mode" id="payment_mode" class="form-control" onchange="control_txnid(this.value);">
                                                            <option value="">-- Select Mode --</option>
                                                            <option value="cash">Cash</option>
                                                            <option value="cheque">Cheque</option>
                                                            <option value="cod_adjustment">COD Adjustment</option>
                                                            <option value="creditnote">Credit Note</option>
                                                            <option value="mutual_adjustment">Mutual Adjustment</option>
                                                            <option value="netbanking">Netbanking</option>
                                                            <option value="tds">TDS Deduction</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="component-group">
                                                    <div class="col-md-2">
                                                        <label>Payment Date</label>
                                                        <input type="text" id="payment_date" name="payment_date" class="form-control input-datepicker-close" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <label id="lbl_txnid">Transaction #/Id<span class="text-danger">*</span></label>
                                                    <input type="text" id="transaction_id" name="transaction_id" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Payment Remark</label>
                                                    <input type="text" id="payment_remark" name="payment_remark" class="form-control">
                                                </div> 
                                            </div>
                                        </fieldset>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-info" id="searchbtn"><i class="fa fa-eye"></i> View</button>

                                                <button type="submit" style="display: none;" class="btn btn-sm btn-success pull-right" id="btn_savepayment"><i class="fa fa-save"></i> Save Payment</button>
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
                                <h2>Payment <strong>Summary</strong></h2>

                                <div class="block-options pull-right">
                                    <button type="button" class="btn btn-sm btn-info" id="btn_showpaymentdiv"><i class="fa fa-money"></i> <b>Add Payment</b></button>
                                </div>
                            </div>
                            <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div>
                            <div class="table-responsive" id="render_searchdata"></div>
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
                $('#payment_date').datepicker('setDate', 'now');
                get_invoicedata();
            });

            $('#searchbtn').on('click', function()
            {
                search_data("form_viewinvoice","<?= base_url();?>actionsearch/search_invoicepayments/0");
            });

            $('#form_viewinvoice').on('submit', function(e)
            {
                if($("#form_viewinvoice").valid())
                {
                    // $('#btn_savepayment').prop('disabled', true);
                    ins_data("form_viewinvoice","<?= base_url();?>billing/add_invoicepayments");
                }
                else
                    e.preventDefault();        
            });

            function get_invoicedata() {
                $('#div-payment').hide();
                $('#btn_savepayment').hide();
                $('#table-div').hide();
                reset_paymentform();
                if($('#invoice_number').val() != "")
                {
                    var inv_num = $('#invoice_number').val();
                    $.ajax({
                        url :  "<?= base_url();?>actiongetdata/get_invoicedata",
                        type : "POST",
                        datatype : "json",
                        data : { 'id'   : inv_num },
                        success:function(res)
                        {
                            if(res != 'null')
                            {
                                var data = JSON.parse(res);
                                $('#searchbtn').prop('disabled', false);
                                $("#invoice_date").val(data.invoice_date.trim());
                                $("#business_name").val(data.business_name.trim());
                                $("#username").val(data.username.trim());
                                $("#user_id").val(data.user_id.trim());
                                $("#total_amount").val(data.total_amount.trim());
                                $("#paid_amount").val(data.paid_amount.trim());
                                $("#due_amount").val(data.due_amount.trim());
                                $("#shipments_count").val(data.shipments_count.trim());
                                $("#tan_number").val(data.tan_number.trim());
                                
                                if(data.invoice_status == "0")
                                {
                                    $("#invoice_status").html("Due").removeClass('label-success').addClass('label-danger');
                                    $('#btn_showpaymentdiv').show();
                                }
                                else
                                {
                                    $("#invoice_status").html("Paid").removeClass('label-danger').addClass('label-success'); 
                                    $('#btn_showpaymentdiv').hide();
                                }
                            }
                            else
                            {
                                $('#form_viewinvoice')[0].reset();
                                $('#searchbtn').prop('disabled', true);
                                $("#invoice_status").html("").removeClass('label-danger').removeClass('label-success');
                            }                                                           
                        }
                    });
                }
            }

            function control_txnid(mode) {
                switch (mode)
                {
                    case "cheque":
                        $('#transaction_id').val("").attr('readonly',false);
                        $('#lbl_txnid').html('Cheque Number<span class="text-danger">*</span>');
                        break;
                    case "cod_adjustment":
                        $('#transaction_id').val("").attr('readonly',false);
                        $('#lbl_txnid').html('COD TRN<span class="text-danger">*</span>');
                        break;
                    case "creditnote":
                        $('#transaction_id').val("").attr('readonly',false);
                        $('#lbl_txnid').html('CN Number<span class="text-danger">*</span>');
                        break;
                    case "netbanking":
                        $('#transaction_id').val("").attr('readonly',false);
                        $('#lbl_txnid').html('UTR<span class="text-danger">*</span>');
                        break;
                    case "tds":
                        if($("#tan_number").val()!="")
                            $('#transaction_id').val($("#tan_number").val()).attr('readonly',true);
                        else {
                            $('#transaction_id').val("").attr('readonly',false);
                        }
                        $('#lbl_txnid').html('TAN<span class="text-danger">*</span>');
                        break;
                        
                    default:
                        $('#transaction_id').val("").attr('readonly',true);
                        $('#lbl_txnid').html("Transaction #/Id");
                }
            }

            function reset_paymentform() {
                $('#payment_amount').val("");
                $('#transaction_id').val("");
                $('#payment_remark').val("")
                $('#payment_mode').val("")
            }
            
            $('#btn_showpaymentdiv').on('click', function(e)
            {
                $('#div-payment').show();
                $('#btn_savepayment').show();
            });
        </script>

    </body>
</html>