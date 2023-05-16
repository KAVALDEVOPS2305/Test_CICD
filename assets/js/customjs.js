
//CheckLogin
function logincheck(formid,cntrlr)
{
    // alert(formid +" # " + cntrlr);
    var user = $('#'+formid).serialize();
    //alert(cntrlr);
    var login = function()
    {
        $.ajax({
        type: 'POST',
        url: cntrlr+"authentication/check_login",
        dataType: 'json',
        data: user,
        success:function(response)
        {
          if(response.error)
          {   
             $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'!</h4> <p>'+response.message+'</p>', {
                  type: 'danger',
                  delay: 2500,
                  allow_dismiss: true
              });
            // return false;
          }
          else
          {        
            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'!</h4> <p>'+response.message+'</p>', {
                    type: 'success',
                    delay: 2500,
                    allow_dismiss: true
                });
            setTimeout(function(){location.reload();}, 3000);
          }
        }
      });
    };
    setTimeout(login, 1000);
}
//Check Login End

//Insert
function ins_data(formid,url)
{  
  //alert(formid + "#" + url);
  //var data = new FormData($('#'+formid)[0]);
  var data = $('#'+formid).serialize();
  //alert(data);
  $.ajax({
    url: url,
    type: 'POST',
    data: data,
    dataType: 'json',
    success: function(response) 
    {
      if(response.error)
      {
        //alert("error");                          
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'danger',
            delay: 2500,
            allow_dismiss: true
        });
      }
      else
      {
        //alert("success");
        $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'success',
            delay: 2500,
            allow_dismiss: true
        });

        if(formid=="form_remit")
        {
          $('#modal-remit').modal('hide');
        }
        else
          setTimeout(function(){location.reload();}, 3000);
      }           
    }
  });  
}

// Ajax Update 
function update_data(formid,url)
{
  //alert(formid + "#" + url);
  var data = $('#'+formid).serialize();        
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: 'json',
    success: function(response) 
    {
      if(response.error)
      {                          
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'danger',
            delay: 2500,
            allow_dismiss: true
        });
        //return false
      }
      else
      {
        $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'success',
            delay: 2500,
            allow_dismiss: true
        });

        setTimeout(function(){location.reload();}, 3000);
      }
    }       
    });       
}
// end update

function deleteconfirm(row_id,url)
{
  //alert("in deleteconfirm" + row_id+"#"+url);

    $.ajax({
      url: url,
      type: "POST",
      data : {'id' : row_id },
      dataType: 'json',
      success: function(response) 
      {
        if(response.error)
        {                          
          $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'danger',
            delay: 2500,
            allow_dismiss: true
          });
          //return false
        }
        else
        {
          $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'success',
            delay: 2500,
            allow_dismiss: true
          });

          setTimeout(function(){location.reload();}, 3000);
        }
      }
   });      
}

// Change Status
function update_status(record_id,new_status,url)
{
  //alert(record_id+"#"+new_status+"#"+url);
    
     $.ajax({
      url: url,
      type: "POST",
      dataType: 'json',
      data : {'record_id' : record_id,'new_status': new_status},
      success: function(response) 
      {
        if(response.error)
        {                          
          $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'danger',
            delay: 2500,
            allow_dismiss: true
          });
          //return false
        }
        else
        {
          $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'success',
            delay: 2500,
            allow_dismiss: true
          });

          setTimeout(function(){location.reload();}, 3000);
        }      
      }
   }); 
}

// Ajax Search 
function search_data(formid,url)
{
  // alert(formid + "#" + url);
  var data = $('#'+formid).serialize();        
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    // dataType: 'json',
    beforeSend: function()
    {
        $('#loader').show();
        $("#table-div").show();
    },
    complete: function()
    {
        $('#loader').hide();
    },
    success: function(response) 
    {
      // $("#table-div").show();
      $("#render_searchdata").html(response);
      $('#datatable-search').dataTable({
          columnDefs: [ { orderable: false, targets: 0 } ],
          pageLength: 100,
          ordering: false,
          lengthMenu: [10, 25, 50, 100],
          bAutoWidth: false
      });
      $('.dataTables_filter input').attr('placeholder', 'Search');
    }       
  });       
}
// end Search


