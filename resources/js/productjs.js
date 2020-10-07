$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});

window.deleteProduct = function (e) {
    return confirm(e.getAttribute('data-message'));
}

function previewImages() {
    var preview = document.querySelector('#preview');
    console.log(preview.childElementCount);
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
    if( x == "create"){
        $("#myModal").modal("show");
    }
});

