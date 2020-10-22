$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: false
    });
})

$(document).ready(function () {
    $('.order').click(function() {
        $(".loader").show();
        let td = $(this);
       let url = $(this).attr('data-url');
        $.ajax({
            url : url,
            type : "GET",
            success : function (data) {
                $(".loader").hide();
                $("#detail-Order").html(data);
                $("#detail-Order").modal("show");
            },
            error : function (data) {
                $(".loader").hide();
                alert("not working");
            },
            complete : function () {
                $(".approved-order").click(function () {
                    let url = this.getAttribute('data-url');
                    $.ajax({
                       url : url,
                       type: "PATCH",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                       success : function (data) {
                           let json = JSON.parse(data);
                           alert(json.message);
                           $(".status-order div").each(function (){
                               if ($(this).data('id') == json.id) {
                                   $(this).removeClass();
                                   $(this).addClass("alert alert-info");
                                   $(this).text("approved");
                               }
                           });
                           $("#detail-Order").modal('hide');
                       },
                       error : function (data) {
                           alert("not working");
                           $("#detail-Order").modal('hide');
                       }
                    });
                });

                $(".rejected-order").click(function () {
                    let check = confirm("rejected ???");
                    if (check == true) {
                        let url = this.getAttribute('data-url');
                        $.ajax({
                            url : url,
                            type : "PATCH",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function (data) {
                                let json = JSON.parse(data);
                                alert(json.message);
                                $(".status-order div").each(function (){
                                    if ($(this).data('id') == json.id) {
                                        $(this).removeClass();
                                        $(this).addClass("alert alert-danger");
                                        $(this).text("Rrejected");
                                        $("#detail-Order").modal('hide');
                                    }
                                });
                            },
                            error : function (data) {
                                alert('not working');
                                $("#detail-Order").modal('hide');
                            }
                        });
                    }
                });
            }
        });
    });
});