// Ajax Search with Column Sum
function search_sum_data(formid,url)
{
  // alert(formid + "#" + url);
  var data = $('#'+formid).serialize();        
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    // dataType: 'json',
    beforeSend: function()
    {
        $('#loader').show();
        $("#table-div").show();
    },
    complete: function()
    {
        $('#loader').hide();
    },
    success: function(response) 
    {
      // $("#table-div").show();
      if(formid == "form_alltransactions")
      {
        $("#render_searchdata").html(response);
        $('#datatable-search').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 100,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            bAutoWidth: false,
            drawCallback: function( settings ) {
              var api = this.api();
              
              $('#amt_sum').html(
                api.column( 3, { page: 'current'} ).data().reduce( function (a, b)
                { return parseFloat(a) + parseFloat(b);}, 0 ).toFixed(2) +
                ' (' + api.column(3).data().reduce( function (a, b) { return parseFloat(a) + parseFloat(b);},0).toFixed(2) + ')'
              );
          }
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');
      }
      else if(formid == "form_allpayments")
      {
        $("#render_searchdata").html(response);
        $('#datatable-search').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 100,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            bAutoWidth: false,
            drawCallback: function( settings ) {
              var api = this.api();
              
              $('#allpayments_amt_sum').html(
                api.column( 3, { page: 'current'} ).data().reduce( function (a, b)
                { return parseFloat(a) + parseFloat(b);}, 0 ).toFixed(2) +
                ' (Total: ' + api.column(3).data().reduce( function (a, b) { return parseFloat(a) + parseFloat(b);},0).toFixed(2) + ')'
              );
          }
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');
      }
      else if(formid == "form_viewcods")
      {
        $("#render_searchdata").html(response);
        $('#datatable-search').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 100,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            bAutoWidth: false,
            drawCallback: function( settings ) {
              var api = this.api();
              
              $('#cods_sum').html(
                api.column( 4, { page: 'current'} ).data().reduce( function (a, b)
                { return parseFloat(a) + parseFloat(b);}, 0 ).toFixed(2) +
                ' (' + api.column(4).data().reduce( function (a, b) { return parseFloat(a) + parseFloat(b);},0).toFixed(2) + ')'
              );
          }
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');
      }
      else if(formid == "form_viewinvoice")
      {
        // alert(formid);
        $("#render_searchdata").html(response);
        $('#datatable-search').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 100,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            bAutoWidth: false,
            drawCallback: function( settings ) {
              var api = this.api();

              $('#invoice_sum').html(
                api.column( 5, { page: 'current'} ).data().reduce( function (a, b)
                { return parseFloat(a) + parseFloat(b);}, 0 ).toFixed(2) +
                ' (' + api.column(5).data().reduce( function (a, b) { return parseFloat(a) + parseFloat(b);},0).toFixed(2) + ')'
              );

              $('#invoice_gst_sum').html(
                api.column( 6, { page: 'current'} ).data().reduce( function (c, d)
                { return parseFloat(c) + parseFloat(d);}, 0 ).toFixed(2) +
                ' (' + api.column(6).data().reduce( function (c, d) { return parseFloat(c) + parseFloat(d);},0).toFixed(2) + ')'
              );
              
              $('#total_invoice_sum').html(
                api.column( 7, { page: 'current'} ).data().reduce( function (f, g)
                { return parseFloat(f) + parseFloat(g);}, 0 ).toFixed(2) +
                ' (' + api.column(7).data().reduce( function (f, g) { return parseFloat(f) + parseFloat(g);},0).toFixed(2) + ')'
              );
          }
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');
      }
      else
      {
        $("#render_searchdata").html(response);
        $('#datatable-search').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 100,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            bAutoWidth: false
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');
      }
    }       
  });       
}
// end Search

