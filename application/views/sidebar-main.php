<div id="sidebar">
    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Brand -->
            <a href="dashboard" class="sidebar-brand">
                <i class="hi hi-chevron-right"></i><span class="sidebar-nav-mini-hide">In<strong>Targos</strong></span>
            </a>
            <!-- END Brand -->

            <!-- User Info -->
            <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                <div class="sidebar-user-avatar">
                    <a href="javascript:void">
                        <img src="<?= base_url();?>assets/img/placeholders/avatars/avatar<?php echo $this->session->userdata['user_session']['avatar'];?>.png" alt="InTargos Admin">
                    </a>
                </div>
                <div class="sidebar-user-name"><b><?php echo $this->session->userdata['user_session']['admin_name']; ?></b></div>
                <?php 
                    $session_role = strtoupper($this->session->userdata('user_session')['role_name']);
                    $modules = $this->permissions_model->get_modules();
                    // echo "<pre>";
                    // print_r($modules);
                    echo $this->session->userdata['user_session']['role_name'];
                ?>
            </div>
            <!-- END User Info -->

            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <li>
                    <a href="<?= base_url()?>dashboard" class="<?php echo ($page_id == "dashboard" ? "active" : "");?>"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                </li>

                <?php if($session_role == 'SUPERADMIN' || in_array('admin_users',$modules) || in_array('master_transit_partners',$modules) || in_array('awb_generation',$modules))
                {?>
                    <li class="sidebar-header">
                        <span class="sidebar-header-options clearfix">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Manage all admin related activities like creating roles, sub-users, permissions."><i class="fa fa-info-circle"></i></a></span>
                        <span class="sidebar-header-title">Sys Admin</span>
                    </li>

                    <?php if($session_role == 'SUPERADMIN' || in_array('admin_users',$modules))
                    {?>
                    <li class="<?php echo ($page_id == "admin_roles" || $page_id == "admin_modules" || $page_id == "admin_users" || $page_id == "permissions" || $page_id == "user_modules" ? "active" : "");?>">
                        <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-sampler sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Administration</span></a>
                        <ul>
                            <?php if ($session_role == 'SUPERADMIN')
                            {?>
                            <li>
                                <a href="<?= base_url()?>admin_roles" class="<?php echo ($page_id == "admin_roles" ? "active" : "");?>">Roles</a>
                            </li>
                            <li>
                                <a href="<?= base_url()?>admin_modules" class="<?php echo ($page_id == "admin_modules" ? "active" : "");?>">Admin Modules</a>
                            </li>
                            <li>
                                <a href="<?= base_url()?>permissions"  class="<?php echo ($page_id == "permissions" ? "active" : "");?>">Permissions</a>
                            </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('admin_users',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url()?>admin_users" class="<?php echo ($page_id == "admin_users" ? "active" : "");?>">Sub-Admins</a>
                            </li>
                            <?php
                            } 
                            if($session_role == 'SUPERADMIN' || in_array('users_modules',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url()?>users_modules" class="<?php echo ($page_id == "user_modules" ? "active" : "");?>">User Modules</a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>

                    <li class="<?php echo ($page_id == "site_management" ? "active" : "");?>">
                        <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-desktop sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Site Management</span></a>
                        <ul>
                            <li>
                                <!-- BG Image & Content in CK Editor -->
                                <a href="<?= base_url()?>portal" class="<?php echo ($page_id == "site_management" ? "active" : "");?>">Portal Settings</a>
                            </li>
                            <li>
                                <!-- Send Notifications to users -->
                                <a href="" class="<?php echo ($page_id == "" ? "active" : "");?>">Notifications</a>
                            </li>
                            
                        </ul>
                    </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('master_transit_partners',$modules) || in_array('awb_generation',$modules))
                    {
                    ?>
                    <li class="<?php echo ($page_id == "master_transit_partners" || $page_id == "awb_generation" ? "active" : "");?>">
                        <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cubes sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">System Management</span></a>
                        <ul>
                            <?php
                            if($session_role == 'SUPERADMIN' || in_array('master_transit_partners',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url()?>master_transit_partners" class="<?php echo ($page_id == "master_transit_partners" ? "active" : "");?>">Transit Partners</a>
                            </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('awb_generation',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url()?>awb_generation" class="<?php echo ($page_id == "awb_generation" ? "active" : "");?>">Upload AWBs</a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                        if($session_role == 'SUPERADMIN' || in_array('users_agreement',$modules))
                        {
                        ?>
                        <li>
                            <a href="<?= base_url()?>users_agreement" class="<?php echo ($page_id == "users_agreement" ? "active" : "");?>"><i class="fa fa-pencil-square-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Legal Agreement</span></a>
                        </li>
                        <?php
                        }
                    }
                }
                if($session_role == 'SUPERADMIN' || in_array('master_cod_cycle',$modules) || in_array('master_billing_cycle',$modules) || in_array('master_pincodes',$modules) || in_array('master_pinservices',$modules) || in_array('master_weightslab',$modules) || in_array('master_zones',$modules) || in_array('users',$modules) || in_array('complete_registration',$modules) || in_array('users_registration',$modules) || in_array('user_addresses',$modules) || in_array('sellers',$modules) || in_array('self_registration',$modules) || in_array('users_ratechart',$modules) || in_array('users_courierpriority',$modules) || in_array('users_weightslab',$modules) || in_array('modifyuser',$modules) || in_array('open_ndr',$modules) || in_array('active_ndr',$modules) || in_array('closed_ndr',$modules) || in_array('update_tracking',$modules))
                {
                ?>
                    <li class="sidebar-header">
                        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Manage all ops related activities."><i class="fa fa-info-circle"></i></a></span>
                        <span class="sidebar-header-title">Operations</span>
                    </li>
                    <?php
                    if($session_role == 'SUPERADMIN' || in_array('master_cod_cycle',$modules) || in_array('master_billing_cycle',$modules) || in_array('master_pincodes',$modules) || in_array('master_pinservices',$modules) || in_array('master_weightslab',$modules) || in_array('master_zones',$modules))
                    {
                    ?>
                        <li class="<?php echo ($page_id == "master_cod_cycle" || $page_id == "master_billing_cycle" || $page_id == "master_pincodes" || $page_id == "master_pinservices" || $page_id == "master_weightslab" || $page_id == "master_zones" || $page_id == "promotions" || $page_id == "default_weightslab" || $page_id == "default_ratechart" || $page_id == "default_courier_priority" ? "active" : "");?>">
                            <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-dashboard sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Master</span></a>
                            <ul>
                            <?php
                            if($session_role == 'SUPERADMIN' || in_array('master_cod_cycle',$modules) || in_array('master_billing_cycle',$modules))
                            {
                            ?>
                                <li class="<?php echo ($page_id == "master_cod_cycle" || $page_id == "master_billing_cycle" ? "active" : "");?>">
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Cycles</a>
                                    <ul>
                                        <?php
                                        if($session_role == 'SUPERADMIN' || in_array('master_billing_cycle',$modules))
                                        {
                                        ?>
                                        <li>
                                            <a href="<?= base_url()?>master_billing_cycle" class="<?php echo ($page_id == "master_billing_cycle" ? "active" : "");?>">Billing Cycle</a>
                                        </li>
                                        <?php
                                        }
                                        if($session_role == 'SUPERADMIN' || in_array('master_cod_cycle',$modules))
                                        {
                                        ?>
                                        <li>
                                            <a href="<?= base_url()?>master_cod_cycle" class="<?php echo ($page_id == "master_cod_cycle" ? "active" : "");?>">COD Cycle</a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('master_weightslab',$modules))
                            {
                            ?>
                                <li>
                                    <a href="<?= base_url()?>master_weightslab" class="<?php echo ($page_id == "master_weightslab" ? "active" : "");?>">Weight Slab</a>
                                </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('master_pincodes',$modules) || in_array('master_pinservices',$modules))
                            {
                            ?>
                                <li class="<?php echo ($page_id == "master_pincodes" || $page_id == "master_pinservices" ? "active" : "");?>">
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Pincode</a>
                                    <ul>
                                    <?php
                                        if($session_role == 'SUPERADMIN' || in_array('master_pincodes',$modules))
                                        {
                                        ?>
                                        <li>
                                        <a href="<?= base_url()?>master_pincodes" class="<?php echo ($page_id == "master_pincodes" ? "active" : "");?>">Pincode List</a>
                                        </li>
                                        <?php
                                        }
                                        if($session_role == 'SUPERADMIN' || in_array('master_pinservices',$modules))
                                        {
                                        ?>
                                        <li>
                                        <a href="<?= base_url()?>master_pinservices" class="<?php echo ($page_id == "master_pinservices" ? "active" : "");?>">Pincodes Services</a>
                                        </li>
                                        <?php 
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('master_zones',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>master_zones" class="<?php echo ($page_id == "master_zones" ? "active" : "");?>">Zones</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('promotions',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>promo_code" class="<?php echo ($page_id == "promotions" ? "active" : "");?>">Promo Codes</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('promotions',$modules))
                                {
                                ?>
                                <li class="<?php echo ($page_id == "default_weightslab" || $page_id == "default_ratechart" || $page_id == "default_courier_priority" ? "active" : "");?>">
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Default Settings</a>
                                    <ul>
                                        <?php
                                        if($session_role == 'SUPERADMIN' || in_array('default_weightslab',$modules))
                                        {
                                            ?>
                                            <li>
                                                <a href="<?= base_url()?>default_weightslab" class="<?php echo ($page_id == "default_weightslab" ? "active" : "");?>">Weightslab</a>
                                            </li>
                                            <?php
                                        }
                                        if($session_role == 'SUPERADMIN' || in_array('default_ratechart',$modules))
                                        {
                                            ?>
                                            <li>
                                                <a href="<?= base_url()?>default_ratechart" class="<?php echo ($page_id == "default_ratechart" ? "active" : "");?>">Rate Chart</a>
                                            </li>
                                            <?php
                                        }
                                        if($session_role == 'SUPERADMIN' || in_array('default_ratechart',$modules))
                                            {
                                            ?>
                                            <li>
                                                <a href="<?= base_url()?>default_courier" class="<?php echo ($page_id == "default_courier_priority" ? "active" : "");?>">Courier Priority</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('users',$modules) || in_array('complete_registration',$modules) || in_array('users_registration',$modules) || in_array('user_addresses',$modules) || in_array('sellers',$modules) || in_array('self_registration',$modules) || in_array('users_ratechart',$modules) || in_array('users_courierpriority',$modules) || in_array('users_weightslab',$modules) || in_array('modifyuser',$modules))
                    {
                    ?>

                        <li class="<?php echo ($page_id == "users_registration" || $page_id == "users_manage" || $page_id == "users_courierpriority" || $page_id == "users_ratechart" || $page_id == "users_weightslab" || $page_id == "complete_registration" || $page_id == "user_address" || $page_id == "users_seller" ? "active" : "");?>">
                            <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-users sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Users</span></a>
                            <ul>
                                <?php
                                if($session_role == 'SUPERADMIN' || in_array('users',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>users" class="<?php echo ($page_id == "users_manage" || $page_id == "users_ratechart" || $page_id == "users_weightslab" || $page_id == "users_courierpriority" ? "active" : "");?>">Manage Users</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('complete_registration',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>complete_registration" class="<?php echo ($page_id == "complete_registration" ? "active" : "");?>">Complete Registration </a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('users_registration',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>users_registration" class="<?php echo ($page_id == "users_registration" ? "active" : "");?>">Register user</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('user_addresses',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>user_addresses" class="<?php echo ($page_id == "user_address" ? "active" : "");?>">Address / Warehouses</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('sellers',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url()?>sellers" class="<?php echo ($page_id == "users_seller" ? "active" : "");?>">User's Seller</a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('update_tracking',$modules))
                    {
                    ?>
                        <li class="<?php echo ($page_id == "tracking_update" ? "active" : "");?>">
                            <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-truck sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Shipments</span></a>
                            <ul>
                            <?php
                            if($session_role == 'SUPERADMIN' || in_array('update_tracking',$modules))
                            {
                            ?>
                                <li>
                                    <a href="<?= base_url()?>update_tracking" class="<?php echo ($page_id == "tracking_update" ? "active" : "");?>">Update Tracking</a>
                                </li>
                            <?php
                            } 
                            ?>
                            </ul>
                        </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('open_ndr',$modules) || in_array('active_ndr',$modules) || in_array('closed_ndr',$modules))
                    {
                    ?>
                        <li>
                            <a href="<?= base_url('reports/open_ndr');?>" class="<?php echo ($page_id == "report_ndr_open" || $page_id == "report_ndr_active" || $page_id == "report_ndr_closed" ? "active" : "");?>"><i class="gi gi-restart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">NDR</span></a>
                        </li>
                    <?php
                    }
                }
                if($session_role == 'SUPERADMIN' || in_array('change_status',$modules) || in_array('weight_update',$modules) || in_array('generate_invoice',$modules) || in_array('view_invoice',$modules) || in_array('add_payment',$modules) || in_array('generate_cod',$modules) || in_array('view_cods',$modules) || in_array('manage_balance',$modules))
                {
                ?>
                    <li class="sidebar-header">
                        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Manage finance/billing related activities."><i class="fa fa-info-circle"></i></a></span>
                        <span class="sidebar-header-title">Finance</span>
                    </li>
                    <?php
                    if($session_role == 'SUPERADMIN' || in_array('change_status',$modules))
                    {
                    ?>
                    <li>
                        <a href="<?= base_url()?>change_status" class="<?php echo ($page_id == "change_status" ? "active" : "");?>"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Change Status</span></a>
                    </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('weight_update',$modules) || in_array('generate_invoice',$modules) || in_array('manual_invoice',$modules) || in_array('view_invoice',$modules) || in_array('add_payment',$modules) || in_array('generate_cod',$modules) || in_array('view_cods',$modules) || in_array('user_weight_request',$modules))
                    {
                    ?>
                        <li class="<?php echo ($page_id == "weight_update" || $page_id == "generate_invoice" || $page_id == "manual_invoice" || $page_id == "view_invoice" || $page_id == "add_payment" || $page_id == "invoice" || $page_id == "generate_cod" || $page_id == "view_cods" || $page_id == "user_weight_request" ? "active" : "");?>">
                            <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-money sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Billing</span></a>
                            <ul>
                            <?php
                            if($session_role == 'SUPERADMIN' || in_array('weight_update',$modules) || in_array('user_weight_request',$modules))
                            {
                            ?>
                                <li>
                                    <a href="<?= base_url()?>weight_update" class="<?php echo ($page_id == "weight_update" || $page_id == "user_weight_request" ? "active" : "");?>">Update Weight</a>
                                </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('generate_invoice',$modules) || in_array('manual_invoice',$modules) || in_array('view_invoice',$modules) || in_array('add_payment',$modules))
                            {
                            ?>

                                <li class="<?php echo ($page_id == "generate_invoice" || $page_id == "manual_invoice" || $page_id == "invoice" || $page_id == "view_invoice" || $page_id == "add_payment" ? "active" : "");?>">
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Invoice</a>
                                    <ul>
                                    <?php
                                    if($session_role == 'SUPERADMIN' || in_array('generate_invoice',$modules))
                                    {
                                    ?>
                                        <li>
                                            <a href="<?= base_url()?>generate_invoice" class="<?php echo ($page_id == "generate_invoice" ? "active" : "");?>">Generate</a>
                                        </li>
                                    <?php
                                    }
                                    if($session_role == 'SUPERADMIN' || in_array('manual_invoice',$modules))
                                    {
                                    ?>
                                        <li>
                                            <a href="<?= base_url()?>manual_invoice" class="<?php echo ($page_id == "manual_invoice" ? "active" : "");?>">Create</a>
                                        </li>
                                    <?php
                                    }
                                    if($session_role == 'SUPERADMIN' || in_array('view_invoice',$modules))
                                    {
                                    ?>

                                        <li>
                                            <a href="<?= base_url()?>view_invoice" class="<?php echo ($page_id == "view_invoice" ? "active" : "");?>">View</a>
                                        </li>
                                    <?php
                                    }
                                    if($session_role == 'SUPERADMIN' || in_array('add_payment',$modules))
                                    {
                                    ?>
                                        <li>
                                            <a href="<?= base_url()?>add_payment" class="<?php echo ($page_id == "add_payment" ? "active" : "");?>">Add Payment</a>
                                        </li>
                                    <?php
                                    }
                                    ?>                      
                                    </ul>
                                </li>
                            <?php
                            }
                            if($session_role == 'SUPERADMIN' || in_array('generate_cod',$modules) || in_array('view_cods',$modules))
                            {
                            ?>
                                <li class="<?php echo ($page_id == "generate_cod" || $page_id == "view_cods" ? "active" : "");?>">
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>COD</a>
                                    <ul>
                                        <?php
                                        if($session_role == 'SUPERADMIN' || in_array('generate_cod',$modules))
                                        {
                                        ?>
                                        <li>
                                            <a href="<?= base_url()?>generate_cod" class="<?php echo ($page_id == "generate_cod" ? "active" : "");?>">Generate</a>
                                        </li>
                                        <?php
                                        }
                                        if($session_role == 'SUPERADMIN' || in_array('view_cods',$modules))
                                        {
                                        ?>
                                        <li>
                                            <a href="<?= base_url()?>view_cods" class="<?php echo ($page_id == "view_cods" ? "active" : "");?>">View</a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                        </li>
                    <?php 
                    }
                    if($session_role == 'SUPERADMIN' || in_array('manage_balance',$modules))
                    {
                    ?>
                    <li>
                        <a href="<?= base_url('manage_balance')?>" class="<?php echo ($page_id == "add_balance" ? "active" : "");?>"><i class="gi gi-money sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Add PX-Cash</span></a>
                    </li>
                <?php
                    }
                }
                if($session_role == 'SUPERADMIN' || in_array('reports/shipments',$modules) || in_array('reports/failedshipments',$modules) || in_array('reports/mis',$modules) || in_array('reports/viewbalance',$modules) || in_array('reports/allpayments',$modules) || in_array('reports/alltransactions',$modules) || in_array('reports/userledger',$modules) || in_array('reports/status_logs',$modules) || in_array('reports/shipments_billing',$modules) || in_array('reports/get_pickupid',$modules))
                {
                ?>

                    <li class="sidebar-header">
                        <span class="sidebar-header-options clearfix">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Search & View the reports"><i class="fa fa-info-circle"></i></a></span>
                        <span class="sidebar-header-title">Reports</span>
                    </li>
                    <?php
                    if($session_role == 'SUPERADMIN' || in_array('reports/shipments',$modules) || in_array('reports/failedshipments',$modules) || in_array('reports/mis',$modules) || in_array('reports/status_logs',$modules) || in_array('reports/billing_reports',$modules) || in_array('reports/get_pickupid',$modules))
                    {
                    ?>
                        <li class="<?php echo ($page_id == "shipments" || $page_id == "failed_shipments" || $page_id == "shipments_mis" || $page_id == "status_logs" || $page_id == "shipments_billing" || $page_id == "get_pickupid" ? "active" : "");?>">
                            <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-truck sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Shipments</span></a>
                            <ul>
                                <?php 
                                if($session_role == 'SUPERADMIN' || in_array('reports/shipments',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/shipments');?>" class="<?php echo ($page_id == "shipments" ? "active" : "");?>">Processed</a>
                                </li>
                                <?php 
                                }
                                if($session_role == 'SUPERADMIN' || in_array('reports/failedshipments',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/failedshipments');?>" class="<?php echo ($page_id == "failed_shipments" ? "active" : "");?>">Unprocessed/Failed</a>
                                </li>
                                <?php 
                                }
                                if($session_role == 'SUPERADMIN' || in_array('reports/mis',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/mis');?>" class="<?php echo ($page_id == "shipments_mis" ? "active" : "");?>">MIS Report</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('reports/status_logs',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/status_logs');?>" class="<?php echo ($page_id == "status_logs" ? "active" : "");?>">Status Logs</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('reports/billing_reports',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/shipments_billing');?>" class="<?php echo ($page_id == "shipments_billing" ? "active" : "");?>">Billing Report</a>
                                </li>
                                <?php
                                }
                                if($session_role == 'SUPERADMIN' || in_array('reports/get_pickupid',$modules))
                                {
                                ?>
                                <li>
                                    <a href="<?= base_url('reports/get_pickupid');?>" class="<?php echo ($page_id == "get_pickupid" ? "active" : "");?>">Pickup id</a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    if($session_role == 'SUPERADMIN' || in_array('reports/viewbalance',$modules) || in_array('reports/allpayments',$modules) || in_array('reports/alltransactions',$modules) || in_array('reports/userledger',$modules))
                    {
                    ?>

                    <li class="<?php echo ($page_id == "view_balance" || $page_id == "all_payments" || $page_id == "all_transactions" || $page_id == "user_ledger" ? "active" : "");?>">
                        <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-credit-card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Transactions</span></a>
                        <ul>
                            <?php
                            if($session_role == 'SUPERADMIN' || in_array('reports/viewbalance',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url('reports/viewbalance')?>" class="<?php echo ($page_id == "view_balance" ? "active" : "");?>">View Balance</a>
                            </li>
                            <?php 
                            }
                            if($session_role == 'SUPERADMIN' || in_array('reports/allpayments',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url('reports/allpayments')?>" class="<?php echo ($page_id == "all_payments" ? "active" : "");?>">Payments</a>
                            </li>
                            <?php 
                            }
                            if($session_role == 'SUPERADMIN' || in_array('reports/alltransactions',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url('reports/alltransactions')?>" class="<?php echo ($page_id == "all_transactions" ? "active" : "");?>">All Transactions</a>
                            </li>
                            <?php 
                            }
                            if($session_role == 'SUPERADMIN' || in_array('reports/userledger',$modules))
                            {
                            ?>
                            <li>
                                <a href="<?= base_url('reports/userledger')?>" class="<?php echo ($page_id == "user_ledger" ? "active" : "");?>">User Ledger</a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                    }
                }
                ?>
            </ul>
            <!-- END Sidebar Navigation -->
        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
</div>


<!-- 
<li class="<?php //echo ($page_id == "" || $page_id == "" ? "active" : "");?>">
    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>Credit Note</a>
    <ul>
        
        <li>
            <a href="" class="<?php //echo ($page_id == "" ? "active" : "");?>">Create</a>
        </li>

        <li>
            <a href="" class="<?php //echo ($page_id == "" ? "active" : "");?>">View</a>
        </li>
    </ul>
</li>

<li>
    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-shoe_steps sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Referrals</span></a>
    <ul>
        <li>
            <a href="#">Manage Affiliate</a>
        </li>
        <li>
            <a href="#">Change Affiliate </a>
        </li>
        <li>
            <a href="#">Manage partner</a>
        </li>
        <li>
            <a href="#">Change Partner</a>
        </li>
    </ul>
</li>

<li>
    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-bullhorn sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Promotions</span></a>
    <ul>
        <li>
            <a href="#">Promo Codes</a>
        </li>
    </ul>
</li> -->