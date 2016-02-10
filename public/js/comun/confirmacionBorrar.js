$(function () {
    $(document).on('click', '.verificarBorrado', function (e) {
        $(this).closest('form').submit();
        $('#verificarBorrado').modal('hide');
    });
});