function upload_data(formid,url,data)
{
  //alert(formid + "#" + url + "*" + data);
  $.ajax({  
      url:url,  
      method:"POST",  
      data:data,  
      contentType:false,  
      processData:false,
      dataType: 'json',
      success:function(response)
      {  
          // alert(response + "##" + response.title + "##" + response.message);
          if(response.error)
          {                          
            $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
              type: 'danger',
              delay: 3000,
              allow_dismiss: true
            });
            //return false
          }
          else
          {
            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
              type: 'success',
              delay: 2500,
              allow_dismiss: true
            });

            setTimeout(function(){location.reload();}, 3000);
          } 
      }
 });       
}

// Ajax Review 
function review_data(formid,url,data)
{       
  $.ajax({
    url:url,  
    method:"POST",  
    data:data,  
    contentType:false,  
    processData:false,
    dataType: 'json',
    success: function(response) 
    {
      if(response.error)
      {                          
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
          type: 'danger',
          delay: 3000,
          allow_dismiss: true
        });
      }
      else if(response.title=='Congrats')
      {
        $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
              type: 'success',
              delay: 2500,
              allow_dismiss: true
            });
        setTimeout(function(){location.reload();}, 3000);
      }
      else
      {
        $('#modal-add').modal('hide');
        $('#modal-preview').modal('show');
        $("#render_errordata").html(response.message);
        $('#datatable-preview').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 10,
            ordering: false,
            lengthMenu: [10, 25, 50, 100]
        });
        $('.dataTables_filter input').attr('placeholder', 'Search'); 
      }
    },
    error: function()
    {
      $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> Error</h4> <p>Some error occurred while reading excel, try again.</p>', {
            type: 'danger',
            delay: 3000,
            allow_dismiss: true
          });
    }       
  });       
}
// end Review

//Excel Update
function excel_update(formid,url)
{  
  //alert(formid + "#" + url);
  //var data = new FormData($('#'+formid)[0]);
  var data = $('#'+formid).serialize();
  //alert(data);
  $.ajax({
    url: url,
    type: 'POST',
    data: data,
    dataType: 'json',
    complete: function()
    {
      $('#modal-preview').modal('hide');
      $('#'+formid)[0].reset();

    },
    success: function(response) 
    {
      if(response.error)
      {
        //alert("error");                          
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
            type: 'danger',
            delay: 2500,
            allow_dismiss: true
        });
      }
      else
      {
        // alert(response.updated + "##" + response.errors.length);
        if(response.errors.length > 0)
        {
          if(response.action=="WeightUpdate")
            weight_update_errors(response.errors);
          if(response.action=="RequestWeightUpdate")
            request_weight_update_errors(response.errors);
        }
          

        if(response.updated > 0 && response.errors.length==0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated Successfully!</b>');
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-warning'); 
          $("#alert").addClass('alert-success');

        }
        else if(response.updated > 0 && response.errors.length > 0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated Successfully!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>'+response.errors.length+' Error(s). Click here to dowload errors</u></button></b>');
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-success'); 
          $("#alert").addClass('alert-warning');
        }
        else if(response.updated == 0 && response.errors.length > 0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>'+response.errors.length+' Error(s). Click here to dowload errors</u></button></b>');
          $("#alert").removeClass('alert-success');
          $("#alert").removeClass('alert-warning'); 
          $("#alert").addClass('alert-danger');
        }
      }
    }
  });  
}

