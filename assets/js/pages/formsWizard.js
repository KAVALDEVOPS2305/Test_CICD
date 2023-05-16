/*
 *  Document   : formsWizard.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Wizard page
 */

var FormsWizard = function() {

    return {
        init: function() {
            /*
             *  Jquery Wizard, Check out more examples and documentation at http://www.thecodemine.org
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Initialize Progress Wizard */
            $('#progress-wizard').formwizard({focusFirstInput: true, disableUIStyles: true, inDuration: 0, outDuration: 0});

            // Get the progress bar and change its width when a step is shown
            var progressBar = $('#progress-bar-wizard');
            progressBar
                .css('width', '33%')
                .attr('aria-valuenow', '33');

            $("#progress-wizard").bind('step_shown', function(event, data){
		if (data.currentStep === 'progress-first') {
                    progressBar
                        .css('width', '33%')
                        .attr('aria-valuenow', '33')
                        .removeClass('progress-bar-warning progress-bar-success')
                        .addClass('progress-bar-danger');
                }
                else if (data.currentStep === 'progress-second') {
                    progressBar
                        .css('width', '66%')
                        .attr('aria-valuenow', '66')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-warning');
                }
                else if (data.currentStep === 'progress-third') {
                    progressBar
                        .css('width', '100%')
                        .attr('aria-valuenow', '100')
                        .removeClass('progress-bar-danger progress-bar-warning')
                        .addClass('progress-bar-success');
                }
            });

            /* Initialize Basic Wizard */
            $('#basic-wizard').formwizard({disableUIStyles: true, inDuration: 0, outDuration: 0});

            /* Initialize Advanced Wizard with Validation */
            $('#advanced-wizard').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
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
                        val_username: {
                            required: true,
                            minlength: 2
                        },
                        val_password: {
                            required: true,
                            minlength: 5
                        },
                        val_confirm_password: {
                            required: true,
                            equalTo: '#val_password'
                        },
                        val_email: {
                            required: true,
                            email: true
                        },
                        val_terms: {
                            required: true
                        }
                    },
                    messages: {
                        val_username: {
                            required: 'Please enter a username',
                            minlength: 'Your username must consist of at least 2 characters'
                        },
                        val_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long'
                        },
                        val_confirm_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long',
                            equalTo: 'Please enter the same password as above'
                        },
                        val_email: 'Please enter a valid email address',
                        val_terms: 'Please accept the terms to continue'
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            /* Initialize Clickable Wizard */
            var clickableWizard = $('#form_userregistration');

            clickableWizard.formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.component-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.component-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        // You can use the following if you would like to highlight with green color the input after successful validation!
                        // e.closest('.component-group').removeClass('has-success has-error');
                        e.closest('.component-group').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        fullname: {
                            required: true,
                            minlength: 3
                        },
                        email_id: {
                            required: true,
                            email: true
                        },
                        contact: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            digits: true
                        },
                        alt_contact: {
                            digits: true
                        },
                        business_name: {
                            required: true,
                            minlength: 3,
                            regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        business_type: {
                            required: true
                        },
                        billing_type: {
                            required: true
                        },
                        liability_amount: {
                            required: true,
                            decimal: true
                        },
                        ndd_charges: {
                            required: true,
                            decimal: true
                        },
                        insurance_charges: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        },
                        capping_amount: {
                            required: true,
                            decimal: true
                        },
                        restrict_amount: {
                            required: true,
                            decimal: true
                        },
                        credit_period: {
                            required: true,
                            digits: true
                        },
                        agreement_doc: {
                            required: true
                        },
                        referral_type: {
                            required: true
                        },
                        referred_by: {
                            required: true
                        },
                        "express_type[]": {
                            required: true
                        },
                        "weight_slab_id[]": {
                            required: true
                        },
                        // heavy_surface_e: {
                        //     required: true,
                        //     decimal:true
                        // },
                        category_level: {
                            required: true
                        },
                        codgap: {
                            required: true,
                            digits: true
                        },
                        billing_cycle_id: {
                            required: true
                        },
                        cod_cycle_id: {
                            required: true
                        },
                        cod_fees_amt: {
                            required: true,
                            decimal: true
                        },
                        cod_fees_per: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        },
                        awb_charges: {
                            decimal: true
                        },
                        fsc_rate: {
                            percent: true,
                            range: [0, 100]
                        },
                        surcharge_3: {
                            decimal: true
                        },
                        surcharge_4: {
                            percent: true,
                            range: [0, 100]
                        },
                        billing_address: {
                            required: true,
                            minlength: 3,
                            regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        billing_state: {
                            required: true
                        },
                        cancelled_cheque: {
                            required: true
                        },
                        beneficiary_name: {
                            required: true,
                            regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        account_number: {
                            required: true,
                            digits: true
                        },
                        ifsc_code: {
                            required: true
                            // regex: /^[A-Za-z]{4}\d{7}$/
                        },
                        bank_name: {
                            required: true,
                            regex: /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        branch_name: {
                            required: true,
                            regex: /^[a-zA-Z0-9\s\-_.,&()]*$/
                        },
                        kyc_pan: {
                            required: true,
                            regex: /^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/
                        },
                        kyc_pan_doc: {
                            required: true
                        },
                        kyc_gst_reg: {
                            required: true
                        },
                        kyc_doctype: {
                            required: true
                        },
                        kyc_doc_number: {
                            required: true,
                            regex: /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        kyc_document: {
                            required: true
                        },
                        tan_number: {
                            regex: /^[A-Za-z]{4}\d{5}[A-Za-z]{1}$/
                        },
                        sales_poc_id: {
                            required: true
                        },
                        ops_poc_id: {
                            required: true
                        },
                        ndr_poc_id: {
                            required: true
                        },
                        pickup_poc_id: {
                            required: true
                        },
                        finance_poc_id: {
                            required: true
                        }
                        
                    },
                    messages: {
                        fullname: {
                            required: 'Please enter a fullname',
                            minlength: 'Fullname must consist of at least 3 characters'
                        },
                        contact: {
                            required: 'Please enter a mobile number',
                            minlength: 'Mobile number must be 10 digits',
                            maxlength: 'Mobile number must not be more than 10 digits',
                            digits: 'Please enter a valid mobile number'
                        },
                        business_name: {
                            required: 'Please enter a business name',
                            minlength: 'Business name must consist of at least 3 characters',
                            regex: 'Please enter valid business name'
                        },
                        business_type: {
                            required: 'Please select business type'
                        },
                        billing_type: {
                            required: 'Please select billing type'
                        },
                        liability_amount: {
                            required: 'Please enter liability amount',
                            decimal: 'Please enter valid liability amount'
                        },
                        ndd_charges: {
                            required: 'Please enter NDD charges',
                            decimal: 'Please enter valid NDD charges'
                        },
                        insurance_charges: {
                            required: 'Please enter a insurance charges',
                            percent: 'Please enter valid insurance charges',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        capping_amount: {
                            required: 'Please enter capping amount',
                            decimal: 'Please enter valid capping amount'
                        },
                        restrict_amount: {
                            required: 'Please enter restrict amount',
                            decimal: 'Please enter valid restrict amount'
                        },
                        credit_period: {
                            required: 'Please enter a credit period',
                            digits: 'Please enter a valid credit period'
                        },
                        referral_type: {
                            required: 'Please select referral type'
                        },
                        referred_by: {
                            required: 'Please select referred by'
                        },
                        "express_type[]": {
                            required: 'Please select expresss'
                        },
                        "weight_slab_id[]": {
                            required: 'Please select weight slab'
                        },
                        category_level: {
                            required: 'Please select category'
                        },
                        codgap: {
                            required: 'Please enter COD gap in days',
                            digits: 'Please enter valid COD gap in days'
                        },
                        billing_cycle_id: {
                            required: 'Please select billing cycle'
                        },
                        cod_cycle_id: {
                            required: 'Please select COD cycle'
                        },
                        cod_fees_amt: {
                            required: 'Please enter COD Fees',
                            decimal: 'Please enter valid COD Fees'
                        },
                        cod_fees_per: {
                            required: 'Please enter COD Fees percent',
                            percent: 'Please enter valid COD Fees percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        awb_charges: {
                            decimal: 'Please enter valid awb charges'
                        },
                        fsc_rate: {
                            percent: 'Please enter valid FSC percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        surcharge_3: {
                            decimal: 'Please enter valid Surcharge amount'
                        },
                        surcharge_4: {
                            percent: 'Please enter valid Surcharge percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        billing_address: {
                            required: 'Please enter billing address',
                            minlength: 'Address must consist of at least 3 characters',
                            regex: 'Please enter valid address'
                        },
                        billing_state: {
                            required: 'Please select state'
                        },
                        cancelled_cheque: {
                            required: 'Please upload cancelled cheque'
                        },
                        beneficiary_name: {
                            required: 'Please enter COD name',
                            regex: 'Please enter valid name'
                        },
                        account_number: {
                            required: 'Please enter account number',
                            digits: 'Please enter valid account number'
                        },
                        ifsc_code: {
                            required: 'Please enter ifsc code',
                            regex: 'Please enter ifsc code in valid format'
                        },
                        bank_name: {
                            required: 'Please enter bank name',
                            regex: 'Please enter valid bank name'
                        },
                        branch_name: {
                            required: 'Please enter branch name',
                            regex: 'Please enter valid branch name'
                        },
                        kyc_pan: {
                            required: 'Please enter PAN',
                            regex: 'Please enter PAN in valid format'
                        },
                        kyc_pan_doc: {
                            required: 'Please upload PAN Card'
                        },
                        kyc_gst_reg: {
                            required: 'Please select any value'
                        },
                        kyc_doctype: {
                            required: 'Please enter document type'
                        },
                        kyc_doc_number: {
                            required: 'Please enter document number',
                            regex: 'Please enter valid document number'
                        },
                        kyc_document: {
                            required: 'Please upload kyc document'
                        },
                        tan_number: {
                            regex: 'Please enter valid TAN'
                        },
                        sales_poc_id: {
                            required: 'Please select any 1 sales POC'
                        },
                        ops_poc_id: {
                            required: 'Please select any 1 ops POC'
                        },
                        ndr_poc_id: {
                            required: 'Please select any 1 NDR POC'
                        },
                        pickup_poc_id: {
                            required: 'Please select any 1 pickup POC'
                        },
                        finance_poc_id: {
                            required: 'Please select any 1 finance POC'
                        },
                        email_id: 'Please enter a valid email address',
                        alt_contact: 'Please enter a valid contact number',
                        agreement_doc: 'Please upload agreement doc'

                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            $('.clickable-steps a').on('click', function(){
                var gotostep = $(this).data('gotostep');

                clickableWizard.formwizard('show', gotostep);
            });


            /* User Profile Update */
            $('#tabcharges').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group > div').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        e.closest('.form-group > div').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        codadjust: {
                            required: true
                        },
                        liability_amount: {
                            required: true,
                            decimal: true
                        },
                        ndd_charges: {
                            required: true,
                            decimal: true
                            
                        },
                        insurance_charges: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        },
                        capping_amount: {
                            required: true,
                            decimal: true
                        },
                        restrict_amount: {
                            required: true,
                            decimal: true
                        },
                        credit_period: {
                            required: true,
                            digits: true
                        }
                    },
                    messages: {
                        codadjust: {
                            required: 'Please select Adjust COD'
                        },
                        liability_amount: {
                            required: 'Please enter liability amount',
                            decimal: 'Please enter valid liability amount'
                        },
                        ndd_charges: {
                            required: 'Please enter NDD charges',
                            decimal: 'Please enter valid NDD charges'
                        },
                        insurance_charges: {
                            required: 'Please enter a insurance charges',
                            percent: 'Please enter valid insurance charges',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        capping_amount: {
                            required: 'Please enter capping amount',
                            decimal: 'Please enter valid capping amount'
                        },
                        restrict_amount: {
                            required: 'Please enter restrict amount',
                            decimal: 'Please enter valid restrict amount'
                        },
                        credit_period: {
                            required: 'Please enter a credit period',
                            digits: 'Please enter a valid credit period'
                        },
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            $('#tabsbilling').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group > div').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        e.closest('.form-group > div').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        billing_address: {
                            required: true,
                            regex : /^[a-zA-Z0-9\s\-_.:,&]*$/
                        },
                        billing_state: {
                            required: true
                        },
                        category_level: {
                            required: true
                        },
                        codgap: {
                            required: true,
                            digits: true
                        },
                        billing_cycle_id: {
                            required: true
                        },
                        cod_cycle_id: {
                            required: true
                        },
                        cod_fees_amt: {
                            required: true,
                            decimal: true
                        },
                        cod_fees_per: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        },
                        awb_charges: {
                            required: true,
                            decimal: true
                        },
                        fsc_rate: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        },
                        surcharge_3: {
                            required: true,
                            decimal: true
                        },
                        surcharge_4: {
                            required: true,
                            percent: true,
                            range: [0, 100]
                        }
                    },
                    messages: {
                        billing_address: {
                            required: 'Please enter billing address',
                            regex: 'Please enter valid address'
                        },
                        billing_state: {
                            required: 'Please select state'
                        },     
                        category_level: {
                            required: 'Please select category'
                        },
                        codgap: {
                            required: 'Please enter COD gap in days',
                            digits: 'Please enter valid COD gap in days'
                        },
                        billing_cycle_id: {
                            required: 'Please select billing cycle'
                        },
                        cod_cycle_id: {
                            required: 'Please select COD cycle'
                        },
                        cod_fees_amt: {
                            required: 'Please enter COD Fees',
                            decimal: 'Please enter valid COD Fees'
                        },
                        cod_fees_per: {
                            required: 'Please enter COD Fees percent',
                            percent: 'Please enter valid COD Fees percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        awb_charges: {
                            required: 'Please enter awb charges',
                            decimal: 'Please enter valid awb charges'
                        },
                        fsc_rate: {
                            required: 'Please enter FSC percent',
                            percent: 'Please enter valid FSC percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                        surcharge_3: {
                            required: 'Please enter Surcharge amount',
                            decimal: 'Please enter valid Surcharge amount'
                        },
                        surcharge_4: {
                            required: 'Please enter Surcharge percent',
                            percent: 'Please enter valid Surcharge percent',
                            range: 'Please enter a value between 0 and 100!'
                        },
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            $('#tabsaccount').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group > div').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        e.closest('.form-group > div').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        beneficiary_name: {
                            required: true,
                            regex : /^[a-zA-Z0-9\s\-_.,&]*$/
                        },
                        account_number: {
                            required: true,
                            digits: true
                        },
                        ifsc_code: {
                            required: true,
                            regex: /^[A-Za-z]{4}\d{7}$/
                        }
                    },
                    messages: {
                        beneficiary_name: {
                            required: 'Please enter Beneficiary name',
                            regex: 'Please enter valid name'
                        },
                        account_number: {
                            required: 'Please enter account number',
                            digits: 'Please enter valid account number'
                        },
                        ifsc_code: {
                            required: 'Please enter ifsc code',
                            regex: 'Please enter ifsc code in valid format'
                        },
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            $('#tabskyc').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group > div').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        e.closest('.form-group > div').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        tan_number: {
                            required: true,
                            minlength: 10,
                            regex : /^[a-zA-Z0-9\s]*$/
                        }
                    },
                    messages: {
                        tan_number: {
                            required: 'Please enter Tan number',
                            minlength: 'Please enter 10 characters',
                            regex: 'Please enter valid Tan number'
                        },
                    }
                },
                inDuration: 0,
                outDuration: 0
            });
        }
    };
}();