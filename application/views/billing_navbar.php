<ul class="nav-horizontal text-center">
    <!-- <li class="<?php // echo ($page_id == "change_status" ? "active" : "");?>">
        <a href="change_status"><i class="fa fa-bar-chart"></i> Change Status</a>
    </li> -->
    <li class="<?php echo ($page_id == "weight_update" ? "active" : "");?>">
        <a href="weight_update"><i class="fa fa-balance-scale"></i> Update Weight</a>
    </li>
    <li class="<?php echo ($page_id == "generate_invoice" ? "active" : "");?>">
        <a href="generate_invoice"><i class="fa fa-file-text-o"></i> Generate Invoice</a>
    </li>
    <li class="<?php echo ($page_id == "manual_invoice" ? "active" : "");?>">
        <a href="manual_invoice"><i class="fa fa-file-text-o"></i> Manual Invoice</a>
    </li>
    <li class="<?php echo ($page_id == "view_invoice" ? "active" : "");?>">
        <a href="view_invoice"><i class="fa fa-file-pdf-o"></i> View Invoice</a>
    </li>
    <li class="<?php echo ($page_id == "add_payment" ? "active" : "");?>">
        <a href="add_payment"><i class="gi gi-money"></i> Add Payment</a>
    </li>
    <li class="<?php echo ($page_id == "generate_cod" ? "active" : "");?>">
        <a href="generate_cod"><i class="fa fa-money"></i> Generate COD</a>
    </li>
    <li class="<?php echo ($page_id == "view_cods" ? "active" : "");?>">
        <a href="view_cods"><i class="fa fa-paper-plane-o"></i> View COD</a>
    </li>
</ul>