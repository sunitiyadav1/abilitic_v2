$(document).ready(function () {
    // alert("here");
  //  $('#tbltraining').DataTable();
});
 var tbltraining =   $('#tbltraining').DataTable( {
        //"dom": "Bfrtip",
         "processing": true,
         "serverSide": true,
         //"ajax": "ajaxpaging.php",
          "pageLength": 10,
          "ajax": {
            url: "ajax.php?action=get_trainingform",
            type: 'GET'
          },
         // "bSortable":true,
            "deferRender": true,
            //data :res.data,
          "columns": [ //'Store Name', 'Total No of Training Done', 'Total No of Planned Training','Total No of UnPlanned Training'
            { data: 'srno',"bSortable":true },
            //{ data: 'formtype',"bSortable":true},
            { data: 'usercount' },
            { data: 'start_date' },
            { data: 'end_date'},
            { data: 'document_submitted' },
            { data: 'created_at' },                           
            {
                data: 'action',
                className: "center",
                //defaultContent: '<a href="" class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
            }
            ],
        /* "initComplete": function( settings, json ) {
           // $("#loader_div").hide();
           // $("#search_result_div").show();
          },
        "preDrawCallback": function( settings ) {
        //  $("#loader_div").show();
         // $("#search_result_div").hide();
            } ,
        "drawCallback" :function( settings ) {
        //$('#example tbody').off( 'click', 'td' );
        //console.log("draw event");
       //   $("#loader_div").hide();
        //  $("#search_result_div").show();
        }  */       
      
    } );         

$("#table_div").on("click", "#viewcert", function () {
    // alert("click on view cert link" + $(this).data('url'));
    $("#cert_div").hide();
    $("#viewdetailModal").modal('show');
    if($(this).data('url') != ""){
       
        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            data: { action: 'view_files', trainingformid: $(this).data('id'),ids:$(this).data('ids') },
            success: function (data) {
    
                  console.log(data);
                  $("#cert_div").html(data).show();
               /* $("#viewdetail_div").html('').hide();
                $("#cert_div").hide();
                $("#viewdetailModal").modal('show');
                $("#loader_div").hide();
                $("#viewdetail_div").html(data).show();*/
                return false;
            }
        });
       // $("#cert_div").html("<img src='" + $(this).data('url') + "' width=400 height=300>").show();
    }
    else{
        $("#cert_div").html("No Image Found").show();
    }
    $("#loader_div").hide();
     $("#viewdetail_div").html('').hide();
    return false;

});
$("#table_div").on("click", "#viewdetail", function () {
    // alert("click on view detail link" + $(this).data('url'));
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: { action: 'view_details', id: $(this).data('id') },
        success: function (data) {

            //  console.log(data);
            $("#viewdetail_div").html('').hide();
            $("#cert_div").hide();
            $("#viewdetailModal").modal('show');
            $("#loader_div").hide();
            $("#viewdetail_div").html(data).show();
            return false;
        }
    });
    return false;
});
$("#table_div").on("click", "#deletedetail", function () {
    // alert("click on view detail link" + $(this).data('url'));
    $("#deleteid").val($(this).data('id'));
    $("#deleteModal").modal("show");
    return false;
});
$("#deleteModal").on("click","#btnyes",function(){
    var did = $("#deleteid").val();
    $.ajax({
        url: "ajax.php",
        type: 'POST',
        data: { action: 'delete_details', id: did },
        success: function (data) {
 $("#deleteModal").modal("hide");
            var d = JSON.parse(data);
            // if(d.status ==1){
               //  $("#table_div").html(d.result);
                 $("#table_msg").html(d.message).show();
                 setTimeout(function(){
                      $("#table_msg").html('').hide();
                 },2000);
                 //$('#tbltraining').DataTable().ajax.reload();
                 tbltraining.ajax.reload(null,false);
               //  $('#tbltraining').DataTable();
                
            return false;
        }
    });
});
$("#viewdetailModal").on("click","a#adownload",function(){
    //alert("heh"+$(this).data('id'));
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: { action: 'download_file', id: $(this).data('id') },
        success: function (data) {

              console.log(data);
            /*$("#viewdetail_div").html('').hide();
            $("#cert_div").hide();
            $("#viewdetailModal").modal('show');
            $("#loader_div").hide();
            $("#viewdetail_div").html(data).show();*/
            return false;
        }
    });
    return false;
});

//
//var table = $('#tbltraining').DataTable();