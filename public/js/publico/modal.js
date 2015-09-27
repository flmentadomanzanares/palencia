/*
 * 03/01/2015
 * Ventana modal.
 * Desarrollado por Francisco Luis Mentado Manzanares.
 *
 */
$(function () {
    var velocidadFade = 500;
    var velocidadScroll = 800;
    $(window).resize(function () {

        if ($("#formularioModal").css("display") == "block") {
            $("#formularioModal .ventanaModal").css("margin-left", '-' + parseInt($("#formularioModal .ventanaModal").css("width")) + "px");
        }
    });
    $('a.formularioModal, area.formularioModal').on('click', function (evt) {
        evt.preventDefault();
        $("#formularioModal").hide().fadeIn(velocidadFade, function () {
                $("#formularioModal .ventanaModal").animate({"margin-left": '-' + $("#formularioModal .ventanaModal").css("width")}, velocidadScroll);
            }
        );
    });
    $('a.closeFormModal').on('click', function (evt) {
        evt.preventDefault();
        $("#formularioModal .ventanaModal").animate({"margin-left": "0"},
            velocidadScroll, function () {
                $("#formularioModal").fadeOut(velocidadFade);
            }
        );
    });
});