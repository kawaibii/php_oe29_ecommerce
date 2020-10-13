$(document).ready(function() {
    $('.btn-size').click(function() {
        let size = $(this).val();
        $('.btn-size').css({
            'background': '#fff',
            'color': '#000'
        });
        $(this).css({
            'background': '#FE2E2E',
            'color': '#fff'
        });
        $("#quantity").removeAttr("disabled");
        $(".quantity-right-plus").removeAttr("disabled");
        $(".quantity-left-minus").removeAttr("disabled");

        let url = $(this).attr("data-url");
        $.ajax({
            url : url,
            type : "GET",
            success : function (data) {
                let json = JSON.parse(data);
                $("#quantity-size").text(json.quantity);
            },
            error : function($data) {
                alert('Fail');
            }
        });
    });

    let quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
    });

    $('.quantity-left-minus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

    $(".list-image").click(function() {
        let src = $(this).attr("src");
        $("#image-show").attr("src", src);
    });
});
