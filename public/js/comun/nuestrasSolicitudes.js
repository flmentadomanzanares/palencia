$(document).ready(function () {

    var inputsContainer = $("form [data-role='contenedor_imputs']");
    var cursillosInputs = inputsContainer.find("[data-role='cursillos']");
    var destinatarioInputs = inputsContainer.find("[data-role='destinatarios']");

    var scrollAlFinal = function () {
        window.scrollTo(0, document.body.scrollHeight);
    };

    var quitarPonerUnCursoFormulario = function (curso) {
        var elem = $(curso);
        var id = elem.closest("tr").data("id");
        if (elem.prop("checked")) {
            cursillosInputs.append("<input type='hidden' name='cursos[]' value='" + id + "'>");
        } else {
            cursillosInputs.find("[value='" + id + "']").remove();
        }
    };

    var ponerDestinatario = function (elem) {
        if (isNaN(parseInt($(elem).val())))
            return false;
        destinatarioInputs.append("<input type='hidden' name='comunidadesDestinatarias[]' value='" + elem.val() + "'>");
        elem.closest(".table-size-optima")
            .find("[data-role='comunidades_destinatarias']")
            .append("<div data-role='destinatario' data-val='" + elem.val()
                + "' class='alert alert-info'>"
                + elem.text()
                + "<span class='badge pointer pull-right'>Quitar</span></div>");
        return true;
    };
    var eliminarDestinatario = function (val) {
        destinatarioInputs.find("[value='" + val + "']").remove();
    };

    var poner_comunicacion = function (modalidadComunicacion) {
        $.ajax({
            data: {
                'modalidadComunicacion': modalidadComunicacion,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'cambiarComunidadesNoPropiasSolicitudes',
            success: function (data) {
                destinatarioInputs.empty();
                $("[data-role='seleccion_destinatarios'] div.panel-heading").text("Medio de comunicación :" + $("select[name='modalidad']>option:selected").text());
                $("[data-role='comunidades_destinatarias']").empty();

                var comunidadesNoPropias = $("select[name='comunidadesDestinatarias']");

                comunidadesNoPropias.empty();
                comunidadesNoPropias.append("<option>----------</option>");
                $.each(data.comunidades, function (key, element) {
                    comunidadesNoPropias.append("<option value='" + element.id + "'>" + element.comunidad + "</option>");
                });
            },
            error: function () {
            }
        });
    };

    var totalAnyos = function (comunidadPropiaId) {
        var comunidad = [];
        comunidad.push(parseInt(comunidadPropiaId));
        $.ajax({
            data: {
                'comunidadesIds': comunidad,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'totalAnyos',
            success: function (data) {
                var anyos = $("select[name='anyo']");
                var anyoSeleccionado = data[anyos.val()] === undefined ? 0 : anyos.val();
                anyos.empty();
                $.each(data, function (key, element) {
                    anyos.prepend("<option value='" + element + "'>" + element + "</option>");
                });
                anyos.append("<option value='0'>Todos los años</option>");
                anyos.val(anyoSeleccionado);
                totalCursillos(
                    comunidadPropiaId,
                    anyos.val()
                );
            },
            error: function () {
            }
        });
    };
    //Ajax para obtener los cursos de la/s comunidad/es anualmente
    var totalCursillos = function (comunidadPropiaId, year) {
        $.ajax({
            data: {
                'comunidad': comunidadPropiaId,
                'anyo': year,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'listadoCursillosSolicitudes',
            success: function (data) {
                var html = "";
                cursillosInputs.empty();
                var anyoActual = (new Date).getFullYear();
                if (data.length > 0) {
                    $.each(data, function (key, element) {
                        var fecha = formatoFecha(new Date(element.fecha_inicio));
                        html += "<table class='table-viaoptima'><thead>" +
                            "<tr class='row-fixed'>" +
                            "<th class='fixed-checkBoxLgContainer'></th>" +
                            "<th class='tabla-ancho-columna-texto'></th>" +
                            "<th class='" + (parseInt(element.anyo) !== anyoActual ? 'asterisco' : '') + " text-right' title='No pertenece al año actual'></th>" +
                            "</tr>" +
                            "<tr style='Background: " + element.colorFondo + ";'>" +
                            "<th colspan='3' style='Color: " + element.colorTexto + ";' class='text-center'>" + element.comunidad + "</th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>" +
                            "<tr data-id='" + element.id + "'>" + "<td rowspan='3'><input class='lg' type='checkbox' name='curso'></td><td>Curso</td><td>" + element.cursillo + "</td></tr>" +
                            "<tr>" + "<td>Nº Curso</td><td>" + element.num_cursillo + "</td></tr>" +
                            "<tr>" + "<td>Inicio</td><td>" + fecha + "  [Sem:" + element.semana + "-" + element.anyo + "]</td></tr>" +
                            "</tbody>" +
                            "</table>";
                    });
                }
                else {
                    html += "<table class='table-viaoptima'><thead>" +
                        "<tr style='Background: #000;'>" +
                        "<th colspan='2' class='text-center'>Sin cursillos a procesar</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "</tbody>" +
                        "</table>";
                }
                $('[data-role="lista_cursillos"]').empty().append(html);
                cursillosInputs.empty();
            },
            error: function () {
            }
        });
    };

    function formatoFecha(date) {
        var fecha = date.toLocaleString().split("/");
        return (fecha[0].length > 1 ? fecha[0] : "0" + fecha[0]) + "/" + (fecha[1].length > 1 ? fecha[1] : "0" + fecha[1]) + "/" + date.getFullYear();
    }

    $(document).on("change", "select[name='nuestrasComunidades']", function (evt) {
        evt.preventDefault();
        totalAnyos($(this).val());
    });
    $(document).on("change", "select[name='modalidad']", function (evt) {
        evt.preventDefault();
        poner_comunicacion($(this).val());
    });
    $(document).on("change", "select[name='anyo']", function (evt) {
        evt.preventDefault();
        totalCursillos(
            $('select[name="nuestrasComunidades"]>option:selected').val(),
            $('select[name="anyo"]>option:selected').val()
        );
    });

    $(document).on("click", ".marcarTodos", function (evt) {
        evt.preventDefault();
        cursillosInputs.empty();
        $("input[type='checkbox'][name='curso']").each(function (idx, elem) {
            $(elem).prop("checked", true);
            quitarPonerUnCursoFormulario(this);
        });
    });

    $(document).on("click", ".desmarcarTodos", function (evt) {
        evt.preventDefault();
        cursillosInputs.empty();
        $("input[type='checkbox'][name='curso']").each(function (idx, elem) {
            $(elem).prop("checked", false)
        });
    });

    $(document).on("change", "input[type='checkbox'][name='curso']", function (evt) {
        evt.preventDefault();
        quitarPonerUnCursoFormulario(this);
    });


    $(document).on("change", "select[name='comunidadesDestinatarias']", function (evt) {
        evt.preventDefault();
        var option = $(this).find("option:selected");
        if (!ponerDestinatario(option))
            return;
        option.hide();
        scrollAlFinal();
    });

    $(document).on("click", "[data-role='destinatario'] .badge", function (evt) {
        evt.preventDefault();
        var $this = $(this).closest("[data-role='destinatario']");
        var value = $this.data("val");
        $("select[name='comunidadesDestinatarias']").find("option[value='" + value + "']").show();
        eliminarDestinatario(value);
        $this.remove();
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='marcarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("select[name='comunidadesDestinatarias']>option").each(function (idx, elem) {
            var elem = $(elem);
            if (elem.attr("value") !== undefined) {
                elem.hide();
                ponerDestinatario(elem);
            }
        });
        scrollAlFinal();
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='eliminarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("select[name='comunidadesDestinatarias']>option").each(function (idx, elem) {
            var elem = $(elem);
            elem.show();
        });
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='ordenar']", function (evt) {
        evt.preventDefault();
        var destinatarios = $("[data-role='comunidades_destinatarias']");
        var elementos = destinatarios.children("div").get();
        elementos.sort(function (a, b) {
            var A = $(a).text().toUpperCase();
            var B = $(b).text().toUpperCase();
            return (A < B) ? -1 : (A > B) ? 1 : 0;
        });
        destinatarios.empty();
        $.each(elementos, function (id, elemento) {
            destinatarios.append(elemento);
        });

    });

    $(document).on("submit", "form[name='formularioNuestrasSolicitudes']", function (evt) {
        evt.preventDefault();
        var $this = $(this);
        var contenedorModalMensaje = $("[data-role='modalMensaje']");
        var datosModalMensaje = contenedorModalMensaje.find("span.simpleModal");
        if (cursillosInputs.find("input").length === 0) {
            contenedorModalMensaje.find(".cuerpoFormularioModal .scroll").html("<span>Debes de tener al menos un cursillo seleccionado.</span>");
            datosModalMensaje.trigger("click");
            return false;
        }
        if (destinatarioInputs.find("input").length === 0) {
            contenedorModalMensaje.find(".cuerpoFormularioModal .scroll").html("<span>Debes de tener al menos una comunidad destinataria.</span>");
            datosModalMensaje.trigger("click");
            return false;
        }
        $this.removeAttr("data-role");
        $("div.spinner").css("display", 'block');
        $this[0].submit();
    });


    //Obtenemos el array de comunidades destinatiarias según su modalidad de comunicación
    poner_comunicacion($('select[name="modalidad"]').val());
    totalAnyos($('select[name="nuestrasComunidades"]').val());
});
