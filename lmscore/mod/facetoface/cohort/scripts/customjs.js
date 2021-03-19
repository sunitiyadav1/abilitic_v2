$(document).ready(function(){
    
$('input[name="cancel"]').val("Reset");
$('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    })
});
//For User Form 
$("#userids").on("change",function(){
    countUserajax("user");
});

$("#frmuser").on("click","#id_submitbutton1",function(){
    //alert("here clicked button");
 
   // alert($("#session_capacity1").val()+"===="+$("#total_uids1").val() +"====="+$("#enrolled_session_capacity1").val());
    var capacity = $("#session_capacity1").val();
    var total_uids = $("#total_uids1").val();
    var enrolled_capacity = $("#enrolled_session_capacity1").val();
    if(total_uids >0){
     //   alert(enrolled_capacity+"===="+capacity);
        if(parseInt(enrolled_capacity) > parseInt(capacity)){
            $('#pmsgbodyerror1').html("You already exceeeded the session Capacity. Please Update your Session Capacity.").show().delay(5000).fadeOut();
          //  alert("You already exceeeded the session Capacity");
        }
        else{
            var rem_capacity = capacity - enrolled_capacity;
        //  alert(rem_capacity);
            if(rem_capacity < total_uids){
            // alert("You can not Enrol as it reaches capacity of session. Do you want to Increase the Capacity?");
                $("#userModal").modal("show");
            }
            else{
            // alert("You can Enroll the Users");
                submitformfunction("user");
            }
        }
    }
    else{
      
        $('#pmsgbodyerror1').html("You have to At least Select Any User or Cohort.").show().delay(5000).fadeOut();
        //$("#cohortresultModal").modal("show");
    }
    $("#show_loader").hide();
    return false;
})
$("#userresultModal").on("click","#btnclose",function(){
    //alert("hhere");
    location.href = $(this).data("url");
});
$("#userModal").on("click","#btnproceed1",function(){
    //alert("proceed button clicked");
    //var formdata = new FormData($('#frmcohort')[0]);
    submitformfunction("user");
    return false;
})

//for Cohort Form
$("#cohortids").on("change",function(){
    countUserajax("cohort");   
});
$("#frmcohort").on("click","#id_submitbutton2",function(){
    //alert("here clicked button");
 
   // alert($("#session_capacity").val()+"===="+$("#total_uids").val() +"====="+$("#enrolled_session_capacity").val());
    var capacity = $("#session_capacity2").val();
    var total_uids = $("#total_uids2").val();
    var enrolled_capacity = $("#enrolled_session_capacity2").val();
    if(total_uids >0){
        if(parseInt(enrolled_capacity) > parseInt(capacity)){
            $('#pmsgbodyerror2').html("You already exceeeded the session Capacity. Please Update your Session Capacity.").show().delay(5000).fadeOut();
          //  alert("You already exceeeded the session Capacity");
        }
        else{
            var rem_capacity = capacity - enrolled_capacity;
        //  alert(rem_capacity);
            if(rem_capacity < total_uids){
            // alert("You can not Enrol as it reaches capacity of session. Do you want to Increase the Capacity?");
                $("#cohortModal").modal("show");
            }
            else{
            // alert("You can Enroll the Users");
                submitformfunction('cohort');
            }
        }
    }
    else{
      
        $('#pmsgbodyerror2').html("You have to At least Select Any User or Cohort.").show().delay(5000).fadeOut();
        //$("#cohortresultModal").modal("show");
    }
    $("#show_loader").hide();
    return false;
})
$("#cohortresultModal").on("click","#btnclose",function(){
    //alert("hhere");
    location.href = $(this).data("url");
});
$("#cohortModal").on("click","#btnproceed2",function(){
    //alert("proceed button clicked");
    //var formdata = new FormData($('#frmcohort')[0]);
    submitformfunction('cohort');
    return false;
});

///form attribute value submit button click
$("#frmattributevalue").on("click",'#id_submitbutton3',function(){
   
   // alert($("#session_capacity").val()+"===="+$("#total_uids").val() +"====="+$("#enrolled_session_capacity").val());
   var capacity = $("#session_capacity3").val();
   var total_uids = $("#total_uids3").val();
   var enrolled_capacity = $("#enrolled_session_capacity3").val();
   if(total_uids >0){
       if(parseInt(enrolled_capacity) > parseInt(capacity)){
           $('#pmsgbodyerror3').html("You already exceeeded the session Capacity. Please Update your Session Capacity.").show().delay(5000).fadeOut();
         //  alert("You already exceeeded the session Capacity");
       }
       else{
           var rem_capacity = capacity - enrolled_capacity;
       //  alert(rem_capacity);
           if(rem_capacity < total_uids){
           // alert("You can not Enrol as it reaches capacity of session. Do you want to Increase the Capacity?");
               $("#avModal").modal("show");
           }
           else{
           // alert("You can Enroll the Users");
               submitformfunction('attributevalue');
           }
       }
   }
   else{
     
       $('#pmsgbodyerror3').html("You have to At least Select Any User or Cohort.").show().delay(5000).fadeOut();
       //$("#cohortresultModal").modal("show");
   }
   $("#show_loader").hide();
   return false;
});

$("#avresultModal").on("click","#btnclose",function(){
    //alert("hhere");
    location.href = $(this).data("url");
});
$("#avModal").on("click","#btnproceed3",function(){
    //alert("proceed button clicked");
    //var formdata = new FormData($('#frmcohort')[0]);
    submitformfunction('attributevalue');
    return false;
})

///////////////////////////////////////////////////////
//Common Submit Function for all three tabs
function submitformfunction(fromvar){
    if(fromvar == "user"){
        //var formdata = $('#frmuser').serialize();
        var formdata ={ 
                    'action' : "enroll_cohort",
                    's'      : $("#s").val(),
                    'total_uids' : $("#total_uids1").val(),
                    'cohortids' :$("#cohortids").val(),
                    'userids'   :   $("#userids").val(),
                    'uids'      :   $("#uids1").val(),
                    'session_capacity'  :   $("#session_capacity1").val(),
                    'enrolled_session_capacity' :   $("#enrolled_session_capacity1").val()
                };        
    }
    else if(fromvar == "cohort"){
        //var formdata = $('#frmcohort').serialize();
        var formdata ={ 'action' : "enroll_cohort",
                        's'      : $("#s").val(),
                        'total_uids' : $("#total_uids2").val(),
                        'cohortids' :$("#cohortids").val(),
                        'userids'   :   $("#userids").val(),
                        'uids'      :   $("#uids2").val(),
                        'session_capacity'  :   $("#session_capacity2").val(),
                        'enrolled_session_capacity' :   $("#enrolled_session_capacity2").val()
                    };        
    }
    else if(fromvar == "attributevalue"){
        //var formdata = $('#frmcohort').serialize();
        var formdata ={ 'action' : "enroll_cohort",
                        's'      : $("#s").val(),
                        'total_uids' : $("#total_uids3").val(),
                        'uids'      :   $("#uids3").val(),
                        'session_capacity'  :   $("#session_capacity3").val(),
                        'enrolled_session_capacity' :   $("#enrolled_session_capacity3").val()
                    };        
    }
   // formdata.append('action', 'enroll_cohort');
   if(formdata!=null){
       // console.log(formdata);
        $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: formdata,
        beforeSend :function(){
            $("#show_loader").show();
        },
        success: function (result) {
         //   console.log(result);   
            var res = JSON.parse(result);
            $("#show_loader").hide();
            if(fromvar == "user"){
                //submitting User Form
                $('#frmuser')[0].reset();                
                $("#userids").val('');
                $("#total_uids1").val('0');
                $("#total_user_div1").html('0');
                $(".form-autocomplete-selection span").remove();
              //  $('#pmsgbodysuccess1').html(res.message).show().delay(5000).fadeOut();
            // setTimeout(function(){
              //  location.href = res.url;
                  //  $("#id_cancel1").click();
                    //location.reload(true);
                //   },500);
                //$("#msgbodysuccess").html(res.message).show();
                //$("#msgbodyerror").html(res.message).hide();
              //  $("#userresultModal").modal('show');
                $("#show_loader").hide();
            }
            else if(fromvar == "cohort"){
                //submitting cohort form
                $('#frmcohort')[0].reset();    
                $("#cohortids").val('');
                $("#total_uids2").val('0');
                $("#total_user_div2").html('0');
                $(".form-autocomplete-selection span").remove();
               // $('#pmsgbodysuccess2').html(res.message).show().delay(5000).fadeOut();
            // setTimeout(function(){
                // location.href = res.url;
                  //  $("#id_cancel2").click();
                    //location.reload(true);
                //   },500);
                //$("#msgbodysuccess").html(res.message).show();
                //$("#msgbodyerror").html(res.message).hide();
                //$("#cohortresultModal").modal('show');
                $("#show_loader").hide();
            }
            else if(fromvar == "attributevalue"){
                //submitting cohort form
                $('#frmattributevalue')[0].reset();    
                //$("#cohortids").val('');
                $("#total_uids3").val('0');
                $("#total_user_div3").html('0');
                //$(".form-autocomplete-selection span").remove();
               // $('#pmsgbodysuccess3').html(res.message).show().delay(5000).fadeOut();
                $("#show_users_div").html("No User Selected");
                //$("#msgbodysuccess").html(res.message).show();
                //$("#msgbodyerror").html(res.message).hide();
             //  $("#avresultModal").modal('show');
                $("#show_loader").hide();
            }
          //  setTimeout(function(){
                //  location.href = res.url;
                require(['core/notification'], function(notification) {
                            notification.addNotification({
                            message: res.message,
                            type: "success"
                            });
                        });
                    // $("#id_cancel3").click();
                        window.location.reload(true);
                  //  },500);
         //   return false;
        }

    });
    }
}
function countUserajax(fromvar){
    if(fromvar == "user"){
        var ardata = {
            'action' : 'get_user_count',
            'userids' : $("#userids").val()
         };
    }
    else if(fromvar == "cohort"){
        var ardata = {
            'action' : 'get_user_count',
            'cohortids' : $('#cohortids').val()
         };
    }
    
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: ardata,
            //dataType:"json",
            success: function (result) {
              //  console.log(result); 
                var res = JSON.parse(result);
              //  console.log(res.totalUsers);
                if(fromvar == "user"){
                    $("#total_user_div1").html(res.totalUsers);
                    $("#total_uids1").val(res.totalUsers);
                    $("#tuser1").html(res.totalUsers);
                    $('#uids1').val(JSON.stringify(res.userIds));
                }
                else if(fromvar == "cohort"){
                    $("#total_user_div2").html(res.totalUsers);
                    $("#total_uids2").val(res.totalUsers);
                    $("#tuser2").html(res.totalUsers);
                    $('#uids2').val(JSON.stringify(res.userIds));
                }               
                return false;
            }
        });
}
