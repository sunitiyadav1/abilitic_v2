$(document).ready(function () {
    initializeResourceBooking();
});
var rowIdx = 0;
function addNewRow(url, index = null, item = null) {
    $.ajax({
        url: url,
        type: 'POST',
        data: { action: "add_resource_to_booking", rowidnumber: rowIdx },
        //async:true,
        success: function (data) {
            $('#trbody').append(data);
            // alert(index);
            if (index != null) {
                //    alert(index);
                $("#resource_id_" + index).val(item.resource_id);
                $("#resource_option_" + index).val(item.resource_option);
                $("#resource_status_" + index).val(item.resource_status);
            }
            // regenerateJson();
            //alert("after sucess before return");
            return false;
        }
    });
    rowIdx++;
}
// jQuery button click event to add a row. 
$('#btnaddresource').on('click', function () {
    addNewRow($(this).data("url"));
    // Adding a row inside the tbody. 
    //rowIdx++;
    regenerateJson();
    return false;
});
// jQuery button click event to remove a row 
$('#trbody').on('click', '.btndeleteresource', function () {
    $("#trnumber-" + $(this).data('id')).remove();
    regenerateJson();
    return false;
});
// jQuery button click event to view Calendar
$('#trbody').on('click', '.btnviewcalresource', function () {
    // alert("view cal button clicked"+$(this).data('url')+"?id="+$('#resource_id_'+$(this).data('id')).val());
    $("#calbody1").html('');
    $("#calbody1").load($(this).data('url') + "?id=" + $('#resource_id_' + $(this).data('id')).val());
    $("#bookingModal1").modal('hide');
    $("#bookingModal1").modal('show');
    return false;
});
//$('#bookingModal').on('shown.bs.modal', function (e) {
// do something...
//  alert("on shown modal");return false;
//})

