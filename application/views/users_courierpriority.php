<?php
$page_id = 'users_courierpriority';
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
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="javascript:void">Courier Priority</a></li>
                        </ul>
                        <!-- END Header -->
                        
                         <div class="block full" id="table-div" style="display: block;">
                            <div class="block-title" style="margin-bottom: 5px;">
                                <h2>Set <strong>Courier Priority</strong></h2>
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
                                        <form method="post" id="form_courierpriority" class="form-horizontal form-bordered" onsubmit="return false;">
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
                                                    <label class="col-md-2 control-label">Zone</label>

                                                    <label class="col-md-3 control-label" style="text-align: center;">Priority 1</label>

                                                    <label class="col-md-3 control-label" style="text-align: center;">Priority 2</label>

                                                    <label class="col-md-3 control-label" style="text-align: center;">Priority 3</label>

                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id='copytoall<?php echo $row->slab_id; ?>' onchange="copy_all(this.value)" value="<?php echo $row->slab_id; ?>"> Copy to all
                                                    </label>
                                                </div>

                                                <?php
                                                    $res_cp_a = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'A')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();

                                                    $res_cp_b = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'B')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();

                                                    $res_cp_c = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'C')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();

                                                    $res_cp_d = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'D')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();

                                                    $res_cp_e = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'E')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();

                                                    $res_cp_f = $this->db->select('priority_id,priority_1,priority_2,priority_3')
                                                    ->where('user_id', $uid)
                                                    ->where('slab_id', $row->slab_id)
                                                    ->where('zone', 'F')
                                                    ->where('priority_status','1')
                                                    ->get('users_courier_priority')->row();
                                                ?>
                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">A<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_a[<?php echo $row->slab_id; ?>]" id="priority_1_a_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_a->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_a[<?php echo $row->slab_id; ?>]" id="priority_2_a_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_a->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_a[<?php echo $row->slab_id; ?>]" id="priority_3_a_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_a->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">B<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_b[<?php echo $row->slab_id; ?>]" id="priority_1_b_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_b->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_b[<?php echo $row->slab_id; ?>]" id="priority_2_b_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_b->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_b[<?php echo $row->slab_id; ?>]" id="priority_3_b_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_b->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">C<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_c[<?php echo $row->slab_id; ?>]" id="priority_1_c_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_c->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_c[<?php echo $row->slab_id; ?>]" id="priority_2_c_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_c->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_c[<?php echo $row->slab_id; ?>]" id="priority_3_c_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_c->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">D<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_d[<?php echo $row->slab_id; ?>]" id="priority_1_d_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_d->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_d[<?php echo $row->slab_id; ?>]" id="priority_2_d_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_d->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_d[<?php echo $row->slab_id; ?>]" id="priority_3_d_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_d->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">E<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_e[<?php echo $row->slab_id; ?>]" id="priority_1_e_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_e->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_e[<?php echo $row->slab_id; ?>]" id="priority_2_e_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_e->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_e[<?php echo $row->slab_id; ?>]" id="priority_3_e_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_e->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label">F<span class="text-danger">*</span></label>

                                                        <div class="col-md-3">
                                                            <select name="priority_1_f[<?php echo $row->slab_id; ?>]" id="priority_1_f_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option value=""></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_f->priority_1)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_2_f[<?php echo $row->slab_id; ?>]" id="priority_2_f_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_f->priority_2)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select name="priority_3_f[<?php echo $row->slab_id; ?>]" id="priority_3_f_slab_<?php echo $row->slab_id; ?>" class="select-select2 form-control" style="width: 100%;" data-placeholder="Select Courier...">
                                                                <option></option>
                                                                <?php     
                                                                $result=$this->db->order_by('account_name', 'ASC')->get('master_transitpartners_accounts');
                                                                // print_r($this->db->last_query());
                                                                foreach($result->result() as $cp)
                                                                {
                                                                    if($cp->account_id == $res_cp_f->priority_3)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>" selected><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $cp->account_id; ?>"><?php echo $cp->account_name; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="form-group form-actions">
                                                <div class="col-md-12 col-md-offset-2">
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
        <script src="<?= base_url();?>assets/js/pages/formsGeneral.js"></script>
        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        <script>
            $(function(){
                FormsValidation.init();
                UiProgress.init();
                TablesDatatables.init();
            });

            $('#form_courierpriority').on('submit', function(e)
            {
                $('select.select-select2').each(function() {
                    // setTimeout(function() {
                        $(this).rules("add", 
                        {
                            required: true
                        })
                    // }, 0);
                }); 

                if($("#form_courierpriority").valid())
                { 
                    ins_data("form_courierpriority","<?= base_url();?>actioninsert/user_courierpriority");
                }
                else
                    e.preventDefault();
            });

            function copy_all(slab)
            {
                // alert(slab);
                // alert($('#copytoall' + slab).is(":checked"));
                if($('#copytoall' + slab).is(":checked"))
                {
                    for(var i = 98; i <= 102; i++)
                    {
                        var al = String.fromCharCode(i);
                        $('#priority_1_'+al+'_slab_'+slab).val($('#priority_1_a'+'_slab_'+slab).val()).trigger('change');
                        $('#priority_2_'+al+'_slab_'+slab).val($('#priority_2_a'+'_slab_'+slab).val()).trigger('change');
                        $('#priority_3_'+al+'_slab_'+slab).val($('#priority_3_a'+'_slab_'+slab).val()).trigger('change');
                    }
                }
                else
                {
                    for(var i = 98; i <= 102; i++)
                    {
                        var al = String.fromCharCode(i);
                        $('#priority_1_'+al+'_slab_'+slab).val('').trigger('change');
                        $('#priority_2_'+al+'_slab_'+slab).val('').trigger('change');
                        $('#priority_3_'+al+'_slab_'+slab).val('').trigger('change');
                    }
                }
            }
        </script>

    </body>
</html>