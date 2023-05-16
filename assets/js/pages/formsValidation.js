/*
 *  Document   : formsValidation.js
 *  Author     : ParcelX
 *  Description: Custom javascript code used in Forms Validation page
 */

var FormsValidation = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

              /* Initialize Form Validation */
            $('#form_adminrole').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    role_name: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    role_name: {
                        required: 'Please enter a role name',
                        minlength: 'Role must consist of at least 3 characters'
                    }
                }
            });


            $('#form_adminmodule').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    module_parent: {
                        required: true
                    },
                    module_name: {
                        required: true
                    },
                    module_route: {
                        required: true
                    }
                },
                messages: {
                    module_parent: {
                        required: 'Please enter a module parent'
                    },
                    module_name: {
                        required: 'Please enter a module name'
                    },
                    module_route: {
                        required: 'Please enter a module route'
                    }
                }
            });


            $('#form_adminuser').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    admin_name: {
                        required: true,
                        minlength: 3
                    },
                    admin_email: {
                        required: true,
                        email: true
                    },
                    admin_phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true

                    },
                    admin_username: {
                        required: true,
                        minlength: 3
                    },
                    admin_password: {
                        required: true,
                        minlength: 5
                    },
                    admin_role: {
                        required: true
                    }
                },
                messages: {
                    admin_name: {
                        required: 'Please enter a full name',
                        minlength: 'Fullname must consist of at least 3 characters'
                    },
                    admin_email: {
                        required: 'Please enter a valid email',
                        email: 'Please enter a valid email address'
                    },
                    admin_phone: {
                        required: 'Please enter a mobile number',
                        minlength: 'Mobile number must be 10 digits',
                        maxlength: 'Mobile number must not be more than 10 digits',
                        digits: 'Please enter a valid mobile number'

                    },
                    admin_username: {
                        required: 'Please enter a username',
                        minlength: 'Username must consist of at least 5 characters'
                    },
                    admin_password: {
                        required: 'Please enter a password',
                        minlength: 'Password must consist of at least 5 characters'
                    },
                    admin_role: {
                        required: 'Please select role'
                    }
                }
            });



            $('#form_billingcycle').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    billingcycle_title: {
                        required: true
                    },
                    billingcycle_dates: {
                        required: true,
                        // regex : /^[1-9]\d*(,[1-9]\d)*$/
                        regex : /^[1-9]\d*(,\d+)*$/
                    }
                },
                messages: {
                    billingcycle_title: {
                        required: 'Please enter a title or name for billing cycle'
                    },
                    billingcycle_dates: {
                        required: 'Please enter atleast 1 date',
                        regex: 'Please enter valid date'
                    }
                }
            });


            $('#form_codcycle').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    codcycle_title: {
                        required: true
                    },
                    codcycle_dates: {
                        required: true,
                        regex : /^[1-9]\d*(,\d+)*$/
                    }
                },
                messages: {
                    codcycle_title: {
                        required: 'Please enter a title or name for COD cycle'
                    },
                    codcycle_dates: {
                        required: 'Please enter atleast 1 date',
                        regex: 'Please enter valid date'
                    }
                }
            });



            $('#form_transitpartner').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    transitpartner_name: {
                        required: true,
                        minlength: 3
                    },
                    logo_name: {
                        required: true
                    }
                },
                messages: {
                    transitpartner_name: {
                        required: 'Please enter a transit partner name',
                        minlength: 'Transit partner must consist of at least 3 characters'
                    },
                    logo_name: {
                        required: 'Please enter logo filename'
                    }
                }
            });


            $('#form_transitpartneraccounts').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    account_name: {
                        required: true,
                        minlength: 3
                    },
                    parent_id: {
                        required: true
                    },
                    base_weight: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    account_name: {
                        required: 'Please enter a account name',
                        minlength: 'Account name must consist of at least 3 characters'
                    },
                    parent_id: {
                        required: 'Please select atleast one partner'
                    },
                    base_weight: 'Please enter valid base weight',
                }
            });


            $('#form_weightslab').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    slab_title: {
                        required: true,
                        regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                    },
                    base_weight: {
                        required: true,
                        decimal: true
                    },
                    additional_weight: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    slab_title: 'Please enter valid title for weight slab',
                    base_weight: 'Please enter valid base weight',
                    additional_weight: 'Please enter valid additional weight'
                }
            });


            $('#form_pincode').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    f_pincode: {
                        required: true,
                        minlength: 6,
                        maxlength: 6,
                        digits: true

                    },
                    f_pin_city: {
                        required: true,
                        regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                    },
                    f_pin_state: {
                        required: true
                    }
                },
                messages: {
                    f_pincode: {
                        required: 'Please enter a pincode',
                        minlength: 'Pincode must consist of at least 6 characters',
                        maxlength: 'Pincode must consist not more than 6 characters',
                        digits: 'Please enter a valid pincode'
                    },
                    f_pin_city: {
                        required: 'Please enter a city name',
                        regex: 'Please enter valid city name'
                    },
                    f_pin_state: {
                        required: 'Please select atleast one state'
                    }
                }
            });

            $('#form_pincodeservices').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    account_id: {
                        required: true
                    },
                    pinservice_file: {
                        required: true
                    }
                },
                messages: {
                    pinservice_file: 'Please select excel or csv file to upload',
                    account_id: 'Please select atleast one value'
                }
            });

            $('#form_addzone').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    zone_file: {
                        required: true
                    }
                },
                messages: {
                    zone_file: 'Please select excel or csv file to upload'
                }
            });


            $('#form_updatezone').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    f_destination_pin: {
                        required: true,
                        minlength: 6,
                        maxlength: 6,
                        digits: true

                    },
                    f_source: {
                        required: true,
                        regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                    },
                    f_zone: {
                        required: true,
                        minlength: 1,
                        maxlength: 1,
                        regex : /^[a-fA-F]*$/
                    }
                },
                messages: {
                    f_destination_pin: {
                        required: 'Please enter a pincode',
                        minlength: 'Pincode must consist of at least 6 characters',
                        maxlength: 'Pincode must consist not more than 6 characters',
                        digits: 'Please enter a valid pincode'
                    },
                    f_source: {
                        required: 'Please enter a city name',
                        regex: 'Please enter valid city name'
                    },
                    f_zone: 'Please enter valid zone'
                }
            });


            $('#form_user_weightslab').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    "express_type[]": {
                        required: true
                    },
                    "weight_slab_id[]": {
                        required: true
                    }
                },
                messages: {
                    "express_type[]": 'Please select atleast 1 value',
                    "weight_slab_id[]": 'Please select atleast 1 value'
                }
            });


            $('#form_ratechart').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    "fwd_base_a[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_a[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_a[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_a[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_a[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_a[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_b[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_b[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_b[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_b[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_b[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_b[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_c[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_c[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_c[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_c[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_c[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_c[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_d[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_d[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_d[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_d[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_d[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_d[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_e[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_e[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_e[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_e[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_e[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_e[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_f[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_f[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_f[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_f[]": {
                        required: true,
                        decimal: true
                    },
                    "surcharge_f[]": {
                        required: true,
                        decimal: true
                    },
                    "ndd_f[]": {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    "fwd_base_a[]": 'Please enter valid rate',
                    "fwd_addon_a[]": 'Please enter valid rate',
                    "rto_base_a[]": 'Please enter valid rate',
                    "rto_addon_a[]": 'Please enter valid rate',
                    "surcharge_a[]": 'Please enter valid rate',
                    "ndd_a[]": 'Please enter valid rate',
                    "fwd_base_b[]": 'Please enter valid rate',
                    "fwd_addon_b[]": 'Please enter valid rate',
                    "rto_base_b[]": 'Please enter valid rate',
                    "rto_addon_b[]": 'Please enter valid rate',
                    "surcharge_b[]": 'Please enter valid rate',
                    "ndd_b[]": 'Please enter valid rate',
                    "fwd_base_c[]": 'Please enter valid rate',
                    "fwd_addon_c[]": 'Please enter valid rate',
                    "rto_base_c[]": 'Please enter valid rate',
                    "rto_addon_c[]": 'Please enter valid rate',
                    "surcharge_c[]": 'Please enter valid rate',
                    "ndd_c[]": 'Please enter valid rate',
                    "fwd_base_d[]": 'Please enter valid rate',
                    "fwd_addon_d[]": 'Please enter valid rate',
                    "rto_base_d[]": 'Please enter valid rate',
                    "rto_addon_d[]": 'Please enter valid rate',
                    "surcharge_d[]": 'Please enter valid rate',
                    "ndd_d[]": 'Please enter valid rate',
                    "fwd_base_e[]": 'Please enter valid rate',
                    "fwd_addon_e[]": 'Please enter valid rate',
                    "rto_base_e[]": 'Please enter valid rate',
                    "rto_addon_e[]": 'Please enter valid rate',
                    "surcharge_e[]": 'Please enter valid rate',
                    "ndd_e[]": 'Please enter valid rate',
                    "fwd_base_f[]": 'Please enter valid rate',
                    "fwd_addon_f[]": 'Please enter valid rate',
                    "rto_base_f[]": 'Please enter valid rate',
                    "rto_addon_f[]": 'Please enter valid rate',
                    "surcharge_f[]": 'Please enter valid rate',
                    "ndd_f[]": 'Please enter valid rate'
                }
            });


            $('#form_courierpriority').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                }
            });

            $('#form_users_courierpriority').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                }
            });

            $('#form_default_users_ratechart').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    "fwd_base_a[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_a[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_a[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_a[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_b[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_b[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_b[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_b[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_c[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_c[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_c[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_c[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_d[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_d[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_d[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_d[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_e[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_e[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_e[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_e[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_base_f[]": {
                        required: true,
                        decimal: true
                    },
                    "fwd_addon_f[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_base_f[]": {
                        required: true,
                        decimal: true
                    },
                    "rto_addon_f[]": {
                        required: true,
                        decimal: true
                    },
                },
                messages: {
                    "fwd_base_a[]": 'Please enter valid rate',
                    "fwd_addon_a[]": 'Please enter valid rate',
                    "rto_base_a[]": 'Please enter valid rate',
                    "rto_addon_a[]": 'Please enter valid rate',
                    "fwd_base_b[]": 'Please enter valid rate',
                    "fwd_addon_b[]": 'Please enter valid rate',
                    "rto_base_b[]": 'Please enter valid rate',
                    "rto_addon_b[]": 'Please enter valid rate',
                    "fwd_base_c[]": 'Please enter valid rate',
                    "fwd_addon_c[]": 'Please enter valid rate',
                    "rto_base_c[]": 'Please enter valid rate',
                    "rto_addon_c[]": 'Please enter valid rate',
                    "fwd_base_d[]": 'Please enter valid rate',
                    "fwd_addon_d[]": 'Please enter valid rate',
                    "rto_base_d[]": 'Please enter valid rate',
                    "rto_addon_d[]": 'Please enter valid rate',
                    "fwd_base_e[]": 'Please enter valid rate',
                    "fwd_addon_e[]": 'Please enter valid rate',
                    "rto_base_e[]": 'Please enter valid rate',
                    "rto_addon_e[]": 'Please enter valid rate',
                    "fwd_base_f[]": 'Please enter valid rate',
                    "fwd_addon_f[]": 'Please enter valid rate',
                    "rto_base_f[]": 'Please enter valid rate',
                    "rto_addon_f[]": 'Please enter valid rate',
                }
            });


            $('#form_managebalance').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    username: {
                        required: true
                    },
                    user_id: {
                        required: true
                    },
                    total_balance: {
                        required: true,
                        decimal: true
                    },
                    main_bal: {
                        required: true,
                        balance: true
                    },
                    promo_bal: {
                        required: true,
                        balance: true
                    },
                    balance_type: {
                        required: true
                    },
                    action_type: {
                        required: true
                    },
                    transaction_amount: {
                        required: true,
                        decimal:true
                    },
                    transaction_remark: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: 'Please enter a valid username'
                    },
                    user_id: {
                        required: 'Please enter a valid username'
                    },
                    balance_type: {
                        required: 'Please select atleast 1 value'
                    },
                    action_type: {
                        required: 'Please select atleast 1 value',
                    },
                    transaction_amount: {
                        required: 'Please enter a amount',
                        decimal: 'Please enter a valid amount'
                    },
                    transaction_remark: {
                        required: 'Please enter remark'
                    }
                }
            });


            $('#form_viewinvoice').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    invoice_number: {
                        required: true,
                        digits: true
                    },
                    user_id: {
                        required: true
                    },
                    payment_date: {
                        required: true
                    },
                    payment_amount: {
                        required: true,
                        decimal: true,
                        lessThanEqual: '#due_amount'
                    },
                    payment_mode: {
                        required: true
                    }
                },
                messages: {
                    invoice_number: 'Enter valid invoice #',
                    payment_mode: 'Please select atleast 1 value',
                    payment_amount: {
                        required : 'Enter valid amount',
                        decimal : 'Enter valid amount',
                        lessThanEqual : 'Paying amount should be less than or equal to <b>due amount</b>',
                    }
                }
            });

            $('#form_userledger').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    username: {
                        required: true
                    }
                },
                messages: {
                    username: 'Please enter username to view ledger'
                }
            });

            $('#form_remit').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    action_amount: {
                        required: true,
                        decimal: true,
                        lessThanEqual: '#action_amount_check'
                    },
                    action_date: {
                        required: true                       
                    },
                    cid: {
                        required: true                       
                    },
                    userid: {
                        required: true                      
                    },
                    action_against: {
                        required: true                      
                    }

                },
                messages: {
                    action_amount: {
                        required : 'Amount is required & cannot be null',
                        decimal : 'Please enter valid amount',
                        lessThanEqual : 'Paying amount should be less than or equal to <b>due amount</b>',
                    },
                    action_date: 'Date is required & cannot be null',
                    action_against: 'UTR# is required & cannot be null',
                    cid: 'invalid cid',
                    userid: 'invalid userid'
                }
            });

            /* Users modules Form Validation */
            $('#form_usersmodule').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.component-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    module_parent: {
                        required: true
                    },
                    module_name: {
                        required: true
                    },
                    module_route: {
                        required: true
                    }
                },
                messages: {
                    module_parent: {
                        required: 'Please enter a module parent'
                    },
                    module_name: {
                        required: 'Please enter a module name'
                    },
                    module_route: {
                        required: 'Please enter a module route'
                    }
                }
            });
            /* Initialize Form Validation */
            $('#form-validation').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    role_name: {
                        required: true,
                        minlength: 3
                    },
                    val_email: {
                        required: true,
                        email: true
                    },
                    val_password: {
                        required: true,
                        minlength: 5
                    },
                    val_confirm_password: {
                        required: true,
                        equalTo: '#val_password'
                    },
                    val_bio: {
                        required: true,
                        minlength: 5
                    },
                    val_skill: {
                        required: true
                    },
                    val_website: {
                        required: true,
                        url: true
                    },
                    val_digits: {
                        required: true,
                        digits: true
                    },
                    val_number: {
                        required: true,
                        number: true
                    },
                    val_range: {
                        required: true,
                        range: [1, 1000]
                    },
                    val_terms: {
                        required: true
                    }
                },
                messages: {
                    role_name: {
                        required: 'Please enter a username',
                        minlength: 'Your username must consist of at least 3 characters'
                    },
                    val_email: 'Please enter a valid email address',
                    val_password: {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    val_confirm_password: {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long',
                        equalTo: 'Please enter the same password as above'
                    },
                    val_bio: 'Don\'t be shy, share something with us :-)',
                    val_skill: 'Please select a skill!',
                    val_website: 'Please enter your website!',
                    val_digits: 'Please enter only digits!',
                    val_number: 'Please enter a number!',
                    val_range: 'Please enter a number between 1 and 1000!',
                    val_terms: 'You must agree to the service terms!'
                }
            });

            /* site management Form Validation */
            $('#form_portal_settings').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    // e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    site_portal: {
                        required: true
                    },
                    admin_siteManage: {
                        required: true
                    }
                },
                messages: {
                    site_portal: {
                        required : 'Please select portal type',
                    },
                    admin_siteManage: {
                        required : 'Please select manage type',
                    }
                }
            });


        }
    };
}();




 $.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        var check = false;
        return this.optional(element) || regexp.test(value);
    },"Please check your input");

