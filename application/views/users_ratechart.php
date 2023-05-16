<?php
$page_id = 'users_ratechart';
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
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-map-marker"></i>Manage Rate Chart<br><small>Add, Edit users rates</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="javascript:void">Rate chart</a></li>
                        </ul>
                        <!-- END Validation Header -->

                        
                         <div class="block full" id="table-div" style="display: block;">
                            <div class="block-title" style="margin-bottom: 5px;">
                                <h2>Assign <strong>Rate Tariffs</strong></h2>
                            </div>
                            <!-- <div id="loader" class="text-center" style="margin-top: 10px;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i><br/>Loading Data...
                            </div> -->

                            <?php 
                                if(isset($_GET['uid']))
                                {
                                    $uid = base64_decode($_GET['uid']);
                                    // echo $uid;

                                    if($uid!='')
                                    {

                                        $result_user=$this->db->select('fullname,business_name,contact')->where('user_id =', $uid)->limit(1)->get('users');
                                        $user_data = $result_user->row_array();

                                        $result_slab=$this->db->select('US.*,WS.slab_title,base_weight,additional_weight')->join('master_weightslab WS', 'US.weightslab_id=WS.weightslab_id')->where('user_id =', $uid)->get('users_weightslabs US');
                                        $user_slab = $result_slab->result();

                                        // print_r($this->db->last_query());
                                        if(!empty($user_data) && !empty($user_slab))
                                        {
                                            // print_r($user_data)
                                        ?>
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-6">
                                                <h4 class="text-success"><b><?php echo $user_data['business_name']?></b></h4>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="text-warning"><b><?php echo $user_data['fullname']?></b></h4>
                                            </div>
                                            <div class="col-md-2">
                                                <h4 class="text-warning"><b><?php echo $user_data['contact']?></b></h4>
                                            </div>
                                        </div>


                                        <!-- Horizontal Form Content -->
                                        <form method="post" id="form_ratechart" class="form-horizontal form-bordered" onsubmit="return false;">

                                            <?php
                                            foreach($user_slab as $row)
                                            {
                                            ?>
                                            <div id="slab">
                                                <div class="form-group" style="background-color: aliceblue;">
                                                    
                                                    <label class="col-md-4 control-label">Express:
                                                        <span class="text-success"><?php echo ucwords($row->express); ?></span>
                                                    </label>

                                                    <label class="col-md-8 control-label" style="text-align: center;">Slab:
                                                        <span class="text-success" id="express"><?php echo ucwords($row->slab_title); ?> </span>
                                                        <?php echo $row->base_weight."|".$row->additional_weight; ?>
                                                    </label>

                                                    <input type="hidden" name="user_id[]" value="<?php echo($uid)?>">
                                                    <input type="hidden" name="slab_id[]" value="<?php echo $row->slab_id; ?>">
                                                    <input type="hidden" name="weightslab_id[]" value="<?php echo $row->weightslab_id; ?>">
                                                    <input type="hidden" name="express[]" value="<?php echo $row->express; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-1 control-label">Zone</label>

                                                    <label class="col-md-2 control-label" style="text-align: center;">Fwd Base</label>

                                                    <label class="col-md-2 control-label" style="text-align: center;">Fwd Addon</label>

                                                    <label class="col-md-2 control-label" style="text-align: center;">RTO Base</label>

                                                    <label class="col-md-2 control-label" style="text-align: center;">RTO Addon</label>
                                                    
                                                    <label class="col-md-2 control-label" style="text-align: center;">Surcharge 1</label>
                                                    
                                                    <label class="col-md-1 control-label" style="text-align: center;">SC 2</label>
                                                </div>

                                                <?php

                                                $query_rates_a = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon, surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','A')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_a = $query_rates_a->row_array();
                                                // print_r($this->db->last_query());
                                                // print_r($result_rates_a);

                                                ?>

                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">A<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_a" name="fwd_base_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_a['fwd_base'])?$result_rates_a['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_a" name="fwd_addon_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_a['fwd_addon'])?$result_rates_a['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_a" name="rto_base_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_a['rto_base'])?$result_rates_a['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_a" name="rto_addon_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_a['rto_addon'])?$result_rates_a['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_a" name="surcharge_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_a['surcharge'])?$result_rates_a['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_a" name="ndd_a[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_a['surcharge_2'])?$result_rates_a['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $query_rates_b = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon,surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','B')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_b = $query_rates_b->row_array();
                                                // print_r($this->db->last_query());
                                                ?>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">B<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_b" name="fwd_base_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_b['fwd_base'])?$result_rates_b['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_b" name="fwd_addon_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_b['fwd_addon'])?$result_rates_b['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_b" name="rto_base_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_b['rto_base'])?$result_rates_b['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_b" name="rto_addon_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_b['rto_addon'])?$result_rates_b['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_b" name="surcharge_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_b['surcharge'])?$result_rates_b['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_b" name="ndd_b[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_b['surcharge_2'])?$result_rates_b['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $query_rates_c = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon,surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','C')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_c = $query_rates_c->row_array();
                                                // print_r($this->db->last_query());
                                                ?>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">C<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_c" name="fwd_base_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_c['fwd_base'])?$result_rates_c['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_c" name="fwd_addon_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_c['fwd_addon'])?$result_rates_c['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_c" name="rto_base_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_c['rto_base'])?$result_rates_c['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_c" name="rto_addon_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_c['rto_addon'])?$result_rates_c['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_c" name="surcharge_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_c['surcharge'])?$result_rates_c['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_c" name="ndd_c[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_c['surcharge_2'])?$result_rates_c['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $query_rates_d = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon,surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','D')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_d = $query_rates_d->row_array();
                                                // print_r($this->db->last_query());
                                                ?>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">D<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_d" name="fwd_base_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_d['fwd_base'])?$result_rates_d['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_d" name="fwd_addon_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_d['fwd_addon'])?$result_rates_d['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_d" name="rto_base_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_d['rto_base'])?$result_rates_d['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_d" name="rto_addon_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_d['rto_addon'])?$result_rates_d['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_d" name="surcharge_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_d['surcharge'])?$result_rates_d['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_d" name="ndd_d[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_d['surcharge_2'])?$result_rates_d['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $query_rates_e = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon,surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','E')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_e = $query_rates_e->row_array();
                                                // print_r($this->db->last_query());
                                                ?>
                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">E<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_e" name="fwd_base_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_e['fwd_base'])?$result_rates_e['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_e" name="fwd_addon_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_e['fwd_addon'])?$result_rates_e['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_e" name="rto_base_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_e['rto_base'])?$result_rates_e['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_e" name="rto_addon_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_e['rto_addon'])?$result_rates_e['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_e" name="surcharge_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_e['surcharge'])?$result_rates_e['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_e" name="ndd_e[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_e['surcharge_2'])?$result_rates_e['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $query_rates_f = $this->db->select('fwd_base,fwd_addon,rto_base,rto_addon,surcharge,surcharge_2')
                                                                         ->where('user_id',$uid)
                                                                         ->where('userslab_id',$row->slab_id)
                                                                         ->where('zone','F')
                                                                         ->where('rate_status','1')
                                                                         ->get('users_rates');
                                                $result_rates_f = $query_rates_f->row_array();
                                                // print_r($this->db->last_query());
                                                ?>
                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-1 control-label">F<span class="text-danger">*</span></label>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_base_f" name="fwd_base_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Base Rate" value="<?php echo isset($result_rates_f['fwd_base'])?$result_rates_f['fwd_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="fwd_addon_f" name="fwd_addon_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Fwd Addon Rate" value="<?php echo isset($result_rates_f['fwd_addon'])?$result_rates_f['fwd_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_base_f" name="rto_base_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Base" value="<?php echo isset($result_rates_f['rto_base'])?$result_rates_f['rto_base']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="rto_addon_f" name="rto_addon_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="RTO Addon" value="<?php echo isset($result_rates_f['rto_addon'])?$result_rates_f['rto_addon']:''?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <input type="text" id="surcharge_f" name="surcharge_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge" value="<?php echo !empty($result_rates_f['surcharge'])?$result_rates_f['surcharge']:0;?>">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text" id="ndd_f" name="ndd_f[<?php echo $row->slab_id; ?>]" class="form-control rate" placeholder="Surcharge 2" value="<?php echo !empty($result_rates_f['surcharge_2'])?$result_rates_f['surcharge_2']:0;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-1">
                                                    <button type="submit" class="btn btn-sm btn-success" id="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                    
                                                    <button type="reset" class="btn btn-sm btn-primary"><i class="fa fa-repeat"></i> Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Horizontal Form Content -->

                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                            <h4 class="text-danger text-center"><b>Sorry, no slab found, for the selected user.</b></h4>
                                        <?php
                                        }
                                    }
                                    else
                                       echo "<script> location.href='users';</script>";
                               }
                               else
                                    echo "<script> location.href='users';</script>";

                            ?>
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

            $('#form_ratechart').on('submit', function(e)
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

                if($("#form_ratechart").valid())
                {
                    // search_data("form_ratechart","<?= base_url();?>actionsearch/search_pincodes/0"); 
                    // alert("Validated");
                    ins_data("form_ratechart","<?= base_url();?>actioninsert/user_rates");
                }
                else
                    e.preventDefault();
            });

            

            // function getedit_data(rowid)
            // {
            //     // alert(rowid);
            //     $.ajax({
            //         url :  "<?= base_url();?>actiongetdata/master_pincodes",
            //         type : "POST",
            //         datatype : "json",
            //         data : { 'id'   : rowid },
            //         success:function(res)
            //         {
            //             var r = res.split("#");
            //             //alert(r);    
            //             $("#updatebtn").show();
                        
            //             $("#cid").val(r[0].trim());
            //             $("#f_pincode").val(r[1].trim());
            //             $("#f_pin_city").val(r[2].trim());
            //             $("#f_pin_state").val(r[3]).trigger('change');

            //             $("#savebtn").hide();
            //             $("#resetbtn").hide();
            //             $("#f_pincode").focus();
            //         }
            //     });
            // }

        </script>

    </body>
</html>