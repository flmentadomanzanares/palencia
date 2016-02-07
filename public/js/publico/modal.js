/*
 * 03/01/2015
 * Ventana modal.
 * Desarrollado por Francisco Luis Mentado Manzanares.
 *
 */
$(document).ready(function () {
    var velocidadFade = 500;
    var velocidadScroll = 800;
    var selector;
    $(window).resize(function () {
        if ($(selector).css("display") == "block") {
            $(selector + " .ventanaModal").css("margin-left", '-' + parseInt($(selector + " .ventanaModal").css("width")) + "px");
        }
    });
    $('a.mostrarformularioModal').on('click', function (evt) {
        evt.preventDefault();
        if ($("li.dropdown").hasClass("open"))
            $("li.dropdown").removeClass("open");
        selector = "#" + $(this).data("selector");
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