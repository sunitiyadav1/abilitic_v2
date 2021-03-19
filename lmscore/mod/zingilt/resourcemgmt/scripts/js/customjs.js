// $.validator.setDefaults({
//     submitHandler: function() {
//         alert("submitted!");
//     }
// });

$().ready(function () { });

var tcentertable = $('#tbltcenter').DataTable({
    //"processing": true,
    //"serverSide": true,
    "ajax": {
        "url": "ajax.php?action=get_tcenter_list",
        "dataType": "json"
    },
    // "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
    "deferRender": true,
    //"ajax": "ajax.php?action=get_resource_list",
    "columns": [
        { "data": "name" },
        { "data": "location" },
        {
            mRender: function (data, type, row) {
                return '<a href="" id="btnedit" data-id="' + row.id + '" data-toggle="modal">Edit</a> / <a href="" id="btndelete" data-id="' + row.id + '">Delete</a>';
            }
        }
        // { "data": "extn" },
        // { "data": "start_date" },
        // { "data": "salary" }
    ]
});
var tprovidertable = $('#tbltprovider').DataTable({
    //"processing": true,
    //"serverSide": true,
    "ajax": {
        "url": "ajax.php?action=get_tprovider_list",
        "dataType": "json"
    },
    // "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
    "deferRender": true,
    //"ajax": "ajax.php?action=get_resource_list",
    "columns": [
        { "data": "name" },
        { "data": "is_active" },
        {
            mRender: function (data, type, row) {
                return '<a href="" id="btnedit" data-id="' + row.id + '" data-toggle="modal">Edit</a> / <a href="" id="btndelete" data-id="' + row.id + '">Delete</a>';
            }
        }
        // { "data": "extn" },
        // { "data": "start_date" },
        // { "data": "salary" }
    ]
});
var table = $('#tblresources').DataTable({
    //"processing": true,
    //"serverSide": true,
    "ajax": {
        "url": "ajax.php?action=get_resource_list",
        "dataType": "json"
    },
    // "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
    "deferRender": true,
    //"ajax": "ajax.php?action=get_resource_list",
    "columns": [
        { "data": "resource_name" },
        { "data": "type_name" },
        { "data": "subtype_name" },
        { "data": "resource_mode" },
        { "data": "is_active" },
        {
            mRender: function (data, type, row) {
                return '<a href="" id="btnattachment" data-id="' + row.id + '" data-toggle="modal">View Attachments</a> /<a href="" id="btnedit" data-id="' + row.id + '" data-toggle="modal">Edit</a> / <a href="" id="btndelete" data-id="' + row.id + '">Delete</a>';
            }
        }
        // { "data": "extn" },
        // { "data": "start_date" },
        // { "data": "salary" }
    ]
});

//setInterval( function () {
//   table.ajax.reload();
//}, 10000 );
//});
$("#tcenterForm").validate({
    rules: {
        tcenter_name: "required",
        location :"required"
    },
    messages: {
        tcenter_name: "Please Enter Training Center Name",
        location :"Please Enter Location of Center"
    },
    submitHandler: function () {

        var arr = $("#tcemterForm").serialize();
        console.log(arr);
        var formData = new FormData($('#tcenterForm')[0]);
        //formData.append('attachmentFile', $('#attachment_file')[0].files[0]);
        //formData.append('csrfmiddlewaretoken', CSRF_TOKEN); # django security
        formData.append("action", "save_tcenter");
        console.log(formData);
        $("#showMessage").removeClass("alert alert-success alert-danger").html('').hide();
        //return false;
        ///alert("submitted here");return false;
        //save_resources
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            //dataType:"json",
            //  headers: {
            // "X-CSRFToken": CSRF_TOKEN, # django security
            //     "content-type": "multipart/form-data"
            // },
            success: function (data) {
                ///// console.log(data); return false;
                var data = JSON.parse(data);
                //console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 0) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#tcenterForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                tcentertable.ajax.reload(null, false);
                $('[data-dismiss]').click();

                return false;
            }
        });
        return false;
    }
});

