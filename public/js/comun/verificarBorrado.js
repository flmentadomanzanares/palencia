$(document).ready(function () {
    var velocidadFade = 500;
    var velocidadScroll = 800;
    var selector;
    $(window).resize(function () {
        if ($(selector).css("display") == "block") {
            $(selector + " .ventanaModal").css("margin-left", '-' + parseInt($(selector + " .ventanaModal").css("width")) + "px");
        }
    });
    $('button.verificarBorrado').on('click', function (evt) {
        evt.preventDefault();
        selector = "#" + $(this).data("selector");
        $(selector + " .headerFormularioModal > span").empty().html($(this).data("title"));
        $(selector + " .cuerpoFormularioModal .scroll > span").empty().html($(this).data("descripcion"));
        $(selector).hide().fadeIn(velocidadFade, function () {
                $(selector + " .ventanaModal").animate({"margin-left": '-' + $(selector + " .ventanaModal").css("width")}, velocidadScroll);
            }
        );
    });
    $('a.closeFormModal').on('click', function (evt) {
        evt.preventDefault();
        $(selector + " .ventanaModal").animate({"margin-left": "0"},
            velocidadScroll, function () {
                $(selector).fadeOut(velocidadFade);
            }
        );
    });
});
