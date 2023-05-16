<!-- NDR Tabs & Options -->
<!-- Pills -->
<div class="col-md-12">
    <div class="block-section" style="background-color: #dbdcde;">
        <ul class="nav nav-pills">
            <li class="<?php echo ($page_id == "report_ndr_open" ? "active" : "");?>">
                <a href="<?= base_url('reports/open_ndr');?>" style="font-weight: 700; font-size: 14px; color: <?php echo ($page_id == "report_ndr_open" ? "" : "#000")?>;">Open</a>
            </li>
            <li class="<?php echo ($page_id == "report_ndr_active" ? "active" : "");?>">
                <a href="<?= base_url('reports/active_ndr');?>" style="font-weight: 700; font-size: 14px; color: <?php echo ($page_id == "report_ndr_active" ? "" : "#000")?>;">Active</a>
            </li>
            <li class="<?php echo ($page_id == "report_ndr_closed" ? "active" : "");?>">
                <a href="<?= base_url('reports/closed_ndr');?>" style="font-weight: 700; font-size: 14px; color: <?php echo ($page_id == "report_ndr_closed" ? "" : "#000")?>;">Closed</a>
            </li>
        </ul>
    </div>
</div>
<!-- END Pills -->