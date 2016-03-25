(function ($) {
    'use strict';
    /**
     * Default opciones.
     */
    var defaults_options_simple_modal = {
        ocultar_navbar_desplegados: true,
        etiqueta_color_fondo: 'rgba(120,00,200,.8)',
        etiqueta_color_texto: '#ffffff',
        etiqueta_ancho: 70,
        modal_sin_etiqueta: false,
        modal_en_la_derecha: true,
        modal_velocidad_fade: 800,
        modal_velocidad_scroll: 600,
        modal_plano_z: 0,
        modal_posicion_vertical: 120,
        modal_ancho: 200,
        modal_cabecera_color_fondo: '#400090',
        modal_cabecera_color_texto: '#ffffff',
        modal_cuerpo_color_fondo: 'rgba(255,255,255,.8)',
        modal_cuerpo_color_texto: '#ffffff',
        modal_pie_color_texto: '#ffffff'
    };
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
            if (selectorPulsado.opciones.ocultar_navbar_desplegados === true) {
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
            var cabecera = selectorPulsado.modal.find(".cabeceraFormularioModal > span");
            cabecera.empty().html(selectorPulsado.selector.data("titulo"));
            var descripcion = selectorPulsado.selector.data("descripcion") || "";
            var confirmText = selectorPulsado.selector.data("confirmText") || "BORRAR";
            var cancelText = selectorPulsado.selector.data("cancelText") || "CANCELAR";
            var pieFormularioModal = selectorPulsado.selector.data("pie") || "false";
            var confirm = selectorPulsado.selector.data("type") || "confirm";
            var etiquetaWidth = selectorPulsado.selector.css('width');
            var modalWidth = selectorPulsado.modal.css('width');


            //Aplicamos estilos
            selectorPulsado.modal.css('top', selectorPulsado.opciones.modal_posicion_vertical + (opciones.modal_posicion_vertical.toString().indexOf("%") != -1 ? '' : 'px'));
            selectorPulsado.modal.css('z-index', selectorPulsado.opciones.modal_plano_z);
            selectorPulsado.modal.find('.ventanaModal').css('max-width', selectorPulsado.opciones.modal_ancho + 'px');
            selectorPulsado.modal.find('.ventanaModal').css('left', selectorPulsado.opciones.modal_en_la_derecha ? '100%' : 0);
            selectorPulsado.modal.find('.cabeceraFormularioModal').css('background-color', selectorPulsado.opciones.modal_cabecera_color_fondo);
            selectorPulsado.modal.find('.cabeceraFormularioModal').css('color', selectorPulsado.opciones.modal_cabecera_color_texto);
            if (cabecera.length == 0)
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('border', '1px solid ' + selectorPulsado.opciones.etiqueta_color_fondo);
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('background-color', selectorPulsado.opciones.modal_cuerpo_color_fondo);
            selectorPulsado.modal.find('.cuerpoFormularioModal').css('color', selectorPulsado.opciones.modal_cuerpo_color_texto);
            var pieColorFondo = (selectorPulsado.selector.data("opciones.modal_pie_color_fondo") !== undefined) ? selectorPulsado.selector.data("opciones.modal_pie_color_fondo") : selectorPulsado.opciones.modal_cuerpo_color_fondo;
            selectorPulsado.modal.find('.pieFormularioModal').css('background-color', pieColorFondo);
            selectorPulsado.modal.find('.pieFormularioModal').css('color', selectorPulsado.opciones.modal_pie_color_texto);
            selectorPulsado.modal.css('margin-left', selectorPulsado.opciones.modal_en_la_derecha === true ? 0 : '-' + selectorPulsado.opciones.modal_ancho + 'px');
            if (selectorPulsado.opciones.modal_sin_etiqueta === false) {
                selectorPulsado.selector.css('position', 'absolute');
                selectorPulsado.selector.css('text-align', 'center');
                selectorPulsado.selector.css('padding', '5px 3px');
                selectorPulsado.selector.css('min-width', selectorPulsado.opciones.etiqueta_ancho + 'px');
                selectorPulsado.selector.css(selectorPulsado.opciones.modal_en_la_derecha ? 'left' : 'right', 0);
                selectorPulsado.selector.css(selectorPulsado.opciones.modal_en_la_derecha ? 'margin-left' : 'margin-right', '-' + selectorPulsado.opciones.etiqueta_ancho + 'px');
                selectorPulsado.selector.css('background-color', selectorPulsado.opciones.etiqueta_color_fondo);
                selectorPulsado.selector.css('color', selectorPulsado.opciones.etiqueta_color_texto);
                selectorPulsado.selector.css('border-radius', selectorPulsado.opciones.modal_en_la_derecha ? '8px 0 0 8px' : '0 8px 8px 0');
                $(selectorPulsado.selector).mouseenter(function () {
                    $(this).css("cursor", "pointer");
                    $(this).find("i").css("transform", "scale(1.04");
                }).mouseleave(function () {
                    $(this).css("cursor", "default");
                    $(this).find("i").css("transform", "scale(1.0");
                });
            }
            if (descripcion.length > 0) {
                selectorPulsado.modal.find(".cuerpoFormularioModal .scroll")
                    .empty()
                    .append("<div class='text-center'>" + (selectorPulsado.selector.data('descripcion')) + "</div>")
            }
            if (pieFormularioModal.toString().toLowerCase() !== "true") {
                selectorPulsado.modal.find(".ventanaModal > .pieFormularioModal").remove();
            }
            else {
                if (confirm.toString().toLowerCase() !== "confirm") {
                    selectorPulsado.modal.find(".ventanaModal > .pieFormularioModal > div:first-child:not('.actionOkClick')").remove();
                } else {
                    selectorPulsado.modal.find(".ventanaModal > .pieFormularioModal > div:first-child").html(cancelText);
                }
                selectorPulsado.modal.find(".ventanaModal > .pieFormularioModal > div:last-child").html(confirmText);
            }
            //Reajustamos la posición
            window.onresize = $.proxy(selectorPulsado.resize, selectorPulsado);
            $(selectorPulsado.selector).on("click", $.proxy(selectorPulsado.show, selectorPulsado));
            $(selectorPulsado.modal).find('.closeFormModal').on("click", $.proxy(selectorPulsado.hide, selectorPulsado));
            $(selectorPulsado.modal).find('.closeModal').on("click", $.proxy(selectorPulsado.hide, selectorPulsado));
            $(selectorPulsado.modal).find('.ventanaModal .pieFormularioModal .btn').on("click", $.proxy(selectorPulsado.submit, selectorPulsado));
        },
        show: function (evt) {
            evt.preventDefault();
            var ventana = this;
            if ($(ventana.selector).hasClass('closeModal')) {
                this.hide();
                return;
            }
            ventana.modal.find(".modalBackGround").hide().fadeIn(ventana.opciones.modal_velocidad_fade, function () {
                    var animacion = ventana.modal.find(".ventanaModal");
                var side = (ventana.opciones.modal_en_la_derecha === true) ? {"margin-left": '-' + animacion.css("width")} : {"margin-left": animacion.css("width")};
                animacion.animate(side, ventana.opciones.modal_velocidad_scroll, function () {
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
                ventana.opciones.modal_velocidad_scroll, function () {
                    ventana.modal.find(".modalBackGround").fadeOut(ventana.opciones.modal_velocidad_fade, function () {
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
     * How to use: $('#id').simplemodal()
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
            }
        });
    };
//Obtenemos las modales vía clase + data
    $(".simpleModal").each(function (idx, elem) {
        var elemento = elem;
        var opciones = $(elem).data();
        $.each(opciones, function (i, e) {
            defaults_options_simple_modal[i] = e;
        });
        var $this = elem,
            data = $(elem).data('simpleModal'),
            opciones;
        $($this).data('simpleModal', (data = new SimpleModal(elem, defaults_options_simple_modal)));
    });
    $.fn.simplemodal.defaults = defaults_options_simple_modal;
})(jQuery);
$(document).ready(function () {
    $(document).on("click", ".closeErrorModal", function (evt) {
        evt.preventDefault();
        var elementContent = $(evt.target).closest(".alert-dismissible");
        var element = elementContent.find(".errorOn");
        var desplazamiento = parseInt($(".errorOn").css("margin-top")) - parseInt($(".errorOn").outerHeight() + 1) + "px";
        element.animate({'margin-top': desplazamiento}, 1000, function () {
            elementContent.find(".errorOnBackGround").fadeOut(1000);
        });
    });
});