$("#tproviderForm").validate({
    rules: {
        tprovider_name: "required"
    },
    messages: {
        tprovider_name: "Please Enter Training Provider Name"
    },
    submitHandler: function () {

        var arr = $("#tproviderForm").serialize();
        console.log(arr);
        var formData = new FormData($('#tproviderForm')[0]);
        //formData.append('attachmentFile', $('#attachment_file')[0].files[0]);
        //formData.append('csrfmiddlewaretoken', CSRF_TOKEN); # django security
        formData.append("action", "save_tprovider");
        console.log(formData);
        $("#showMessage").removeClass("alert alert-success alert-danger").html('').hide();
        //return false;
        ///alert("submitted here");return false;
        //save_resources
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            //dataType:"json",
            //  headers: {
            // "X-CSRFToken": CSRF_TOKEN, # django security
            //     "content-type": "multipart/form-data"
            // },
            success: function (data) {
                ///// console.log(data); return false;
                var data = JSON.parse(data);
                console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 0) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#tproviderForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                tprovidertable.ajax.reload(null, false);
                $('[data-dismiss]').click();

                return false;
            }
        });
        return false;
    }
});
// validate the form when it is submitted
$("#resourceForm").validate({
    rules: {
        resource_name: "required",
        resource_type_id: "required",
        resource_subtype_id: "required",
        resource_mode: "required",
       // start_date: "required",
       // end_date: "required",
        contact_name : "required",
        contact_email : "required"
    },
    messages: {
        resource_name: "Please Enter Resource Name",
        resource_type_id: "Please Select Resource Type",
        resource_subtype_id: "Please Select any Resource Subtype",
        resource_mode: "Please Select Resource Mode",
      //  start_date: "Please Enter Start Date",
     //   end_date: "Please Enter End Date",
        contact_name :"Please Enter Contact Name",
        contact_email : "Please Enter Contact Email"

    }
    , submitHandler: function () {
        // alert("submitted here");return false;
        var arr = $("#resourceForm").serialize();
        //console.log(arr);
        var formData = new FormData($('#resourceForm')[0]);
        //formData.append('attachmentFile', $('#attachment_file')[0].files[0]);
        //formData.append('csrfmiddlewaretoken', CSRF_TOKEN); # django security
        formData.append("action", "save_resources");
        console.log(formData);
        $("#showMessage").removeClass("alert alert-success alert-danger").html('').hide();
        //save_resources
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            // dataType:"json",
            //  headers: {
            // "X-CSRFToken": CSRF_TOKEN, # django security
            //     "content-type": "multipart/form-data"
            // },
            success: function (data) {
                console.log(data);
                var data = JSON.parse(data);
                console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 0) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#resourceForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                table.ajax.reload(null, false);
                $('[data-dismiss]').click();

                return false;
            }
        });
        return false;
    }
});
//Training Center Add Button click event
$("#btnaddtcenter").click(function () {
    //alert("here");
    $("#formtitle").html("Add New Training Center");
    $('#tcenter_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('tcenter_form.php?action=add');
    $('#tcenterFormDialog').modal('show');
});
//Training provider Add Button click event
$("#btnaddtprovider").click(function () {
    //alert("here");
    $("#formtitle").html("Add New Training Provider");
    $('#tprovider_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('tprovider_form.php?action=add');
    $('#tproviderFormDialog').modal('show');
});
//Add resource Button Click event
$("#btnaddresource").click(function () {
    //alert("here");
    $("#formtitle").html("Add New Resource");
    $('#resource_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('resources.php?action=add');
    $('#resourceFormDialog').modal('show');
});
$("#tblresources").on("click", "a#btnattachment", function () {
    //
    $('#resourceAttachmentDialog').modal('show');
     $.ajax({
            url: "./ajax.php",
            data: { action: "get_resource_attachments", id: $(this).data('id') },
            datatype: "json",
            //  async: false,
            success: function (result) {
                console.log(result);
               $("#resource_attachment_details").html(result);
            }
        });
});
$("#tblresources").on("click", "a#btnedit", function () {
    //$("document").on("click","a#btnedit",function(){
    //  alert("here"+$(this).data('id'));    
    //  showResourceEditForm($(this).data('id'));
    //$('#resourceFormDialog').modal({ show: false});
    $("#formtitle").html("Edit Resource");
    $('#resource_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />");
    $('#resourceFormDialog').modal('show');
    showResourceEditForm($(this).data('id'));
    return false;
});
$("#tblresources").on("click", "a#btndelete", function () {
    //alert("here"+$(this).data('id'));
    //  $('#resourceFormDialog').modal({ show: true});
    $("#del_resource_id").val($(this).data('id'));
    $('#confirmModal').modal('show');
    // $('#myModal').modal('show');
    //showResourceEditForm($(this).data('id'));
    return false;
});
$("#tbltprovider").on("click", "a#btnedit", function () {
    //$("document").on("click","a#btnedit",function(){
    //  alert("here"+$(this).data('id'));    
    //  showResourceEditForm($(this).data('id'));
    //$('#resourceFormDialog').modal({ show: false});
    $("#formtitle").html("Edit Training Provider");
    $('#tprovider_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />");
    $('#tproviderFormDialog').modal('show');
    showTProviderEditForm($(this).data('id'));
    return false;
});
$("#tbltprovider").on("click", "a#btndelete", function () {
    //alert("here"+$(this).data('id'));
    //  $('#resourceFormDialog').modal({ show: true});
    $("#del_tprovider_id").val($(this).data('id'));
    $('#confirmModal').modal('show');
    // $('#myModal').modal('show');
    //showResourceEditForm($(this).data('id'));
    return false;
});
//tcenter
$("#tbltcenter").on("click", "a#btnedit", function () {
    //$("document").on("click","a#btnedit",function(){
    //  alert("here"+$(this).data('id'));    
    //  showResourceEditForm($(this).data('id'));
    //$('#resourceFormDialog').modal({ show: false});
    $("#formtitle").html("Edit Training Center");
    $('#tcenter_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />");
    $('#tcenterFormDialog').modal('show');
    showTCenterEditForm($(this).data('id'));
    return false;
});
$("#tbltcenter").on("click", "a#btndelete", function () {
    //alert("here"+$(this).data('id'));
    //  $('#resourceFormDialog').modal({ show: true});
    $("#del_tcenter_id").val($(this).data('id'));
    $('#confirmModal').modal('show');
    // $('#myModal').modal('show');
    //showResourceEditForm($(this).data('id'));
    return false;
});
//$("#confirmModal").on("click","#btnyes",function(){
$("#btnyes").click(function () {
    if ($("#del_resource_id").val() != "" && $("#del_resource_id").val() != undefined) {
        $.ajax({
            url: "./ajax.php",
            data: { action: "delete_resources", resource_id: $("#del_resource_id").val() },
            datatype: "json",
            //  async: false,
            success: function (result) {
                console.log(result);
                var data = JSON.parse(result);
                console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 0) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#resourceForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                $("#confirmModal").modal('hide');
                table.ajax.reload();
                $('[data-dismiss]').click();
            }
        });
    }
    else if ($("#del_tprovider_id").val() != "" && $("#del_tprovider_id").val() != undefined) {
        //alert("herer");return false;
        $.ajax({
            url: "./ajax.php",
            data: { action: "delete_tprovider", tprovider_id: $("#del_tprovider_id").val() },
            datatype: "json",
            //  async: false,
            success: function (result) {
                console.log(result);
                var data = JSON.parse(result);
                console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 1) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#tproviderForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                $("#confirmModal").modal('hide');
                tprovidertable.ajax.reload();
                $('[data-dismiss]').click();
            }
        });
    }
    else if ($("#del_tcenter_id").val() != "" && $("#del_tcenter_id").val() != undefined) {
        //alert("herer");return false;
        $.ajax({
            url: "./ajax.php",
            data: { action: "delete_tcenter", tcenter_id: $("#del_tcenter_id").val() },
            datatype: "json",
            //  async: false,
            success: function (result) {
                console.log(result);
                var data = JSON.parse(result);
                console.log(data.message);
                $("#showMessage").html(data.message).show();
                if (data.status == 0) {
                    $("#showMessage").addClass("alert alert-success").html("<strong>Success!</strong>" + data.message).show();
                    $('#tcenterForm')[0].reset();
                }
                else {
                    $("#showMessage").addClass("alert alert-danger").html("<strong>Error:</strong>" + data.message).show();
                }
                $("#confirmModal").modal('hide');
                tcentertable.ajax.reload();
                $('[data-dismiss]').click();
            }
        });
    }

});


$("#tcenter_form").on("change", "#country", function () {
    var url = "ajax.php";
    var val = $(this).val();
    country_change_function(url, val, "");

});
$("#resource_form").on("change", "#country", function () {
    var url = "ajax.php";
    var val = $(this).val();
    country_change_function(url, val, "");

});
$("#tcenter_form").on("change", "#tax_type_id", function () {
    //var url = "ajax.php";
    var val = $(this).val();
    if(val!=""){
        if(val == "1"){
            //GST
            $("#vat_div").hide();
            $("#tax_div").show();
        }
        else if(val = "2"){
            //VAT
            $("#vat_div").show();
            $("#tax_div").hide();
        }
    }
    else{
        $("#vat_div").hide();
        $("#tax_div").hide();
    }
    //resource_type_change_function(url, val, "");
});

$("#resource_form").on("change", "#resource_type_id", function () {
    var url = "ajax.php";
    var val = $(this).val();
    resource_type_change_function(url, val, "");
    //hide Fields for Trainer - PEOPLE
    //alert($(this).val()+"==="+$(this).children("option:selected").text());
    var optionval = $(this).children("option:selected").text();
    if(optionval == "PEOPLE"){
      //  alert("in if");
        $("#div_max_attendees").hide();
        $("#div_training_center").hide();
        $("#div_training_provider").hide();
        $("#div_google_map").hide();
        $("#showmap").hide();
        $("#div_seating").hide();
        $("#div_price").hide();
        $("#div_booking").hide();
        $("#div_overbookingflag").hide();
    }
    else{
      //  alert("in else");
        $("#div_max_attendees").show();
        $("#div_training_center").show();
        $("#div_training_provider").show();
        $("#div_google_map").show();
        $("#showmap").show();
        $("#div_seating").show();
        $("#div_price").show();
        $("#div_booking").show();
        $("#div_overbookingflag").show();
    }
});
/*$('.dropdown-sin-1').dropdown({
    readOnly: true,
    input: '<input type="text" maxLength="20" placeholder="Search">'
  });*/
$("#resource_form").on("change", "#resource_subtype_id", function () {
    if ($(this).val() == "3") {
        $('#trainer_div').show();
        if ($("#resource_mode").val() == "INTERNAL") {
         ////  $("#trainer_resource_name").show();
          // $('.select2').select2();
          $("div.chosen-container").show();      
        ////  $("#trainer_resource_name1").choosen();
            //$("div.dropdown-sin-1").show();       
            $("#resource_name").hide();
        }
        else {
             $("div.chosen-container").hide();    
            //$("#trainer_resource_name").hide();
            //$("div.dropdown-sin-1").hide();       
            $("#resource_name").show();
        }
    }
    else {
        $('#trainer_div').hide();
        //$("#trainer_resource_name").hide();
        //$("div.dropdown-sin-1").hide();       
        $("#resource_name").show();
         $("div.chosen-container").hide();    
    }
});
$("#resource_form").on("change", '#resource_mode', function () {
    ///alert("gere");
    if ($('#resource_subtype_id').val() == "3") {
        $('#trainer_div').show();
        if ($("#resource_mode").val() == "INTERNAL") {
          ////  $("#trainer_resource_name").show();
            //$("div.dropdown-sin-1").show();  
            $("#resource_name").hide();
             $("div.chosen-container").show();    
        }
        else {
            //$("#trainer_resource_name").hide();
            //$("div.dropdown-sin-1").hide();       
            $("#resource_name").show();
             $("div.chosen-container").hide();    
        }
    }
    else {
        $('#trainer_div').hide();
        //$("#trainer_resource_name").hide();
        //$("div.dropdown-sin-1").hide();       
        $("#resource_name").show();
         $("div.chosen-container").hide();    
    }
});
$("#resource_form").on("change", "#default_seating", function () {
    //alert($("#default_seating").children("option:selected").data('path'));
    //if($(this).val() !=""){
    $("#imgseating").html('<img src ="' + $("#default_seating").children("option:selected").data('path') + '"  width ="150" height="150">');
    //}
    //else{
    //    $("#imgseating").html('').hide();
    // }

});

//$("#resource_form").on("change", "#trainer_resource_name1", function () {
//     $(this).chosen().on("change",function(){
//         alert("in change event");
//     });
//      alert($(this).children("option:selected").text());
//     $("#resource_name").val($(this).children("option:selected").text());
// });
$("#resource_form").on("click", "button#btnid", function () {
    if ($("#google_map_lat").val() != "" && $("#google_map_long").val() != "") {
        var latvar = parseFloat($("#google_map_lat").val());
        var longvar = parseFloat($("#google_map_long").val());
        initMap(latvar, longvar);
    }
    else {
        $("#map").hide();
    }
    return false;
});
$("#resource_form").on("click","a#attdelete",function(){
   // alert($(this).data('id')+"========"+$(this).data('rid')+"=============="+$(this).data('url'));
    var id = $(this).data('id');
    var rid = $(this).data('rid');
   // $("#showmsg").html('').hide();
    $("#div_attachment_files").html('');
    $.ajax({
        url: "./ajax.php",
        data: { 'action': "delete_resource_attachment", 'id': id, 'rid': rid },
        datatype: "json",
        // async: false,
        success: function (result) {
            var arr = JSON.parse(result);
            console.log(arr);
            if(arr.status == 1){                
                $("#showattmsg").html(arr.message).show();
                $("#div_attachment_files").html(arr.result).show();
                setTimeout(function(){$("#showattmsg").html('').hide(); }, 3000);
            }           
        }
    });
return false;
});

function showTCenterEditForm(rid) {
    //$('#resourceFormDialog').modal({ show: true});
    //  $('#resourceFormDialog').modal('show');
    //alert("gerere");
    $.ajax({
        url: "./ajax.php",
        data: { action: "get_tcenter_editdata", tcenterid: rid },
        datatype: "json",
        // async: false,
        success: function (result) {
            var arr = JSON.parse(result);
            $("#formtitle").html("Edit Training Center");
            $('#tcenter_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('tcenter_form.php', 'action=edit&id=' + rid + "&" + $.param(arr), function () {
                //alert("loaded successfully");
                $("#btnid").click();
            });
            $('#tcenterFormDialog').modal('show');
        }
    });
}
function showTProviderEditForm(rid) {
    //$('#resourceFormDialog').modal({ show: true});
    //  $('#resourceFormDialog').modal('show');
    //alert("gerere");
    $.ajax({
        url: "./ajax.php",
        data: { action: "get_tprovider_editdata", tproviderid: rid },
        datatype: "json",
        // async: false,
        success: function (result) {
            var arr = JSON.parse(result);
            $("#formtitle").html("Edit Training Provider");
            $('#tprovider_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('tprovider_form.php', 'action=edit&id=' + rid + "&" + $.param(arr), function () {
                //alert("loaded successfully");
                $("#btnid").click();
            });
            $('#tproviderFormDialog').modal('show');
        }
    });
}
function showResourceEditForm(rid) {
    //$('#resourceFormDialog').modal({ show: true});
    //  $('#resourceFormDialog').modal('show');
    //alert("gerere");
    $.ajax({
        url: "./ajax.php",
        data: { action: "get_resource_editdata", resourceid: rid },
        datatype: "json",
        // async: false,
        success: function (result) {
            var arr = JSON.parse(result);
            $("#formtitle").html("Edit Resource");
            $('#resource_form').html("<img src='scripts/jquery-modal/images/LoaderIcon.gif' />").load('resources.php', 'action=edit&id=' + rid + "&" + $.param(arr), function () {
                //alert("loaded successfully");
                $("#btnid").click();
            });
            $('#resourceFormDialog').modal('show');
        }
    });
}
function disableMap() {
    if ($("#id_google_map_long").val() != "" && $("#id_google_map_lat").val() != "") {
        $("button#btnid").attr("disabled", false);
    }
    else {
        $("button#btnid").attr("disabled", "disabled"); $("#map").hide();
    }
}
function initMap(latvar, longvar) {
    $("#map").show();

    var myLatLng = { lat: latvar, lng: longvar };

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 3,
        center: myLatLng
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Hello World!'
    });
    return false;
}
function calculate_age(dob) {
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms);

    return Math.abs(age_dt.getUTCFullYear() - 1970);
}
function getAge(day, mon, year) {
    //alert($("#id_dob_day").val()+"-"+$("#id_dob_month").val()+"-"+$("#id_dob_year").val());
    var dob = new Date(year, mon - 1, day);
    //alert(calculate_age(dob));
    $("#id_age").val(calculate_age(dob));
}
function resource_type_change_function(url, val, selval = '') {

    //console.log(cfgurl+"====sdfsdf");

    if (val != "" && val != undefined && val != '0') {
        $.ajax({
            url: url,
            data: { action: "change_type", id: val },
            datatype: "json",
            //async: false,
            beforeSend: function () {
                $('#resource_subtype_id').hide();
                $("#loaderspan").show();
            },
            success: function (result) {
                if (result != null) {
                    var dropdown = $('#resource_subtype_id');
                    dropdown.empty();
                    dropdown.prop('disabled', true);
                    $.each(JSON.parse(result), function (index, item) {
                        dropdown.prepend(
                            $('<option>', {
                                value: index,
                                text: item
                            }, '</option>'));
                    });
                    dropdown.prop('disabled', false);
                    //alert(selval);
                    //if (selval != undefined) {
                    dropdown.val(selval);
                    //}
                }
                //$("loaderspan").hide();
            },
            complete: function () {
                $("#loaderspan").hide();
                $('#resource_subtype_id').show();
            }

        });
    }
    else {
        var dropdown = $('#id_resource_subtype_id');
        dropdown.empty();
        dropdown.prepend(
            $('<option>', {
                value: "0",
                text: "Select"
            }, '</option>'));
    }
}


function country_change_function(url, val, selval = '') {

    //console.log(cfgurl+"====sdfsdf");

    if (val != "" && val != undefined && val != '0') {
        $.ajax({
            url: url,
            data: { action: "change_country", id: val },
            datatype: "json",
            //async: false,
            beforeSend: function () {
                //$('#resource_subtype_id').hide();
                //$("#loaderspan").show();
            },
            success: function (result) {
                if (result != null) {
                    var dropdown = $('#state');
                    dropdown.empty();
                    dropdown.prop('disabled', true);
                    $.each(JSON.parse(result), function (index, item) {
                        dropdown.prepend(
                            $('<option>', {
                                value: index,
                                text: item
                            }, '</option>'));
                    });
                    dropdown.prop('disabled', false);
                    //alert(selval);
                    //if (selval != undefined) {
                    dropdown.val(selval);
                    //}
                }
                //$("loaderspan").hide();
            },
            complete: function () {
                //$("#loaderspan").hide();
                //$('#resource_subtype_id').show();
            }

        });
    }
    else {
        var dropdown = $('#state');
        dropdown.empty();
        dropdown.prepend(
            $('<option>', {
                value: "",
                text: "Select"
            }, '</option>'));
    }
}