// Excel Update Review 
function review_excelupdate(formid,url,data)
{       
  $.ajax({
    url:url,  
    method:"POST",  
    data:data,  
    contentType:false,  
    processData:false,
    dataType: 'json',
    beforeSend: function()
    {
        $('#loader').show();
    },
    complete: function()
    {
        $('#loader').hide();
        $('#'+formid)[0].reset();

    },
    success: function(response) 
    {
      if(response.error)
      {                          
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
          type: 'danger',
          delay: 3000,
          allow_dismiss: true
        });
      }
      else if(response.title=="Success")
      {
        // alert(response.updated + "##" + response.errors.length);
        if(response.errors.length > 0)
        {
          if(response.action=="WeightUpdate")
            weight_update_errors(response.errors);
        }
          

        if(response.updated > 0 && response.errors.length==0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated Successfully!</b>');
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-warning'); 
          $("#alert").addClass('alert-success');

        }
        else if(response.updated > 0 && response.errors.length > 0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated Successfully!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>'+response.errors.length+' Error(s). Click here to dowload errors</u></button></b>');
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-success'); 
          $("#alert").addClass('alert-warning');
        }
        else if(response.updated == 0 && response.errors.length > 0)
        {
          $('#alert').show();
          $('#alert_message').html('<b>'+response.updated+' Records Updated!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>'+response.errors.length+' Error(s). Click here to dowload errors</u></button></b>');
          $("#alert").removeClass('alert-success');
          $("#alert").removeClass('alert-warning'); 
          $("#alert").addClass('alert-danger');
        }
      }
      else
      {
        $('#modal-preview').modal('show');
        $("#render_errordata").html(response.message);
        $('#datatable-preview').dataTable({
            columnDefs: [ { orderable: false, targets: 0 } ],
            pageLength: 10,
            ordering: false,
            lengthMenu: [10, 25, 50, 100]
        });
        $('.dataTables_filter input').attr('placeholder', 'Search'); 
      }
    },
    error: function()
    {
      $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> Error</h4> <p>Some error occurred while reading excel, try again.</p>', {
            type: 'danger',
            delay: 3000,
            allow_dismiss: true
          });
    }       
  });       
}
// end Review

//excel upload,error download without preview
function excel_upload(formid, url, data)
{
  $.ajax({
    url: url,
    method: "POST",
    data: data,
    contentType: false,
    processData: false,
    dataType: 'json',
    beforeSend: function () {
			$('#loader').show();
		},
		complete: function () {
			$('#loader').hide();
		},
    success: function (response)
    {
      if (response.error)
      {
        $.bootstrapGrowl('<h4><i class="fa fa-ban"></i> ' + response.title + '</h4> <p>' + response.message + '</p>', {
          type: 'danger',
          delay: 3000,
          allow_dismiss: true
        });
      }
      else
      {
        if (response.errors.length > 0)
        {
          if (response.action == "Updatetracking")
            update_tracking_report(response.errors);
        }
        if (response.updated > 0 && response.errors.length == 0) {
          $('#alert').show();
          $('#alert_message').html('<b>' + response.updated + ' Records Updated Successfully!</b>');
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-warning');
          $("#alert").addClass('alert-success');
        }
        else if (response.updated > 0 && response.errors.length > 0)
        {
          if (response.action == "Updatetracking")
            $('#alert_message').html('<b>' + response.updated + ' Records Updated Successfully!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u> Click here to download report</u></button></b>');
          else
            $('#alert_message').html('<b>' + response.updated + ' Records Updated Successfully!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>' + response.errors.length + ' Error(s). Click here to download errors</u></button></b>');
          
          $('#alert').show();
          $("#alert").removeClass('alert-danger');
          $("#alert").removeClass('alert-success');
          $("#alert").addClass('alert-warning');
        }
        else if (response.updated == 0 && response.errors.length > 0) {
          $('#alert').show();
          $('#alert_message').html('<b>' + response.updated + ' Records Updated!<button id="btn_downloaderror" type="button" style="border:none;background:none;"><u>' + response.errors.length + ' Error(s). Click here to download errors</u></button></b>');
          $("#alert").removeClass('alert-success');
          $("#alert").removeClass('alert-warning');
          $("#alert").addClass('alert-danger');
        }
      }
    }
  });
}

