
// Edit Modal 
$('.edit_contact').on("click",function(e){
 
    var id = $(this).attr("data-id");
    $.ajax({
        type: 'GET', 
        url: 'contact/'+id,
        dataType: 'json',
        success: function (data) {
        
        var contact = [];

        $.each(data,function(key,value){
            contact.push(value);
        });

        $("#infoFormEdit").attr("action","/contact/"+id);

        $("#eprenom").val(contact[0]);
        $("#enom").val(contact[1]);
        $("#ee_mail").val(contact[2]);
        $("#eorgnom").val(contact[3]);
        $("#eorgadresse").val(contact[4]);
        $("#eorgcode_postal").val(contact[5]);
        $("#eorgville").val(contact[6]);
        $("#eorgstatut").val(contact[7]);

        var attr = $('#edit-modal').attr('aria-hidden');
        if (typeof attr !== 'undefined' && attr !== false) {
            $('#annuler_edit').trigger('click');   
        }
           

        },error:function(){ 
             console.log(data);
        }

    });

});

// View Modal 
$('.view_modal').on("click",function(e){
 
    var id = $(this).attr("data-id");
    $.ajax({
        type: 'GET', 
        url: 'contact/'+id,
        dataType: 'json',
        success: function (data) {
        
        var contact = [];

        $.each(data,function(key,value){
            contact.push(value);
        });
        $("#vprenom").val(contact[0]);
        $("#vnom").val(contact[1]);
        $("#ve_mail").val(contact[2]);
        $("#vorgnom").val(contact[3]);
        $("#vorgadresse").val(contact[4]);
        $("#vorgcode_postal").val(contact[5]);
        $("#vorgville").val(contact[6]);
        $("#vorgstatut").val(contact[7]);

        var attr = $('#view-modal').attr('aria-hidden');
        if (typeof attr !== 'undefined' && attr !== false) {
            $('#annuler').trigger('click');   
        }
           
        },error:function(){ 
             console.log(data);
        }

    });

});


//Delete Modal
$('.delete_contact').on("click",function(e){
    var id = $(this).attr("data-id");

    $("#contactid").val(id);

    $('#annuler_dele').trigger('click');   
  


});

// Datatable
$('#data-table').DataTable({
    searching : true,   
    columnDefs: [
        {
          orderable: false,
          targets: "no-sort"
        },
        {
            searchable: false,
            targets: "no-search"
        },
    ],
    
});

$('#search-input').on('keyup', function () {
    var table =  $('#data-table').DataTable();
    table.search($(this).val()).draw();
} );


$('#confirmBtn').on('click',function(){
    $('#infoForm').submit();
});
$('#cancelBtn').on('click',function(){
    window.location.reload();
});

