$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
})

$(document).on("click", ".order", function () {
    $(".loader").show();
    let td = $(this);
    let url = $(this).attr('data-url');
    $.ajax({
        url : url,
        type : "GET",
        success : function (data) {
            $(".loader").hide();
            $("#detail-order").html(data);
            $("#detail-order").modal("show");
        },
        error : function (data) {
            $(".loader").hide();
            alert("Product not exists");
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
                    success : function (response) {
                        let data = JSON.parse(response);
                        $.jAlert({
                            'title': 'success',
                            'content': data.message,
                            'theme': "blue",
                            'closeOnClick': true,
                            'backgroundColor': 'white',
                            'btns': [
                                {'text':'OK', 'theme':"blue"}
                            ]
                        });
                        $(".status-order div").each(function (){
                            if ($(this).data('id') == data.id) {
                                $(this).removeClass();
                                $(this).addClass("alert alert-info");
                                $(this).text(data.approved);
                            }
                        });
                        $("#detail-order").modal('hide');
                       },
                       error : function (data) {
                           errorAlert("not working");
                           $("#detail-order").modal('hide');
                       }
                    });
                });

            $(".rejected-order").click(function () {
                let that = this;
                confirm(function (e) {
                    e.preventDefault();
                    let url = that.getAttribute('data-url');
                    $.ajax({
                        url : url,
                        type : "PATCH",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (response) {
                            let data = JSON.parse(response);
                            $.jAlert({
                                'title': 'success',
                                'content': data.message,
                                'theme': "blue",
                                'closeOnClick': true,
                                'backgroundColor': 'white',
                                'btns': [
                                    {'text':'OK', 'theme':"blue"}
                                ]
                            });
                            $(".status-order div").each(function (){
                                if ($(this).data('id') == data.id) {
                                    $(this).removeClass();
                                    $(this).addClass("alert alert-danger");
                                    $(this).text(data.rejected);
                                    $("#detail-order").modal('hide');
                                }
                            });
                        },
                        error : function (data) {
                            errorAlert('not working');
                            $("#detail-order").modal('hide');
                        }
                    });
                    return false;
                }, function (){
                    errorAlert("errors");
                    return false;
                })
            });
        }
    });
});

$(document).ready(function (){
        let url = $(".detail_order").data('url');
        if (url) {
            $.ajax({
                url : url,
                type : "GET",
                success : function (data) {
                    $(".loader").hide();
                    $("#detail-order").html(data);
                    $("#detail-order").modal("show");
                },
                error : function (data) {
                    $(".loader").hide();
                    alert("Product not exists");
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
                            success : function (response) {
                                let data = JSON.parse(response);
                                $.jAlert({
                                    'title': 'success',
                                    'content': data.message,
                                    'theme': "blue",
                                    'closeOnClick': true,
                                    'backgroundColor': 'white',
                                    'btns': [
                                        {
                                            'text':'OK',
                                            'theme':"blue"
                                        }
                                    ]
                                });
                                $(".status-order div").each(function (){
                                    if ($(this).data('id') == data.id) {
                                        $(this).removeClass();
                                        $(this).addClass("alert alert-info");
                                        $(this).text(data.approved);
                                    }
                                });
                                $("#detail-order").modal('hide');
                            },
                            error : function (data) {
                                alert("not working");
                                $("#detail-order").modal('hide');
                            }
                        });
                    });

                    $(".rejected-order").click(function () {
                        let that = this; // khai bao de co the trong confirm truy cap duoc this
                        confirm(function (e) {
                            e.preventDefault();
                            let url = that.getAttribute('data-url');
                            $.ajax({
                                url : url,
                                type : "PATCH",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success : function (response) {
                                    let data = JSON.parse(response);
                                    $.jAlert({
                                        'title': 'success',
                                        'content': data.message,
                                        'theme': "blue",
                                        'closeOnClick': true,
                                        'backgroundColor': 'white',
                                        'btns': [
                                            {
                                                'text':'OK',
                                                'theme':"blue"
                                            }
                                        ]
                                    });
                                    $(".status-order div").each(function (){
                                        if ($(this).data('id') == data.id) {
                                            $(this).removeClass();
                                            $(this).addClass("alert alert-danger");
                                            $(this).text(data.rejected);
                                            $("#detail-order").modal('hide');
                                        }
                                    });
                                },
                                error : function (data) {
                                    errorAlert('not working');
                                    $("#detail-order").modal('hide');
                                }
                            });
                            return false;
                        }, function (){
                            errorAlert("errors");
                            return false;
                        })
                    });
                }
            });
        }
    }
);
