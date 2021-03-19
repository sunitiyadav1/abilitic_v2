 $('#tblleaderboard').DataTable({
    "pagingType": "full_numbers",
    "pageLength":10,
    "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
    dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Leaderboard_excel',
                text:'Export to excel'
                //Columns to export
                //exportOptions: {
               //     columns: [0, 1, 2, 3,4,5,6]
               // }
            },
            {
                extend: 'pdfHtml5',
                title: 'Leaderboard_PDF',
                text: 'Export to PDF'
                //Columns to export
                //exportOptions: {
               //     columns: [0, 1, 2, 3, 4, 5, 6]
              //  }
            }
        ]
 });
 $("#tblleaderboard").on("click","a#viewbutton",function(){
  
    $("#viewDialog").modal("show");
    $("#view_table_div").html("<img src='"+$(this).data("loadurl")+"' />").load($(this).data("url"));

    return false;
 });