$(document).ready(function (){ 
  //  form_submit();
    // $('select').select2();
    // $(".select2-container .select2-selection--single").css('height','37px');

    //$('#clone_btn').click(function(){
    $(document).on('click', "#clone_btn",function(){

        var $div 	 = $('div[id^="ruleset_"]:last');
        var num 	 = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
        var $ruleset = $div.clone().prop('id', 'ruleset_'+num );
        var less_num = num - 1; //console.log(less_num);
        
        //$('select[id^="tbl_columns_"]:last').select2("destroy");

        $("#parent_div").append($ruleset);

        $('select[id^="tbl_columns_"]:last').prop('id', 'tbl_columns_'+num);
        $('select[id^="tbl_condition_"]:last').prop('id', 'tbl_condition_'+num);

        $('input[id^="tbl_value_"]:last').prop('id', 'tbl_value_'+num);
        $('label[id^="switch_"]:last').prop('id', 'switch_'+num);
        $('input[id^="toggle_value_"]:last').prop('id', 'toggle_value_'+num);

        $('div[id^="row_"]:last').prop('id', 'row_'+num);
        $('div[id^="slider_id_"]:last').prop('id', 'slider_id_'+num);
        $('div[id^="value_class_"]:last').prop('id', 'value_class_'+num);
        $('div[id^="next_value_class_"]:last').prop('id', 'next_value_class_'+num);
        $('div[id^="between_"]:last').prop('id', 'between_'+num);

        $('button[id^="delete_ruleset_"]:last').prop('id','delete_ruleset_'+num);
        $('#delete_ruleset_'+less_num).css('display','block');

        // $('select[id^="tbl_options_"]:last').prop('id', 'tbl_options_'+num);
        // $('input[id^="tbl_distinct_"]:last').prop('id', 'tbl_distinct_'+num);

        $('#switch_'+less_num).css('display','block');
        $('input[id^="tbl_value_'+num+'"]').val("");
        $('#between_'+num).remove();
        console.log("between delete -"+num);

         /*
        $('#tbl_columns_'+num).next().remove();
        $('#tbl_columns_'+num).removeClass('select2-hidden-accessible');
        $('#tbl_columns_'+num)
        .removeAttr('data-live-search')
        .removeAttr('data-select2-id')
        .removeAttr('aria-hidden')
        .removeAttr('tabindex');
        $('select#tbl_columns_'+num).select2();
        */

    });

    $(document).on('click', ".slider,.round",function(){
        // alert("here");
        var get_id = $(this).attr('id');
        var result = get_id.split('_');

        var get_val = $('#toggle_value_'+result[2]).val(); // console.log(get_val);
        if (get_val == 'and')
        {
            $('#toggle_value_'+result[2]).val('or');
        }
        else
        {
            $('#toggle_value_'+result[2]).val('and');
        }
    });

    $(document).on('change', 'select[id^="tbl_condition_"]', function(){
        var get_val =  $(this).val();
        var get_id  =  $(this).prop('id'); //console.log(get_id);
        var res 	= get_id.split("_"); //console.log(res[2]);
        var less_num= res[2] - 1; 

        $('#between_'+res[2]).remove();
        console.log("between delete -"+res[2]);
        console.log(get_val);
        $('#next_value_class_'+res[2]).find("label[for*='tbl_value']").text("Value");
        if(get_val == 6 || get_val == 7 || get_val == 8)
        {
            $('#tbl_value_'+res[2]).prop('required',false);
            $('#tbl_value_'+res[2]).prop('readonly',true);
            $('#tbl_value_'+res[2]).css('background-color','#e9ecef');
            
            // $('input[id^="tbl_value_'+res[2]+'"]').prop('readonly',true);
            // $('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#e9ecef');

            // $('input[id^="tbl_distinct_'+res[2]+'"]').prop("checked", false);
            // $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',true);
            // $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#e9ecef');

            // $('select[id^="tbl_options_'+res[2]+'"]').val("");
            // $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',true);
            // $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#e9ecef');
            
        }
        else if(get_val == 14 || get_val == 15)
        {
            //DATE_FORMAT(date_arrival, "%Y-%m-%dT%H:%i");

            var d 	 	 = new Date();
            var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2)+'T'+d.getHours()+':'+("0" + (d.getMinutes()+ 1)).slice(-2);

            $('#tbl_value_'+res[2]).prop('readonly',false);
            $('#tbl_value_'+res[2]).css('background-color','#fff');

            $('#next_value_class_'+res[2]).find("label[for*='tbl_value']").text("From Date");

            if(get_val == 14)
            {
                $("#row_"+res[2]).append('<div class="input-group mb-3 col-xs-6 col-sm-4" id="between_'+res[2]+'"><div class="input-group-prepend"><label class="input-group-text" for="tbl_value">To Date </label></div> <input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value_bet['+less_num+']" id="tbl_value_bet_'+res[2]+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required></input></div>');
            }
            else if(get_val == 15)
            {
                $("#row_"+res[2]).append('<div class="input-group mb-3 col-xs-6 col-sm-4" id="between_'+res[2]+'"><div class="input-group-prepend"><label class="input-group-text" for="tbl_value">To Date</label></div> <input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value_ntbet['+less_num+']" id="tbl_value_ntbet_'+res[2]+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required></input></div>');
            }
            
            // $('input[id^="tbl_distinct_'+res[2]+'"]').prop("checked", false);
            // $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',true);
            // $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#e9ecef');

            // $('select[id^="tbl_options_'+res[2]+'"]').val("");
            // $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',true);
            // $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#e9ecef');
            
        }
        else
        {
            $('#tbl_value_'+res[2]).prop('required',true);
            $('#tbl_value_'+res[2]).prop('readonly',false);
            $('#tbl_value_'+res[2]).css('background-color','#fff');

            // $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',false);
            // $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#fff');

            // $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',false);
            // $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#fff');
        }

        //$("#rulesetform").validate();

    });

    $(document).on('change', 'select[id^="tbl_columns_"]', function(){
        // var get_text =  $(this).text();
        // var get_val =  $(this).val();
        var get_id   =  $(this).prop('id'); //console.log(get_id);
        var res 	 = get_id.split("_");
        var get_text =  $("#"+get_id+" option:selected").text();
        var get_val  =  $("#"+get_id+" option:selected").val();

        set_condition_values(get_val,get_text,res[2]);

        if($("#tbl_distinct_"+res[2]).is(":checked")) 
        {
            set_distinct_values(get_text,res[2]);
        }

        //$("#rulesetform").validate();
    });	
//delete button click event
    $(document).on('click', 'button[id^="delete_ruleset_"]',function(){
        var get_id   =  $(this).prop('id'); //console.log(get_id);
        var res 	 = get_id.split("_");
        var id       = parseInt(res[2]) + parseInt(1);
        console.log(id);
        $("#ruleset_"+id).remove();
        $("#switch_"+res[2]).css('display','none');
        $("#delete_ruleset_"+res[2]).css('display','none');
    });

});

function get_distinct_values(tbl_columns,res)
{
    // console.log(tbl_columns);
    // console.log(res);

    $('#tbl_value_'+res).append($('<option>', { 
                                value: '',
                                text : 'Choose...' 
                            }));

    var loc_url  	= "dc_api.php";
    var wsfunction  = "get_disitnct_values";
    $.ajax({
        url: loc_url,
        type: "POST",
        data: {wsfunction : wsfunction, tbl_columns : tbl_columns},
        success: function(data){
            var resp = JSON.parse(data);
            $.each(resp.data, function (i, item) {
                // console.log(i);
                // console.log(item);

                $('#tbl_value_'+res).append($('<option>', { 
                    value: item,
                    text : item 
                }));

            });

            //$('.mdb-select').materialSelect();
        }
    });
}

function set_condition_values(tbl_columns_id,tbl_columns,res)
{
    //console.log(res);
    $('#tbl_condition_'+res).empty();
    $('#tbl_condition_'+res).append($('<option>', { 
                                value: '',
                                text : 'Choose...' 
                            }));

    var loc_url     =   "dc_api.php";
    var wsfunction  =   "get_condition";

    $.ajax({
        url: loc_url,
        type: "POST",
        data: {tbl_columns_id : tbl_columns_id, wsfunction : wsfunction},
        success: function(data){
            var resp = JSON.parse(data);
            var d 	 = new Date();
            // var set_date = d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate();
            //var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2);
            var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2)+'T'+d.getHours()+':'+("0" + (d.getMinutes()+ 1)).slice(-2);
            //console.log(set_date);

            $.each(resp.result, function (i, item) {
                // console.log(i);
                // console.log(item);

                $('#tbl_condition_'+res).append($('<option>', { 
                    value: i,
                    text : item 
                }));

            });

            console.log("between delete nxt-"+res);
            $('#between_'+res).remove();

            $('#next_value_class_'+res).nextAll().remove();
            //$('#next_value_class_'+res).nextAll("#tbl_value_"+res).first().remove();
            

            if(resp.field_type == 'T')
            {
                $("#value_class_"+res).append('<input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_'+res+'"></input>');
            }
            else if(resp.field_type == 'TA')
            {
                $("#value_class_"+res).append('<textarea class="select_class" name="tbl_value[]" id="tbl_value_'+res+'"></textarea>');
            }
            else if(resp.field_type == 'DT')
            {
                // $("label[for*='tbl_value']").text("Date");
                $("#value_class_"+res).append('<input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_'+res+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required>');
            }
            else if(resp.field_type == 'D')
            {
                $("#value_class_"+res).append('<select class="select_class class_condition mdb-select md-form" searchable="Search here.." name="tbl_value[]" id="tbl_value_'+res+'" required></select>');
                get_distinct_values(tbl_columns,res);
            }
            else if(resp.field_type == 'YN')
            {
                $("#value_class_"+res).append('<select class="select_class class_condition" name="tbl_value[]" id="tbl_value_'+res+'" required><option selected value="0"> NO </option><option value="1"> YES </option></select>');
            }
        }
    });
}
function get_execute_query(){
    var loc_url     =   "dc_api.php";
    var wsfunction  =   "execute_query";
    //$.map(item, fun2);
    /*var formdata = {
                wsfunction : wsfunction,              
                tbl_columns : $.map($("[name='tbl_columns[]']"),function(){return $(this).val();}),
                tbl_condition : $("[name='tbl_condition[]']").serialize(),
                tbl_value : $("[name='tbl_value[]']").serialize(),
                toggle_value : $("[name='toggle_value[]']").serialize()
    }*/
    //var formdata =new FormData($("#frmattributevalue")[0]);
    var formdata = $("#frmattributevalue").serializeArray();
    formdata.push({name :"wsfunction", value: wsfunction});
    $.ajax({
        url: loc_url,
        type: "POST",
        data: formdata,
        success: function(data){
            var res = JSON.parse(data);
            $("#show_users_div").html(res.tablecontent);            
            $("#total_user_div3").html(res.total_users);
            $("#total_uids3").val(res.total_users);
            $("#tuser3").html(res.total_users);
            $('#uids3').val(JSON.stringify(res.userIds));
        }
    });
}
$("#execute_btn").on("click",function(){
    if(validateRuleset() === true){
        //alert("validation done now u can call ajax");
        get_execute_query();
    }
    else{
        alert("Validation failed");
    }
})
function validateRuleset(){
    var validationstatus = true;
    $('select[id^="tbl_columns_"], select[id^="tbl_condition_"]').each(function(){
        if($(this).val().length == 0){
            $(this).next('div.red').remove();
            $(this).after('<div class="red">This field is required</div>');
            validationstatus = false;
        } else {
            $(this).next('.red').remove()
        }
    });

  /*  $('[id^="tbl_value_"]').each(function() {
        var get_id  =  $(this).prop('id'); //console.log(get_id);
        var res 	= get_id.split("_"); 
        var condition_val = $("#tbl_condition_"+res[2]+" option:selected").val();

        if(condition_val != 6 || condition_val != 7 || condition_val != 8)
        {
           if($(this).val().length == 0){
             $(this).next('div.red').remove();
                $(this).after('<div class="red">This field is required</div>');
            } else {
                $(this).next('.red').remove()
            }
        }
        else {
            $(this).next('.red').remove()
        }
    });*/
    //alert($('div.red').length);
    if($('div.red').length>0){
        return false;
    }
    else{
        return true;
    }
}