$('#trbody').on('change', '.resource', function () {
    //alert("here"+$(this).data('url')+"==="+$(this).attr('id')+"===="+$(this).val());
    resource_check_availability($(this).data('url'), $(this).val(), 'resource_status[' + $(this).data('id') + ']', $(this).data('id'))
    regenerateJson();
    return false;
});
$('#trbody').on('change', '.resourceopt', function () {
    //alert("here"+$(this).data('url')+"==="+$(this).attr('id')+"===="+$(this).val());
    resource_check_availability($(this).data('url'), $('#resource_id_' + $(this).data('id')).val(), 'resource_status[' + $(this).data('id') + ']', $(this).data('id'))
    regenerateJson();
    return false;
});
$("input[name^='datedelete']").on("click",function(){
    check_all_resource_availability();
    regenerateJson();
});
function initializeResourceBooking() {
    //    alert("here");
    checkDate('timestart', 'hidden_startdate');
    checkDate('timefinish', 'hidden_enddate');
    $("#resource_facetoface_id").val($("input[name='f']").val());
    if($("input[name='c']").val() != "1")
    {
        $("#resource_session_id").val($("input[name='s']").val());
    }
    else{
        $("#resource_session_id").val('0');
    }
    if ($("#booking_data_json").val() != "") {
        var jsonstr = $("#booking_data_json").val();
        var arr = JSON.parse(jsonstr);
        $.each(JSON.parse(jsonstr), function (index, item) {
            var url = $('#btnaddresource').data("url")
            addNewRow(url, index, item);
        });
    }
}
function regenerateJson() {
    if ($(".resource").length > 0) {
        var newjarr = [];
        $("#booking_data_json").val('');
        $.each($(".resourcerow"), function (i, val) {
            //    console.log(i,val);            
            //  alert(i+"==="+val+"===="+$(this).data('id'));
            var j = $(this).data('id');
            if ($("select[name='resource_id[" + j + "]']").val() != "") {
                var arr1 = {
                    'hidden_startdate': $("#hidden_startdate").val(),
                    'hidden_enddate': $("#hidden_enddate").val(),
                    //"resource_type_id": $("select[name='resource_type_id[" + i + "]']").val(),
                    // "resource_type_name": $("select[name='resource_type_id[" + i + "]'] option:selected").html(),
                    // "resource_subtype_id": $("select[name='resource_subtype_id[" + i + "]']").val(),
                    // "resource_sub_type_name": $("select[name='resource_subtype_id[" + i + "]'] option:selected").html(),
                    "resource_id": $("select[name='resource_id[" + j + "]']").val(),
                    "resource_name": $("select[name='resource_id[" + j + "]'] option:selected").html(),
                    //'resource_qty': $("input[name='resource_qty[" + i + "]']").val(),
                    'resource_option': $("#resource_option_" + j).val(),
                    "resource_option_name": $("select[name='resource_option[" + j + "]']").val(),
                    'resource_status': $("input[name='resource_status[" + j + "]']").val()
                };
                newjarr[i] = arr1;
                // console.log(newjarr);
            }
        });
        if (newjarr.length > 0) {
            $("#booking_data_json").val(JSON.stringify(newjarr));
            //  alert("generated Json:"+ JSON.stringify(newjarr));
            // console.log(JSON.stringify(newjarr));       
        }
        else {
            $("#booking_data_json").val('');
        }
    }
    else {
        $("#booking_data_json").val('');
    }
    //console.log($(".resource_subtype").length);
}
function checkDate(varname, hidvarname = "") {
   // alert(varname);
    $.each($('div[id^="fitem_id_'+varname+'_"]'),function(key,value){
        
        var ab = value.id;
        var textval ='';
        var idnumber = ab.substring(ab.lastIndexOf("_")+1);
       // if($("#id_datedelete_"+idnumber).attr("checked") !=true){
    // alert(idnumber);
           // console.log(key,value.name,value.id);
            var day = $("#id_" + varname + "_"+idnumber+"_day").val();
            var mon = $("#id_" + varname + "_"+idnumber+"_month").val();
            var year = $("#id_" + varname + "_"+idnumber+"_year").val();
            var hour = $("#id_" + varname + "_"+idnumber+"_hour").val();
            var min = $("#id_" + varname + "_"+idnumber+"_minute").val();
            if (mon.length < 2) mon = '0' + mon;
            if (day.length < 2) day = '0' + day;
            if (hour.length < 2) hour = '0' + hour;
            if (min.length < 2) min = '0' + min;
            var date = year + "-" + mon + "-" + day + " " + hour + ":" + min;
            var date1 = day + "-" + mon + "-" + year + " " + hour + ":" + min;
            //console.log(date,date1);
            $("input[name='txt"+varname+"["+idnumber+"]']").val(date);
            textval +="<BR>"+varname+ ":"+date;

            if (hidvarname != "") {
                $('input[name ="' + hidvarname +'['+idnumber+']"]').val(date);
            //   $('#spn_' + hidvarname).html(date1);
                //$('#spn_end_date').html(date1);
              //  alert(textval);
              if ($(".resource").length > 0) {
                check_all_resource_availability();
                regenerateJson();
                }
            }
            else {
                return date;
            }
       // }
    });
return false;
/*
    var day = $("#id_" + varname + "_day").val();
    var mon = $("#id_" + varname + "_month").val();
    var year = $("#id_" + varname + "_year").val();
    var hour = $("#id_" + varname + "_hour").val();
    var min = $("#id_" + varname + "_minute").val();

    if (mon.length < 2) mon = '0' + mon;
    if (day.length < 2) day = '0' + day;
    if (hour.length < 2) hour = '0' + hour;
    if (min.length < 2) min = '0' + min;
    var date = year + "-" + mon + "-" + day + " " + hour + ":" + min;
    var date1 = day + "-" + mon + "-" + year + " " + hour + ":" + min;

    if (hidvarname != "") {
        $('#' + hidvarname).val(date);
        $('#spn_' + hidvarname).html(date1);
        //$('#spn_end_date').html(date1);
    }
    else {
        return date;
    }
    //showResourceEditTable(ajaxurl, $("#booking_data_json").val(), "div_table");
    //regenerateJson();
    if ($(".resource").length > 0) {
        check_all_resource_availability();
        regenerateJson();
    }*/
}
function validateDate() {
    var startdate = checkDate("timestart");
    var enddate = checkDate('timefinish');
    if (Date.parse(startdate) > Date.parse(enddate)) {
        $("#msgdate").html("Start Date Can not be grater than End Date.").show();
        $('#btnaddresource').attr('disabled', true);
    }
    else {
        $("#msgdate").html("").hide();
        $('#btnaddresource').attr('disabled', false);
    }
}
function get_dates(varname,varname1){
    var arr = [];
    //console.log('div[id^="id_'+varname+'_"]');
    $.each ($('div[id^="fitem_id_'+varname+'_"]'),function(key,value){
     //   alert($("#id_datedelete_"+key).prop("checked"));
        if($("#id_datedelete_"+key).prop("checked") != true){
            console.log("input[name='"+varname1+"["+key+"]']");
        if($("input[name='"+varname1+"["+key+"]']").val() != undefined){         
             arr[key]=$("input[name='"+varname1+"["+key+"]']").val();
         } 
        }
    });
    return JSON.stringify(arr);
}
function resource_check_availability(url, resourceid, spanid, dataid) {
    //alert($("input[name='resource_action']").val());
    $("input[name='" + spanid + "'").val('');
    console.log($('input[name="resource_facetoface_id"]').val()+"======"+$('input[name="resource_session_id"]').val());
    var hstartdate = get_dates("timestart","hidden_startdate");
    var henddate = get_dates("timefinish","hidden_enddate");
    $.ajax({
        url: url,
        data: {
            "action": "resource_check_availability",
            "resource_id": resourceid,
            'fromdate': hstartdate,
            'todate': henddate,
            'f': $('input[name="resource_facetoface_id"]').val(),
            's': $('input[name="resource_session_id"]').val(),
            'collection': $("#booking_data_json").val(),
            'dataid': dataid,
            'resource_action': $("input[name='resource_action']").val()
        },
        method: "get",
        //datatype: "JSON",
        //async: false,
        beforeSend: function () {
            $("input[name='" + spanid + "'").val('');
            $("span[name='" + spanid + "'").html('<span id="divloader_1" "><span class="loading-icon icon-no-margin"><i class="icon fa fa-circle-o-notch fa-spin fa-fw " title="Loading" aria-label="Loading"></i></span></span>');
            //$("#" + showdiv).html('<BR><BR><div class="d-flex flex-row align-items-center" style="height: 32px"><div class="bg-pulse-grey rounded-circle" style="height: 32px; width: 32px;"></div><div style="flex: 1" class="pl-2"><div class="bg-pulse-grey w-100" style="height: 15px;"></div><div class="bg-pulse-grey w-75 mt-1" style="height: 10px;"></div></div></div>');
        },
        success: function (result) {
            // console.log(result); 
            // $("span[name='" + spanid + "'").html(result);
            $("input[name='" + spanid + "'").val(result);
            regenerateJson();
            //  showResourceEditTable(url, $("#booking_data_json").val(), "div_table");
            return false;
        }
    });
}

