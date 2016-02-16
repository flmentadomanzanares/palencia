$(document).ready(function () {
    $("form input[type='file']").on('change', function (event) {
        event.preventDefault();
        var ext = event.target.files[0].type;

        if (['image/gif', 'image/png', 'image/jpg', 'image/jpeg'].indexOf(ext) != -1) {
            $("form img").fadeOut(300, function () {
                $("form img").fadeIn(300).attr('src', URL.createObjectURL(event.target.files[0]));
            });
        }
    });
});