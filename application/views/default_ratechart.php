<?php
$page_id = 'default_ratechart';
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
                        <!-- Validation Header -->
                        <!-- <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-map-marker"></i>Manage Rate Chart<br><small>Add, Edit users rates</small>
                                </h1>
                            </div>
                        </div> -->
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="javascript:void">Rate chart</a></li>
                        </ul>
                        <!-- END Validation Header -->


                         <div class="block full" id="table-div" style="display: block;">
                            <div class="block-title" style="margin-bottom: 5px;">
                                <h2><strong>Default Rate Tariffs</strong></h2>
                            </div>
                            <!-- <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div> -->
                            <!-- Horizontal Form Content -->
                            <form method="post" id="form_default_users_ratechart" class="form-horizontal form-bordered" onsubmit="return false;">
                                <?php $default_slab = $this->db->where('dws.status','1')->join('master_weightslab mws','mws.weightslab_id=dws.weightslab_id')->get('default_weightslab dws')->result_array();

                                if(isset($default_slab) && !empty($default_slab) && count($default_slab) > 0){
                                    foreach($default_slab as $slab_key=>$slab_value){
                                        ?>
                                    <div id="slab">
                                        <div class="form-group" style="background-color: aliceblue;">

                                            <label class="col-md-4 control-label">Express:
                                                <span class="text-success"> <?php echo ucwords($slab_value['express']); ?> </span>
                                            </label>

                                            <label class="col-md-8 control-label" style="text-align: center;">Slab:
                                                <span class="text-success" id="express"> <?php echo ucwords($slab_value['slab_title']); ?> </span>
                                                        <?php echo $slab_value['base_weight']."|".$slab_value['additional_weight']; ?>
                                            </label>

                                            <input type="hidden" name="default_slabid[]" value="<?php echo $slab_value['default_slabid']; ?>">
                                            <input type="hidden" name="weightslab_id[]" value="<?php echo $slab_value['weightslab_id']; ?>">
                                            <input type="hidden" name="express[]" value="<?php echo $slab_value['express']; ?>">

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-1 control-label">Zone</label>

                                            <label class="col-md-3 control-label" style="text-align: center;">Fwd Base</label>

                                            <label class="col-md-3 control-label" style="text-align: center;">Fwd Addon</label>

                                            <label class="col-md-3 control-label" style="text-align: center;">RTO Base</label>

                                            <label class="col-md-2 control-label" style="text-align: center;">RTO Addon</label>

                                            <!-- <label class="col-md-2 control-label" style="text-align: center;">Surcharge 1</label>

                                            <label class="col-md-1 control-label" style="text-align: center;">SC 2</label> -->
                                        </div>

                                        <?php
                                        //$rate_chart_a = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','A')->get('default_ratechart drc')->row_array();

                                        $rate_chart_a = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','A')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <!-- Zone A -->
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">A<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_a" name="fwd_base_a[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_a['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_a" name="fwd_addon_a[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_a['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_a" name="rto_base_a[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_a['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_a" name="rto_addon_a[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_a['rto_addon'] ?? '';?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Zone B -->
                                        <?php
                                        //$rate_chart_b = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','B')->get('default_ratechart drc')->row_array();

                                        $rate_chart_b = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','B')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">B<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_b" name="fwd_base_b[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_b['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_b" name="fwd_addon_b[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_b['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_b" name="rto_base_b[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_b['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_b" name="rto_addon_b[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_b['rto_addon'] ?? '';?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Zone C -->
                                        <?php
                                        //$rate_chart_c = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','C')->get('default_ratechart drc')->row_array();

                                        $rate_chart_c = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','C')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">C<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_c" name="fwd_base_c[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_c['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_c" name="fwd_addon_c[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_c['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_c" name="rto_base_c[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_c['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_c" name="rto_addon_c[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_c['rto_addon'] ?? '';?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Zone D -->
                                        <?php
                                        //$rate_chart_d = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','D')->get('default_ratechart drc')->row_array();

                                        $rate_chart_d = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','D')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">D<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_d" name="fwd_base_d[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_d['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_d" name="fwd_addon_d[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_d['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_d" name="rto_base_d[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_d['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_d" name="rto_addon_d[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_d['rto_addon'] ?? '';?>">
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Zone E -->
                                        <?php
                                        //$rate_chart_e = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','E')->get('default_ratechart drc')->row_array();

                                        $rate_chart_e = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','E')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">E<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_e" name="fwd_base_e[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_e['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_e" name="fwd_addon_e[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_e['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_e" name="rto_base_e[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_e['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_e" name="rto_addon_e[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_e['rto_addon'] ?? '';?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Zone F -->
                                        <?php
                                        //$rate_chart_f = $this->db->join('default_weightslab dws','dws.weightslab_id = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('dws.default_slabid',$slab_value['default_slabid'])->where('drc.weightslab_id',$slab_value['weightslab_id'])->where('drc.zone','F')->get('default_ratechart drc')->row_array();

                                        $rate_chart_f = $this->db->join('default_weightslab dws','dws.default_slabid = drc.weightslab_id')->where('dws.status','1')->where('rate_status','1')->where('drc.weightslab_id',$slab_value['default_slabid'])->where('drc.zone','F')->get('default_ratechart drc')->row_array();
                                        ?>
                                        <div class="form-group">
                                            <div class="component-group">
                                                <label class="col-md-1 control-label">F<span class="text-danger">*</span></label>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_base_f" name="fwd_base_f[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo $rate_chart_f['fwd_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="fwd_addon_f" name="fwd_addon_f[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo $rate_chart_f['fwd_addon'] ?? '';?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="text" id="rto_base_f" name="rto_base_f[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo $rate_chart_f['rto_base'] ?? '';?>">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" id="rto_addon_f" name="rto_addon_f[<?php echo $slab_value['default_slabid']; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo $rate_chart_f['rto_addon'] ?? '';?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                                <div class="form-group form-actions">
                                    <div class="col-md-12 col-md-offset-1">
                                        <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>

                                        <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat"></i> Reset</button>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                    <p class="text-center" style="padding-top: 50px;font-size: 18px;">Please choose default weight slab first </p>
                                <?php } ?>
                            </form>
                            <!-- END Horizontal Form Content -->
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

            $('#form_default_users_ratechart').on('submit', function(e)
            {
                $('input.rate').each(function() {
                    // setTimeout(function() {
                        $(this).rules("add",
                        {
                            required: true,
                            decimalrate: true
                        })
                    // }, 0);
                });

                if($("#form_default_users_ratechart").valid())
                {
                    ins_data("form_default_users_ratechart","<?= base_url();?>actioninsert/default_user_rates");
                }
                else
                    e.preventDefault();
            });

        </script>

    </body>
</html>