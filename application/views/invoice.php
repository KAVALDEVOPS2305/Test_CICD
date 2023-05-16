<?php
$page_id = 'invoice';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
        <style>
            h1,h4,h5 {
                margin: 0px;
            }
            h5 {
                line-height: 1.5em;
            }
            h6 {
                font-size: 14px;
                margin-top: 5px;
            }
            p {
                line-height: 1.5em;
                font-size: 14px;
            }
            hr {
                margin-top: 15px;
                margin-bottom: 10px;
            }
            @media print {
                @page {
                    /* size: auto;   auto is the initial value */
                    size: 21cm 29.7cm;
                    margin: 10px;  /* this affects the margin in the printer settings */
                }
            }
        </style>
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

                    <?php 
                        if(isset($_GET['invoice']))
                        {
                            $invoice_num = base64_decode($_GET['invoice']);
                            // echo $invoice_num;

                            if($invoice_num!='')
                            {
                                $result_invoice=$this->db->select('SI.*,fullname,business_name,billing_address,billing_state,contact,email_id,billing_type, kyc_pan, kyc_doc_number,kyc_gst_reg')
                                ->where('px_invoice_number =', $invoice_num)
                                ->join('users U','SI.user_id=U.user_id')
                                ->join('users_kyc KYC','SI.user_id=KYC.user_id')
                                ->limit(1)->get('shipments_invoices SI');
                                $invoice_data = $result_invoice->row();

                                if(!empty($invoice_data))
                                {
                                ?>
                                    <!-- Invoice Block -->
                                    <div class="block full">
                                        <!-- Invoice Title -->
                                        <div class="block-title">
                                            <div class="block-options pull-right">
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Print invoice" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i class="fa fa-print"></i></a>
                                                
                                                <!-- <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Mail invoice" class="btn btn-sm btn-primary"><i class="fa fa-envelope-o"></i></a>
                                                
                                                <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Save invoice" class="btn btn-sm btn-success"><i class="fa fa-save"></i></a> -->
                                            </div>
                                            <h2><strong>Invoice # </strong><?php echo $invoice_num ?></h2>
                                        </div>
                                        <!-- END Invoice Title -->

                                        <!-- Invoice Content -->
                                        <!-- 2 Column grid -->
                                        <div class="row block-section">
                                            <div class="col-xs-6">
                                                <img src="https://app.intargos.com/assets/img/InTargos Logo.png" alt="InTargos" style="width: 35%;" >
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <h3><b>Invoice</b></h3>
                                            </div>

                                            <div class="col-xs-12"><hr/>
                                                <div class="col-xs-6">
                                                    <h5><b>Invoice #</b> <?php echo $invoice_data->px_invoice_number; ?></h5>
                                                </div>
                                                
                                                <div class="col-xs-6 text-right">
                                                    <h5><b>Date</b>: <?php echo date('d/M/Y', strtotime($invoice_data->invoice_date));?></h5>
                                                </div>
                                            </div>
                                        
                                            <div class="col-xs-12"><hr>
                                                <div class="col-xs-8">
                                                    <h5>Bill To:<br/>
                                                    <b><?php echo $invoice_data->business_name?></b></h5>
                                                    <p>
                                                    <?php echo $invoice_data->fullname?><br>
                                                    <?php echo $invoice_data->billing_address?>,<br>
                                                    <?php echo $invoice_data->billing_state?><br>
                                                        <i class="fa fa-phone"></i> +91-<?php echo $invoice_data->contact?><br>
                                                        <i class="fa fa-envelope-o"></i> <?php echo $invoice_data->email_id?>
                                                    </p>
                                                    <h5><b>PAN:</b> <?php echo $invoice_data->kyc_pan ?></h5>
                                                    <h5><b>GSTIN:</b> <?php echo $invoice_data->kyc_gst_reg =='yes' && !empty($invoice_data->kyc_doc_number) ? $invoice_data->kyc_doc_number : 'Not Applicable' ?></h5>
                                                    <h5><b>Billing State:</b> <?php echo $invoice_data->billing_state?></h5>
                                                    
                                                </div>

                                                <!-- Client Info -->
                                                <div class="col-xs-4 text-right">
                                                    <h5><strong>InTargos</strong></h5>
                                                    <p>
                                                        Add A Delta Private Limited<br>
                                                        1<sup>st</sup> floor, D-13, <br/>Sector-3, Noida,<br>Uttar Pradesh - 201301<br>
                                                        <!-- +91-9090909090 <i class="fa fa-phone"></i><br> -->
                                                        billing@intargos.com <i class="fa fa-envelope-o"></i><br>
                                                        www.intargos.com <i class="fa fa-globe"></i>
                                                    </p>
                                                    <h5><b>PAN:</b> AASCA7501M</h5>
                                                    <h5 style="margin-top: 10px;"><b>GSTIN:</b> 09AASCA7501M2Z4</h5>
                                                </div>
                                                <!-- END Client Info -->
                                            </div>
                                        </div>
                                        <!-- END 2 Column grid -->

                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table class="table table-vcenter">
                                                <thead style="background-color: #ddd; border: 1px solid #bbb;">
                                                    <tr>
                                                        <td><b>#</b></td>
                                                        <td><b>Particulars</b></td>
                                                        <td width=10%><b>HSN/SAC</b></td>
                                                        <td width="20%"><b>Shipments Count</b></td>
                                                        <td width="20%" class="text-right"><b>Amount</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody style="border: 1px solid #bbb;">
                                                    <tr style="border-bottom:1px solid #bbb;">
                                                        <td><h4>1</h4></td>
                                                        <td><h4>Logistics Services</h4></td>
                                                        <td><h4>996812</h4></td>
                                                        <td><h4><?php echo $invoice_data->shipments_count?></h4></td>
                                                        <td class="text-right"><h4><?php echo indian_format($invoice_data->invoice_amount)?></h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" rowspan="4" style="border-right:1px solid #bbb;">
                                                            <b>Terms & Conditions:</b>
                                                            <ul>
                                                                <li>All Cheques/DD in favor of <b>'Add A Delta Private Limited'</b></li>
                                                                <li>For any queries feel free to contact your account manager.</li>
                                                                <li>Any dispute subject to Delhi jurisdition</li>
                                                                <li>E. & O.E.</li>
                                                            </ul>
                                                            This is computer generated receipt and does not require physical signature.
                                                        </td>
                                                        <td class="text-right active"><span class="h4">SUBTOTAL</span></td>
                                                        <td class="text-right active"><span class="h4"><?php echo indian_format($invoice_data->invoice_amount,2)?></span></td>
                                                    </tr>
                                                <?php
                                                if($invoice_data->billing_state == "Uttar Pradesh")
                                                {
                                                ?>
                                                    <tr class="active">
                                                        <td class="text-right"><span class="h4">CGST @ 9%</span></td>
                                                        <td class="text-right"><span class="h4"><?php echo indian_format($invoice_data->gst_amount/2)?></span></td>
                                                    </tr>
                                                    <tr class="active">
                                                        <td class="text-right"><span class="h4">SGST @ 9%</span></td>
                                                        <td class="text-right"><span class="h4"><?php echo indian_format($invoice_data->gst_amount/2)?></span></td>
                                                    </tr>
                                                <?php
                                                } else {
                                                ?>
                                                    <tr class="active">
                                                        <td class="text-right"><span class="h4">IGST @ 18%</span></td>
                                                        <td class="text-right"><span class="h4"><?php echo indian_format($invoice_data->gst_amount)?></span></td>
                                                    </tr>
                                                <?php } ?>
                                                    <tr class="active">
                                                        <td class="text-right"><span class="h4"><strong>GRAND TOTAL</strong></span></td>
                                                        <td class="text-right"><span class="h4"><strong><?php echo indian_format($invoice_data->total_amount)?></strong></span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- END Table -->

                                        <!-- 2 Column grid -->
                                        <div class="row block-section">
                                            <div class="col-xs-6 text-left">
                                                <b>Pay online</b>
                                                <ul class="list-unstyled">
                                                    <li><b>Bank Name:</b> ICICI Bank</li>
                                                    <li><b>Account #:</b> 739005000011</li>
                                                    <li><b>IFSC Code:</b> ICIC0007390</li>
                                                </ul>
                                            </div>
                                            <div class="col-xs-3" style="display:<?php echo $invoice_data->invoice_status == '1' ? 'block' : 'none';?>;">
                                                <img src="<?= base_url();?>assets/img/placeholders/images/paid-stamp.png" alt="Stamp" class="img-circle img-responsive" style="width: 39%; float: right;">
                                            </div>
                                        
                                            <div class="col-xs-12">
                                                <div class="col-xs-9 text-center">
                                                    <h4 class="text-muted"><b>Thank you for trusting and doing business with InTargos.</b></h4>
                                                </div>
                                                <div class="col-xs-3 text-right">
                                                    <h5>Authorised Signatory</h5>
                                                </div>
                                            </div>
                                        <?php
                                        if($invoice_data->billing_type == "postpaid")
                                        {
                                            $result_payment=$this->db->where('invoice_number', $invoice_data->px_invoice_number)
                                            ->where('user_id',$invoice_data->user_id)
                                            ->get('invoice_payments');
                                            $payment_data = $result_payment->result();
                                        ?>
                                            <div class="col-xs-12"><hr/>
                                                <h3 style="margin-bottom: 0px;"><b>Payment Advise</b></h3>
                                            </div>
                                    <?php } ?>
                                        </div>
                                        <!-- END 2 Column grid -->
                                    <?php
                                    if($invoice_data->billing_type == "postpaid")
                                    {
                                        if(!empty($payment_data))
                                        {
                                        ?>
                                            <!-- Payment Advise Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-vcenter">
                                                    <thead style="background-color: #ddd;">
                                                        <tr>
                                                            <td width="2%"><b>#</b></td>
                                                            <td width="12%" class="text-center"><b>Paid On</b></td>
                                                            <td width="70%"><b>Payment Mode</b></td>
                                                            <td class="text-right"><b>Paid Amount</b></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $i=0;
                                                    foreach ($payment_data as $row)
                                                    {
                                                    ?>
                                                        <tr>
                                                            <td><h5><?php echo ++$i; ?></h5></td>
                                                            <td class="text-center"><h5><?php echo date('d/M/Y', strtotime($row->payment_date))?></h5></td>
                                                            <td>
                                                                <h5><b><?php echo $row->payment_mode?></b></h5>
                                                                <h6><?php echo $row->transaction_id?></h6>
                                                            </td>
                                                            <td class="text-right"><h5><?php echo indian_format($row->payment_amount)?></h5></td>
                                                        </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <td colspan="3" class="text-right active"><span class="h4">TOTAL PAID</span></td>
                                                            <td class="text-right active"><span class="h4"><?php echo indian_format($invoice_data->paid_amount)?></span></td>
                                                        </tr>
                                                        <tr class="active">
                                                            <td  colspan="3"class="text-right"><span class="h4"><strong>TOTAL DUE</strong></span></td>
                                                            <td class="text-right"><span class="h4"><strong><?php echo indian_format($invoice_data->due_amount)?></strong></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- END Payment Advise Table -->
                                        <?php } else echo '<h5 class="text-center"><b>No payments made yet.</b></h5>';
                                    } ?>
                                    </div>
                                    <!-- END Invoice Block -->
                                <?php
                                }
                                else
                                    echo '<h4 class="text-center text-danger"><b>No Invoice found..!!</b></h4>';
                            }
                            else
                                echo "<script> location.href='view_invoice';</script>";
                        }
                        else
                            echo "<script> location.href='view_invoice';</script>";
                    ?>                        
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