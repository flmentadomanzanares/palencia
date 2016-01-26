$(function () {
    $(document).on('click', '.borrado', function (e) {
        $(this.form).submit();
        $('#myModal').modal('hide');
    });
});

