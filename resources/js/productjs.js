$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});

window.deleteProduct = function (e) {
    return confirm(e.getAttribute('data-message'));
}
