$(document).ready(function () {
    $("#formtype").on("change", function () {
        if ($("#formtype").val() == "INTERNAL") {
            $("#internal_block").show();
            $("#external_block").hide();
        }
        else if ($("#formtype").val() == "EXTERNAL") {
            $("#internal_block").hide();
            $("#external_block").show();
        }
        else {
            $("#internal_block").hide();
            $("#external_block").hide();
        }
    });


    $.validator.addMethod("greaterThan", function (value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val())
            || (Number(value) > Number($(params).val()));
    }, 'Must be greater than Start Date.');//{0}

    $("#courseid").select2({
        placeholder: "Select a Course",
        containerCssClass: "form-control"
    });
    //var $select2 = $('#courseid').select2();
    //$select2.data('select2').$container.addClass("form-control");
    $("#ex_userid").select2({
        placeholder: "Select an Employee"
    });
    $("#in_userid").select2({
        placeholder: "Select an Employee"
    });
    $.fn.select2.defaults.set('containerCssClass', 'form-control');
    $("#is_certification_program").on("change", function () {
        if ($(this).val() == 0) {
            $("#certificate_div").show();
        }
        else {
            $("#certificate_div").hide();
        }
    });
    $.validator.addMethod("editfileCheck", function (value, element, params) {
        // alert(value);
        // alert($("#action").val() +"========"+ $("[name='edocfile[]']").length);
      // console.log($("#action").val() +"====="+value +"=========="+ $("#existing_fileids").val());
     //  console.log($("#action").val() == "edit" && value =="" && $("#existing_fileids").val()=="");
    if($("#is_certification_program").val()== '0'){
        if($("#action").val() == "edit" && value=="" && $("[name='edocfile[]']").length>0){// && $("#existing_fileids").val()==""){
           // alert("in if");
            return true;
        }        
        else{            
            return false;
        }
    }
    else{
        return true;
    }        
    }, 'Please Select Atlease one File');//{0}

    $("#trainingform").validate({
        rules: {
            in_end_date: {
                required: true,
                greaterThan: '#in_start_date'
            },
            ex_end_date: {
                required: true,
                greaterThan: '#ex_start_date'
            },
            'doc_file[]':{
                required:false,
                editfileCheck :true
            }
        },
        submitHandler: function () {
            //  alert("submitted");return false;
            //  $("#btn_submit").attr("disabled",true);
            return true;
        }
    });

    $("#formtype").trigger("change");
    $("#is_certification_program").trigger("change");
   
});
$("#existing_file_div").on("click","a#adeletefile",function(){
    //alert($(this).data("url"));
    $.ajax({
        url: $(this).data("url"),
        type: 'post',
        data: { action: 'deletefile', id: $(this).data('id'),tid: $(this).data("ids") },
        success: function (data) {
            console.log(data);
            var d = JSON.parse(data);
           // if(d.status ==1){
                $("#existing_file_div").html(d.result);
                $("#existing_filemsg").html(d.message).show();
                setTimeout(function(){
                     $("#existing_filemsg").html('').hide();
                },3000);
                //alert(d.message);
            //}
            return false;
        }
    });
    return false;
});
/*{
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
                return '<a href="" id="btnedit" data-id="' + row.id + '" data-toggle="modal">Edit</a> / <a href="" id="btndelete" data-id="' + row.id + '">Delete</a>';
            }
        }
        // { "data": "extn" },
        // { "data": "start_date" },
        // { "data": "salary" }
    ]
});*/
function validate(file) {
    var ext = file.split(".");
    ext = ext[ext.length - 1].toLowerCase();
    var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif", "pdf"];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Wrong extension type.");
        $("#certificate_file").val("");
    }
}
