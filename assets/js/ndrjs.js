var base_url = "http://localhost/InTargos/AdminPortal/";

function reattempt(waybill_number)
{
    $.ajax({
        url: base_url + "NDR_Actions/Reattempt/",
        type: 'POST',
        data: {'waybill_number' :  waybill_number},
        dataType: 'json',
        beforeSend: function()
        {
            $('#RA'+waybill_number).button('loading');
        },
        complete: function()
        {
            $('#RA'+waybill_number).button('reset');
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
                //alert("success");
                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                    type: 'success',
                    delay: 2500,
                    allow_dismiss: true
                });
                setTimeout(function(){$("#searchbtn").click();}, 1000);
            }  
        }
    });
}

function reschedule(formid,waybill_number)
{
    var data = $('#'+formid).serialize();
    $.ajax({
        url: base_url + "NDR_Actions/Reschedule/",
        type: 'POST',
        data: data,
        dataType: 'json',
        beforeSend: function()
        {
            $('#RS'+waybill_number).button('loading');
        },
        complete: function()
        {
            $('#RS'+waybill_number).button('reset');
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
            //alert("success");
            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                type: 'success',
                delay: 2500,
                allow_dismiss: true
            });
            setTimeout(function(){$("#searchbtn").click();}, 1000);
        }           
        }
    });
}

function updatedetails(formid,waybill_number)
{
    var data = $('#'+formid).serialize();
    $.ajax({
        url: base_url + "NDR_Actions/Updatedetails/",
        type: 'POST',
        data: data,
        dataType: 'json',
        beforeSend: function()
        {
            $('#ED'+waybill_number).button('loading');
        },
        complete: function()
        {
            $('#ED'+waybill_number).button('reset');
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
            //alert("success");
            $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                type: 'success',
                delay: 2500,
                allow_dismiss: true
            });
            setTimeout(function(){$("#searchbtn").click();}, 1000);
        }           
        }
    });
}

function markrto(waybill_number)
{
    $.ajax({
        url: base_url + "NDR_Actions/MarkRTO/",
        type: 'POST',
        data: {'waybill_number' :  waybill_number},
        dataType: 'json',
        beforeSend: function()
        {
            $('#RT'+waybill_number).button('loading');
        },
        complete: function()
        {
            $('#RT'+waybill_number).button('reset');
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
                //alert("success");
                $.bootstrapGrowl('<h4><i class="fa fa-check-circle"></i> '+response.title+'</h4> <p>'+response.message+'</p>', {
                    type: 'success',
                    delay: 2500,
                    allow_dismiss: true
                });
                setTimeout(function(){$("#searchbtn").click();}, 1000);
            }  
        }
    });
}