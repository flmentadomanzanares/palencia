(function ($) {
    'use strict';

    /**
     * Constructor.
     */
    var SimpleModal = function (selector, opciones) {
        this.init(selector, opciones);
    };

    /**
     * SimpleModal class.
     */
    SimpleModal.prototype = {
        constructor: SimpleModal,

        init: function (selector, opciones) {
            var selectorPulsado = this;
            selectorPulsado.selector = $(selector);
            selectorPulsado.opciones = $.extend({}, $.fn.simplemodal.defaults, opciones);
            if (selectorPulsado.opciones.ocultarMenu === true) {
                if ($("li.dropdown").hasClass("open")) {
                    $("li.dropdown").removeClass("open");
                }
            }
            if (selectorPulsado.selector.data('selectorId')) {
                selectorPulsado.modal = $("#" + selectorPulsado.selector.data("selectorId"));
            } else if (selectorPulsado.selector.closest(".formularioModal").length > 0)
                selectorPulsado.modal = selectorPulsado.selector.closest(".formularioModal");
            else {
                selectorPulsado.modal = selectorPulsado.selector.next(".formularioModal");
            }
            selectorPulsado.modal.find(".headerFormularioModal > span").empty().html(selectorPulsado.selector.data("title"));
            var descripcion = selectorPulsado.selector.data("descripcion") || "";
            var confirmText = selectorPulsado.selector.data("confirmText") || "BORRAR";
            var cancelText = selectorPulsado.selector.data("cancelText") || "CANCELAR";
            var footer = selectorPulsado.selector.data("footer") || "false";
            var confirm = selectorPulsado.selector.data("type") || "confirm";

            //Aplicamos estilos

            selectorPulsado.modal.css('top', selectorPulsado.opciones.ventanaPosicionY + 'px');
            selectorPulsado.modal.css('z-index', isNaN(selectorPulsado.modal.css('z-index')) ? 0 : selectorPulsado.modal.css('z-index') + selectorPulsado.opciones.ventanaPlano);
            selectorPulsado.modal.find('.ventanaModal').css('max-width', selectorPulsado.opciones.ventanaAnchoMaximo + 'px');
            selectorPulsado.modal.find('.ventanaModal').css('left', selectorPulsado.opciones.enLaDerecha ? '100%' : 0);
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('border', '1px solid ' + selectorPulsado.opciones.etiquetaColorFondo);
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('background-color', selectorPulsado.opciones.ventanaCuerpoColorFondo);
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('color', selectorPulsado.opciones.ventanaCuerpoColorTexto);
            selectorPulsado.modal.find('.footerFormularioModal').css('background-color', selectorPulsado.opciones.ventanaPieColorFondo);
            selectorPulsado.modal.find('.footerFormularioModal').css('color', selectorPulsado.opciones.ventanaPieColorTexto);
            selectorPulsado.modal.css('margin-left', selectorPulsado.opciones.enLaDerecha === true ? 0 : '-' + selectorPulsado.selector.css('width'));
            selectorPulsado.selector.css('position', 'absolute');
            selectorPulsado.selector.css('text-align', 'center');
            selectorPulsado.selector.css('padding', '3px 3px 4px 3px');
            selectorPulsado.selector.css('min-width', selectorPulsado.opciones.etiquetaAncho + 'px');
            selectorPulsado.selector.css(selectorPulsado.opciones.enLaDerecha ? 'left' : 'right', 0);
            selectorPulsado.selector.css(selectorPulsado.opciones.enLaDerecha ? 'margin-left' : 'margin-right', '-' + selectorPulsado.selector.css('width'));

            selectorPulsado.selector.css('background-color', selectorPulsado.opciones.etiquetaColorFondo);
            selectorPulsado.selector.css('color', selectorPulsado.opciones.etiquetaColorTexto);
            selectorPulsado.selector.css('border-radius', selectorPulsado.opciones.enLaDerecha ? '8px 0 0 8px' : '0 8px 8px 0');

            $(selectorPulsado.selector).mouseenter(function () {
                $(this).css("cursor", "pointer");
            }).mouseleave(function () {
                $(this).css("cursor", "default");
            });

            if (descripcion.length > 0) {
                selectorPulsado.modal.find(".cuerpoFormularioModal .scroll")
                    .empty()
                    .append("<div class='text-center'>" + (selectorPulsado.selector.data('descripcion')) + "</div>")
            }
            if (footer.toString().toLowerCase() !== "true") {
                selectorPulsado.modal.find(".ventanaModal > .footerFormularioModal").remove();
            }
            else {
                if (confirm.toString().toLowerCase() !== "confirm") {
                    selectorPulsado.modal.find(".ventanaModal > .footerFormularioModal > div:first-child:not('.actionOkClick')").remove();
                } else {
                    selectorPulsado.modal.find(".ventanaModal > .footerFormularioModal > div:first-child").html(cancelText);
                }
                selectorPulsado.modal.find(".ventanaModal > .footerFormularioModal > div:last-child").html(confirmText);
            }
            //Reajustamos la posición
            window.onresize = $.proxy(selectorPulsado.resize, selectorPulsado);
            $(selectorPulsado.selector).on("click", $.proxy(selectorPulsado.show, selectorPulsado));
            $(selectorPulsado.modal).find('.closeFormModal').on("click", $.proxy(selectorPulsado.hide, selectorPulsado));
            $(selectorPulsado.modal).find('.closeModal').on("click", $.proxy(selectorPulsado.hide, selectorPulsado));
            $(selectorPulsado.modal).find('.ventanaModal .footerFormularioModal .btn').on("click", $.proxy(selectorPulsado.submit, selectorPulsado));
        },
        show: function (evt) {
            evt.preventDefault();
            var ventana = this;
            if ($(ventana.selector).hasClass('closeModal')) {
                this.hide();
                return;
            }
            ventana.modal.find(".modalBackGround").hide().fadeIn(ventana.opciones.vFade, function () {
                    var animacion = ventana.modal.find(".ventanaModal");
                var side = (ventana.opciones.enLaDerecha === true) ? {"margin-left": '-' + animacion.css("width")} : {"margin-left": animacion.css("width")};
                    animacion.animate(side, ventana.opciones.vScroll, function () {
                        ventana.modal.find('.lanzarModal').addClass('closeModal');
                        ventana.modal.find('.lanzarModal').removeClass('lanzarModal');
                    });
                }
            );
        },
        hide: function (evt) {
            if (evt)
                evt.preventDefault();
            var ventana = this;
            var animacion = ventana.modal.find(".ventanaModal");
            animacion.animate({"margin-left": "0"},
                ventana.opciones.vScroll, function () {
                    ventana.modal.find(".modalBackGround").fadeOut(ventana.opciones.vFade, function () {
                        ventana.modal.find('.closeModal').addClass('lanzarModal');
                        ventana.modal.find('.closeModal').removeClass('closeModal');
                    });
                }
            );
        },
        resize: function (evt) {
            evt.preventDefault();
            var ventana = this;
            if (ventana.modal == undefined)
                return;
            if (ventana.modal.find(".modalBackGround").css("display") == "block") {
                var resizeModal = ventana.modal.find(".ventanaModal");
                resizeModal.css("margin-left", '-' + parseInt(resizeModal.css("width")) + "px");
            }
        },
        submit: function (evt) {
            evt.preventDefault();
            var ventana = this;
            ventana.hide();
            var botonPulsado = $(evt.target);
            if (botonPulsado.hasClass('actionOkClick')) {
                var form = botonPulsado.closest("form");
                if (form.length > 0) {
                    form.submit();
                }
            }
        }
    };

    /**
     * Plugin definition.
     * How to use: $('#id').simplecolorpicker()
     */
    $.fn.simplemodal = function (option) {
        var args = $.makeArray(arguments);
        args.shift();

        // For HTML element passed to the plugin
        return this.each(function () {
            var $this = $(this),
                data = $this.data('simpleModal'),
                opciones = typeof option === 'object' && option;
            if (data === undefined) {
                $this.data('simpleModal', (data = new SimpleModal(this, opciones)));
            }
            if (typeof option === 'string') {
                data[option].apply(data, args);
                console.log(data[option]);
            }
        });
    };

    /**
     * Default opciones.
     */
    $.fn.simplemodal.defaults = {
        enLaDerecha: true,
        ocultarMenu: true,
        vFade: 800,
        vScroll: 600,
        etiquetaColorFondo: 'rgba(120,00,200,.8)',
        etiquetaColorTexto: '#ffffff',
        etiquetaAncho: 60,
        ventanaPlano: 0,
        ventanaPosicionVertical: 120,
        ventanaAnchoMaximo: 200,
        ventanaCabeceraColorFondo: '#400090',
        ventanaCabeceraColorTexto: '#ffffff',
        ventanaCuerpoColorFondo: 'rgba(255,255,255,.8)',
        ventanaCuerpoColorTexto: '#ffffff',
        ventanaPieColorFondo: '#400090',
        ventanaPieColorTexto: '#ffffff'
    };
})(jQuery);

