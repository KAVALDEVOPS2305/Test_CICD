<?php
$page_id = 'error_401';
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php require_once('head.php'); ?>
    </head>
    <body>
        <!-- Error Container -->
        <div id="error-container">
            <div class="error-options">
                <h3><i class="fa fa-chevron-circle-left text-muted"></i> <a href="<?= base_url('dashboard');?>">Go Back</a></h3>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <h1 class="animation-pulse"><i class="fa fa-times-circle-o text-danger"></i> 401</h1>
                    <h2 class="h3">Oops, we are sorry but you are not authorized to access this page...!!</h2>
                </div>
            </div>
        </div>
        <!-- END Error Container -->
    </body>
</html>