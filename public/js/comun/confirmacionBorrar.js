$(function () {
    $(document).on('click', '.realizarBorrado', function (evt) {
        evt.preventDefault();
        //$(this).closest('form').submit();
        $('#verificarBorrado').modal('hide');
    });
});

