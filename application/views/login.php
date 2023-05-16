<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>InTargos | Admin Login</title>

        <meta name="description" content="">
        <meta name="author" content="InTargos">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?= base_url();?>assets/img/favicon.ico">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?= base_url();?>assets/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?= base_url();?>assets/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?= base_url();?>assets/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?= base_url();?>assets/js/vendor/modernizr.min.js"></script>
    </head>
    <body>
        <!-- Login Full Background -->
        <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
        <?php
            $result=$this->db->select('wallpaper_path,notice_text')->where('site_type','admin')->where('update_status','1')->get('tbl_sitemanagement')->result();
            foreach($result as $key=>$value)
            {
                if(!empty($value->wallpaper_path) )
                    $walpaper = $value->wallpaper_path;
                if(!empty($value->notice_text) )
                    $notice = $value->notice_text;
            }
            // echo $walpaper;
            // echo $notice;
            // _print_r($result);
            $container = 'ikrarfiles';
            $bg_img = get_blob_file($container,$walpaper);
        ?>
        <img src="<?php echo !empty($walpaper)?$bg_img:base_url().'assets/uploads/site_banner_admin/bg.jpg' ?>" alt="InTargos" class="full-bg animation-pulseSlow">
        <!-- END Login Full Background -->

        <marquee onMouseOver="this.stop()" onMouseOut="this.start()" scrollamount="5" style="font-size: 25px;color: #fff;font-family: 'math';font-weight: bold;padding-top: 10px;"><?php echo !empty($notice)?$notice:'' ?></marquee>
        <!-- Login Container -->
        <div id="login-container" class="animation-fadeInQuickInv">
            <!-- Login Title -->
            <div class="login-title text-center">
                <h1><i class="gi gi-chevron-right"></i> <strong>InTargos</strong><br>
                    <small>Login using <strong>Admin</strong> credentials</small>
                </h1>
            </div>
            <!-- END Login Title -->

            <!-- Login Block -->
            <div class="block push-bit">
                <!-- Login Form -->
                <form method="POST" id="form_login" class="form-horizontal form-bordered form-control-borderless">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                <input type="text" id="login_username" name="login_username" class="form-control input-lg" placeholder="Username">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <input type="password" id="login_password" name="login_password" class="form-control input-lg" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                            
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-sign-in"></i> Login to Dashboard</button>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <a href="javascript:void(0)" id="link-reminder-login"><small>Forgot password?</small></a> -
                            <a href="javascript:void(0)" id="link-register-login"><small>Create a new account</small></a>
                        </div>
                    </div> -->
                </form>
                <!-- END Login Form -->

            </div>
            <!-- END Login Block -->
        </div>
        <!-- END Login Container -->

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
        <script src="<?= base_url();?>assets/js/vendor/jquery.min.js"></script>
        <script src="<?= base_url();?>assets/js/vendor/bootstrap.min.js"></script>
        <script src="<?= base_url();?>assets/js/plugins.js"></script>
        <script src="<?= base_url();?>assets/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?= base_url();?>assets/js/pages/login.js"></script>
        <script src="<?= base_url();?>assets/js/pages/uiProgress.js"></script>

        <script src="<?= base_url();?>assets/js/customjs.js"></script>
        
        <script>
            $(function(){ 
                    Login.init(); 
                    UiProgress.init();
                });

            $('#form_login').submit(function(e)
            {
                e.preventDefault();
                //alert();
                logincheck("form_login","<?= base_url();?>");            
            });
        </script>
    </body>
</html>