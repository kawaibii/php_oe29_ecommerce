$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: false
    });
})

$(document).ready(function () {
   $(".confirm-delete-supplier").submit(function (event){
       return confirm($(this).data('message'));
   });
});

$(document).on("click", ".edit-supplier", function () {
      $(".loader").show();
      $.ajax({
         url : $(this).data('url'),
         type : "GET",
         success : function (data) {
             $(".loader").hide();
             let supplier = JSON.parse(data);
             $("#form-edit").attr('action', supplier.url);
             $("#edit-name").val(supplier.name);
             $("#edit-phone").val(supplier.phone);
             $("#edit-address").val(supplier.address);
             CKEDITOR.instances['edit-description'].setData(supplier.description);
             $("#modal-edit-supplier").modal("show");
         },
      });
});

$(document).ready(function () {
    let x = $(".define").data('value');
    let url = $(".define").data('route');
    if (x == "create") {
        $("#modal-create-supplier").modal("show");
    }
    if (x == 'edit') {
        $.ajax({
            url : url,
            type : "GET",
            success : function (data) {
                $(".loader").hide();
                let supplier = JSON.parse(data);
                $("#form-edit").attr('action', supplier.url);
                $("#edit-name").val(supplier.name);
                $("#edit-phone").val(supplier.phone);
                $("#edit-address").val(supplier.address);
                CKEDITOR.instances['edit-description'].setData(supplier.description);
                $("#modal-edit-supplier").modal("show");
            },
        });
    }
});
