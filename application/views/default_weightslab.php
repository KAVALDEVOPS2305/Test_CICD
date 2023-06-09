<?php
$page_id = 'default_weightslab';
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
                <?php require_once('sidebar-right.php'); ?>
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
                            <li>Users </li>
                            <li><a href="javascript:void">Default Weight Slab</a></li>
                        </ul>
                        <!-- END Header -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <h2>Add <strong>Default Weight Slab</strong></h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    <form method="post" id="form_user_weightslab" class="form-horizontal form-bordered" onsubmit="return false;">
                                        <div class="div_add_slab" id="div_add_slab">
                                        <?php 
                                        $result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');
                                        $dslab_data = $this->db->where('status','1')->get('default_weightslab')->result_array();
                                        $current_record = 0;
                                        if(isset($dslab_data) && !empty($dslab_data) && count($dslab_data)>0){
                                            $current_record = count($dslab_data);
                                            foreach($dslab_data as $slab_key=>$slab_data){ ?>
                                                <div class="form-group" id="row<?php echo $slab_key?>">
                                                    <div class="component-group">
                                                        <label class="col-md-2 control-label" for="express_type">Express Type<span class="text-danger">*</span></label>
                                                        <div class="col-md-3">
                                                            <select name="express_type[]" id="express_type" class="form-control">
                                                                <option value="">-- Select Express --</option>
                                                                <option value="air" <?php echo $slab_data['express'] == "air"?"selected":""?> >Air</option>
                                                                <option value="surface" <?php echo $slab_data['express'] == "surface"?"selected":""?>>Surface</option>
                                                            </select> 
                                                        </div>
                                                    </div>

                                                    <div class="component-group">
                                                    <label class="col-md-2 control-label">Weight Slab</label>
                                                    <div class="col-md-3">
                                                        <select name="weight_slab_id[]" id="weight_slab_id" class="form-control">
                                                            <option value=""> -- Select Weight Slab -- </option>
                                                            <?php     
                                                            //$result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');
                                                            // print_r($this->db->last_query());
                                                            foreach($result->result() as $row)
                                                            {
                                                            ?>
                                                            <option value="<?php echo $row->weightslab_id; ?>" <?php echo $slab_data['weightslab_id'] == $row->weightslab_id?"selected":""?>><?php echo $row->slab_title; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    </div>
                                                    <?php if($slab_key == 0){?>
                                                        <div class="component-group">
                                                            <div class="col-md-1 col-md-offset-1">
                                                                <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Add more slabs" id="btn_add_slab" name="btn_add_slab"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="component-group"><div class="col-md-1"><button type="button" class="btn btn-sm btn-danger btn_remove_slab" data-toggle="tooltip" title="Remove Slab" id="<?php echo $slab_key; ?>" name="btn_remove_slab"><i class="fa fa-trash-o"></i></button></div></div>
                                                    <?php } ?>

                                                </div>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <div class="form-group" id="row0">
                                                <div class="component-group">
                                                    <label class="col-md-2 control-label" for="express_type">Express Type<span class="text-danger">*</span></label>
                                                    <div class="col-md-3">
                                                        <select name="express_type[]" id="express_type" class="form-control">
                                                            <option value="">-- Select Express --</option>
                                                            <option value="air">Air</option>
                                                            <option value="surface">Surface</option>
                                                        </select> 
                                                    </div>
                                                </div>

                                                <div class="component-group">
                                                <label class="col-md-2 control-label">Weight Slab</label>
                                                <div class="col-md-3">
                                                    <select name="weight_slab_id[]" id="weight_slab_id" class="form-control">
                                                        <option value=""> -- Select Weight Slab -- </option>
                                                        <?php     
                                                        //$result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');
                                                        // print_r($this->db->last_query());
                                                        foreach($result->result() as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row->weightslab_id; ?>"><?php echo $row->slab_title; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="component-group">
                                                    <div class="col-md-1 col-md-offset-1">
                                                        <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Add more slabs" id="btn_add_slab" name="btn_add_slab"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                            <?php 
                                        } ?>
                                        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-12 col-md-offset-2">
                                                <button type="submit" class="btn btn-sm btn-success" id="savebtn" name="savebtn"><i class="fa fa-save"></i> Submit</button>
                                                
                                                <button type="reset" class="btn btn-sm btn-primary" id="resetbtn"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->                                
                            </div>
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

            $('#form_user_weightslab').on('submit', function(e)
            {
                if($("#form_user_weightslab").valid())
                    ins_data("form_user_weightslab","<?= base_url();?>actioninsert/default_users_weightslab");
                else
                    e.preventDefault();        
            });

            var i = `<?php echo $current_record; ?>`;
            //var i=0;  
	        $('#btn_add_slab').click(function()
	        {  
	            i++;
	            // alert(i);
	            var append_text='';

	            append_text += '<div class="form-group" id="row'+i+'"><div class="component-group">';
	            append_text += '<label class="col-md-2 control-label" for="express_type[]">Express Type<span class="text-danger">*</span></label>';

	            append_text += '<div class="col-md-3"><select name="express_type[]" id="express_type" class="form-control">';

	            append_text += '<option value="">-- Select Express --</option><option value="air">Air</option><option value="surface">Surface</option>';
	            append_text += '</select> </div></div>';
	            append_text += '<div class="component-group"><label class="col-md-2 control-label" for="weight_slab_id[]">Weight Slab<span class="text-danger">*</span></label>';

	            append_text += '<div class="col-md-3"><select name="weight_slab_id[]" id="weight_slab_id" class="form-control">';
	            append_text += '<option value="">-- Select weight slab --</option>';

	            append_text += '<?php $result=$this->db->where('slab_status =','1')->order_by('slab_title', 'ASC')->get('master_weightslab');foreach($result->result() as $row){?>';

	            append_text += '<option value="<?php echo $row->weightslab_id; ?>"><?php echo $row->slab_title; ?></option><?php }?>';

	            append_text += '</select></div></div>';
	            append_text += '<div class="component-group"><div class="col-md-1">';
	                            
	            append_text += '<button type="button" class="btn btn-sm btn-danger btn_remove_slab" data-toggle="tooltip" title="Remove Slab" id="'+i+'" name="btn_remove_slab"><i class="fa fa-trash-o"></i></button>';
	            append_text += '</div></div></div>';

	            // alert(i);
	            $('#div_add_slab').append(append_text);
	        });

	        $(document).on('click', '.btn_remove_slab', function ()
	        {  
	            var button_id = $(this).attr("id");
	            // alert(button_id);
	            $('#row'+button_id+'').remove(); 
	        });
        </script>

    </body>
</html>