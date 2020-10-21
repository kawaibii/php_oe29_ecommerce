$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});

$(document).on("click", ".edit-product", function () {
        $(".loader").show();
        let url = this.getAttribute('data-url');
        $.ajax({
            url : url,
            type : "get",
            success : function (data) {
                let json = JSON.parse(data);
                $("#formEdit").attr("action", json.url);
                $(".loader").hide();
                $("#name_edit").val(json.name);
                $("#original_price_edit").val(json.original_price);
                $("#current_price_edit").val(json.current_price);
                $('.category option').each(function() {
                    if ($(this).val() == json.category) {
                        $(this).prop("selected", true);
                    }
                });
                $('.brand option').each(function() {
                    if ($(this).val() == json.brand) {
                        $(this).prop("selected", true);
                    }
                });
                CKEDITOR.instances['description_edit'].setData(json.description);
                $("#Modaledit").modal("show");

            },
            error : function (data) {
                (".loader").hide();
                confirm("not working");
            }
        })
})

window.deleteProduct = function (e) {
    return confirm(e.getAttribute('data-message'));
}

window.confirmDelete = function (e) {
    return confirm(e.getAttribute('data-message'));
}

function previewImages() {
    var preview = document.querySelector('#preview');
    for (let i = 0; i < preview.childNodes.length ; i++) {
        preview.removeChild(preview.childNodes[i]);
    }
    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }
    function readAndPreview(file) {
        var reader = new FileReader();
        reader.addEventListener("load", function() {
            var image = new Image();
            image.id ="images-product";
            image.height = 100;
            image.title  = file.name;
            image.src    = this.result;
            preview.appendChild(image);
        });
        reader.readAsDataURL(file);
    }
}

document.querySelector('#file-input').addEventListener("change", previewImages);

$(document).ready(function (e) {
    let x = $(".define").data('value');
    let url = $(".define").data('route');
    if ( x == "create") {
        $("#myModal").modal("show");
    }
    if (x == "edit") {
        $.ajax({
            url : url,
            type : "get",
            success : function (data) {
                let json = JSON.parse(data);
                $("#formEdit").attr("action", json.url);
                $(".loader").hide();
                $("#name_edit").val(json.name);
                $("#original_price_edit").val(json.original_price);
                $("#current_price_edit").val(json.current_price);
                $('.category option').each(function() {
                    if ($(this).val() == json.category) {
                        $(this).prop("selected", true);
                    }
                });
                $('.brand option').each(function() {
                    if ($(this).val() == json.brand) {
                        $(this).prop("selected", true);
                    }
                });
                CKEDITOR.instances['description_edit'].setData(json.description);
                $("#Modaledit").modal("show");
            },
            error : function (data) {
                (".loader").hide();
                alert("not found");
            }
        });
        $("#Modaledit").modal("show");
    }
});
