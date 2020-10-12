$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: false
    });
})

$(document).ready(function () {
    $('.order').click(function(){
       let url = $(this).attr('data-url');
        $.ajax({
            url : url,
            type : "GET",
            success : function (data) {
                $(".loader").hide();
                $("#detail-Order").html(data);
                $("#detail-Order").modal("show");
            }
        });
    });
});
