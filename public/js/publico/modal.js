$(document).ready(function () {
    var velocidadFade = 500;
    var velocidadScroll = 800;
    var selector;
    $(window).resize(function () {
        if (selector == undefined)
            return;
        if (selector.css("display") == "block") {
            var resizeModal = selector.find(".ventanaModal");
            resizeModal.css("margin-left", '-' + parseInt(resizeModal.css("width")) + "px");

        }
    });
    $('.lanzarModal').on('click', function (evt) {
        evt.preventDefault();
        if ($("li.dropdown").hasClass("open")) {
            $("li.dropdown").removeClass("open");
        }
        var elementoClick = $(this);
        if (elementoClick.data('selectorId')) {
            selector = $("#" + elementoClick.data("selectorId"));
        } else {
            selector = elementoClick.next(".formularioModal");
        }
        selector.find(".headerFormularioModal > span").empty().html(elementoClick.data("title"));
        var descripcion = elementoClick.data("descripcion") || "";
        var confirmText = elementoClick.data("confirmText") || "BORRAR";
        var cancelText = elementoClick.data("cancelText") || "CANCELAR";
        var footer = elementoClick.data("footer") || "false";
        var confirm = elementoClick.data("type") || "confirm";

        if (descripcion.length > 0) {
            selector.find(".cuerpoFormularioModal .scroll")
                .empty()
                .append("<div class='text-center'>" + (elementoClick.data('descripcion')) + "</div>")
        }
        if (String.toLowerCase(footer) !== "true") {
            selector.find(".ventanaModal > .footerFormularioModal").remove();
        }
        else {
            if (String.toLowerCase(confirm) !== "confirm") {
                selector.find(".ventanaModal > .footerFormularioModal > div:first-child:not('.actionOkClick')").remove();
            } else {
                selector.find(".ventanaModal > .footerFormularioModal > div:first-child").html(cancelText);
            }
            selector.find(".ventanaModal > .footerFormularioModal > div:last-child").html(confirmText);
        }
        selector.hide().fadeIn(velocidadFade, function () {
                var animacion = selector.find(".ventanaModal");
                animacion.animate({"margin-left": '-' + animacion.css("width")}, velocidadScroll);
            }
        );
    });
    $('.closeFormModal').on('click', function (evt) {
        evt.preventDefault();
        cerrarModal(selector);
    });

    $('.ventanaModal .footerFormularioModal').on('click', '.btn', function (evt) {
        evt.preventDefault();
        cerrarModal(selector);
        if ($(this).hasClass('actionOkClick')) {
            var form = $(this).closest("form");
            if (form.length > 0) {
                form.submit();
            }
        }
    });

    var cerrarModal = function (selector) {
        var animacion = selector.find(".ventanaModal");
        animacion.animate({"margin-left": "0"},
            velocidadScroll, function () {
                selector.fadeOut(velocidadFade);
            }
        );
    };
});