//booking Form Validation on submitting the form 
$("#id_submitbutton").click(function () {
    //alert("while submitting validation will be here..."+$("#booking_data_json").val());
    var jstr = $("#booking_data_json").val();
    var arr = JSON.parse(jstr);
    // console.log(arr);
    var statuscheck = true;
    $.each(arr, function (i, obj) {
        //   alert(i+"==="+obj);
        if (obj.resource_status == "CONFIRMED" || obj.resource_status == "CONFIRMED - Available") {
            statuscheck = true;
        }
        else {
            statuscheck = false;
            return;
        }
    });
    // alert(statuscheck);
    if (statuscheck == true) {
        // alert("sstatus check completed");
        return true;
    }
    else {
        // alert("some Resource is in planned status or duplicate Entry");
        $("#calbody").html("<div><B>Some Resources are in Planned Status or Duplicate Entry Found.</B><BR> Either Delete the Resource from booking or find some another Slot.</div>");
        $("#bookingModal").modal('show');
    }
    return false;
});

function check_all_resource_availability() {
    if ($(".resource").length > 0) {
        var newjarr = [];
        $("#booking_data_json").val('');
        $.each($(".resourcerow"), function (i, val) {
            //    console.log(i,val);            
            //  alert(i+"==="+val+"===="+$(this).data('id'));
            var j = $(this).data('id');
            if ($("select[name='resource_id[" + j + "]']").val() != "") {
                resource_check_availability($("select[name='resource_id[" + j + "]']").data('url'), $("select[name='resource_id[" + j + "]']").val(), 'resource_status[' + $(this).data('id') + ']', $(this).data('id'));
            }
        });
    }
    else {
    }
    regenerateJson();
}