$.validator.addMethod(
    "decimal",
    function(value, element) {
        return this.optional(element) || /^\d{0,10}(\.\d{0,2})?$/i.test(value);
    }, "Please check your input");

$.validator.addMethod(
    "percent",
    function(value, element) {
        return this.optional(element) || /^\d{0,3}(\.\d{0,2})?$/i.test(value);
    }, "Please check your input");


$.validator.addMethod(
    "notEqual",
    function(value, element, param) {
 return this.optional(element) || value != $(param).val();
}, "This has to be different from one selected");


$.validator.addMethod(
    "decimalrate",
    function(value, element) {
        return this.optional(element) || /^\d{0,10}(\.\d{0,2})?$/i.test(value);
    }, "Enter rate in valid format");

$.validator.addMethod(
    "balance",
    function(value, element) {
        return this.optional(element) || /^-?\d{0,10}(\.\d{0,2})?$/i.test(value);
    }, "Please check your input");

$.validator.addMethod(
    'lessThanEqual',
    function(value, element, param) {
        return this.optional(element) || parseFloat(value) <= parseFloat($(param).val());
    }, "The value {0} must be less thanor equal to {1}");

function removespace(element) {
    $("#"+element).val($("#"+element).val().replace(/\s\s+/g, ' ').trim());
}