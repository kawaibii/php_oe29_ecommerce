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

$(document).on("click", ".btn-import-product", function () {
    $(".loader").show();
    let url = $(this).data('url');
    $.ajax({
        url : url,
        type: "get",
        success : function (data) {
            $(".loader").hide();
            $("#import-product").html(data);
            $("#import-product").modal("show");
        },
        complete : function () {
            $(".submit-import").click(function () {
                $(".loader").show();
                let url = $(this).data('url');
                let idSupplier = $(this).data('id');
                $.ajax ({
                    url : url,
                    type : "POST",
                    data : {
                        "supplier" : idSupplier,
                        "size" : $("#size").val(),
                        "quantity" : $("#quantity").val(),
                        "original_price" : $("#original_price").val(),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (data) {
                        $(".loader").hide();
                        $(".show-size").text('');
                        $(".show-quantity").text('');
                        $(".show-original").text('');
                        let datas = JSON.parse(data);
                        $(".product").each(function () {
                            if (datas.id == $(this).data('id')) {
                                $(this).find(".product-quantity").text(datas.quantity);
                                $(this).find(".original-price").text(datas.original_price + " " + "VND");
                            }
                        });
                        alert(datas.message);
                    },
                    error : function (data) {
                        $(".loader").hide();
                        if (data.status == 422) {
                            let errors = data.responseJSON;
                            $(".show-size").text(errors.errors.size);
                            $(".show-quantity").text(errors.errors.quantity);
                            $(".show-original").text(errors.errors.original_price);
                        }
                    }
                });
            });
        }
    });
});

