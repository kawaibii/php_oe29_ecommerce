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