function update_tracking_report(errors_array)
{
	var error_html = '';
	for (var i = 0; i < errors_array.length; i++) {
		// alert(errors_array[i]['waybill'] + "##" + errors_array[i]['weight'] + "##" + errors_array[i]['error']);
		error_html += '<input type="hidden" name="waybill_number[]" value="' + errors_array[i]['waybill_number'] + '"><input type="hidden" name="remarks[]" value="' + errors_array[i]['remarks'] + '">';
	}
	$("#excel_error").html(error_html);
}

function weight_update_errors(errors_array)
{
  // alert(errors_array.length);
    var error_html='';
    for(var i=0;i<errors_array.length;i++)
    {
      // alert(errors_array[i]['waybill'] + "##" + errors_array[i]['weight'] + "##" + errors_array[i]['error']);
      
      error_html+='<input type="hidden" name="waybill[]" value="'+errors_array[i]['waybill']+'"><input type="hidden" name="weight[]" value="'+errors_array[i]['weight']+'"><input type="hidden" name="error[]" value="'+errors_array[i]['error']+'">';
    }
    $("#excel_error").html(error_html);
}

//Date Range Function
function daterange(range)
{
  // alert(range);
  switch(range)
  {
    case '1':
      // alert("Today");
      $('#from_date').datepicker('setDate', 'now');
      $('#to_date').datepicker('setDate', 'now');
      break;
    case '2':
      // alert("Yesterday");
      $('#from_date').datepicker('setDate', moment().subtract(1, 'days').toDate());
      $('#to_date').datepicker('setDate', moment().subtract(1, 'days').toDate());
      break;
    case '3':
      // alert("This Week");
      $('#from_date').datepicker('setDate', moment().startOf('week').toDate());
      $('#to_date').datepicker('setDate', moment().endOf('week').toDate());
      break;
    case '4':
      // alert("Last Week");
      $('#from_date').datepicker('setDate', moment().subtract(1, 'weeks').startOf('week').toDate());
      $('#to_date').datepicker('setDate', moment().subtract(1, 'weeks').endOf('week').toDate());
      break;
    case '5':
      // alert("This Month");
      $('#from_date').datepicker('setDate', moment().startOf('month').toDate());
      $('#to_date').datepicker('setDate', moment().endOf('month').toDate());
      break;
    case '6':
      // alert("Last Month");
      $('#from_date').datepicker('setDate', moment().subtract(1, 'months').startOf('month').toDate());
      $('#to_date').datepicker('setDate', moment().subtract(1, 'months').endOf('month').toDate());
      break;
    case '7':
        // alert("Future CODs");
        $('#from_date').datepicker('setDate', 'now');
        $('#to_date').datepicker('setDate', moment().add(2, 'months').endOf('month').toDate());
        break;
  }
}

//Datetime Range Function
function datetimerange(range)
{
  // alert(range);
  switch(range)
  {
    case '0':
      // alert("Today");
      $('#from_date').val("");
      $('#to_date').val("");
      break;
    case '1':
      // alert("Today");
      $('#from_date').val(moment().format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().format('DD-MM-YYYY 23:59:59'));
      break;
    case '2':
      // alert("Yesterday");
      $('#from_date').val(moment().subtract(1, 'days').format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().subtract(1, 'days').format('DD-MM-YYYY 23:59:59'));
      break;
    case '3':
      // alert("This Week");
      $('#from_date').val(moment().startOf('week').format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().endOf('week').format('DD-MM-YYYY 23:59:59'));
      break;
    case '4':
      // alert("Last Week");
      $('#from_date').val(moment().subtract(1, 'weeks').startOf('week').format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().subtract(1, 'weeks').endOf('week').format('DD-MM-YYYY 23:59:59'));
      break;
    case '5':
      // alert("This Month");
      $('#from_date').val(moment().startOf('month').format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().endOf('month').format('DD-MM-YYYY 23:59:59'));
      break;
    case '6':
      // alert("Last Month");
      $('#from_date').val(moment().subtract(1, 'months').startOf('month').format('DD-MM-YYYY 00:00:00'));
      $('#to_date').val(moment().subtract(1, 'months').endOf('month').format('DD-MM-YYYY 23:59:59'));
      break;
  }
}





