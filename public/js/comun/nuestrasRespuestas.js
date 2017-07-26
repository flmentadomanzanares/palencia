$(document).ready(function () {

    var inputsContainer = $("[data-role='contenedor_imputs']");
    var cursillosInputs = inputsContainer.find("[data-role='cursillos']");
    var destinatarioInputs = inputsContainer.find("[data-role='destinatarios']");

    var scrollAlFinal = function () {
        window.scrollTo(0, document.body.scrollHeight);
    };

    var quitarPonerUnCursoFormulario = function (item) {
        var elem = $(item);
        var fila = elem.closest("tr");
        var cursilloId = fila.data("cursillo_id");
        var comunidadId = fila.data("comunidad_id");
        if (elem.prop("checked")) {
            cursillosInputs.append("<input type='hidden' data-comunidad='" + comunidadId + "' name='cursos[]' value='" + cursilloId + "'>");
        } else {
            cursillosInputs.find("[value='" + cursilloId + "']").remove();
        }
    };

    var ponerDestinatario = function (elem) {
        if (isNaN(parseInt($(elem).val())))
            return false;
        destinatarioInputs.append("<input type='hidden' name='comunidadesDestinatarias' value='" + elem.val() + "'>");
        elem.closest(".table-size-optima")
            .find("[data-role='comunidades_destinatarias']")
            .append("<div data-role='destinatario' data-val='" + elem.val() + "' class='alert alert-info'>" + elem.text() + "<span class='badge pointer pull-right'>Quitar</span></div>");
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
            url: 'cambiarComunidadesNoPropiasRespuestas',
            success: function (data) {
                destinatarioInputs.empty();
                $("[data-role='seleccion_destinatarios'] div.panel-heading").text("Medio de comunicación :" + $("#select_comunicacion option:selected").text());
                var comunidadesNoPropias = $('#select_resto_comunidades');
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

    var totalAnyos = function (comunidadesIds, esRespuestaAnterior, year) {
        $.ajax({
            data: {
                'comunidadesIds': comunidadesIds,
                'esRespuestaAnterior': esRespuestaAnterior,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'totalAnyosRespuestas',
            success: function (data) {
                var selectorAnyos = $('select[name="anyo"]');
                selectorAnyos.empty();
                $.each(data, function (key, element) {
                    selectorAnyos.prepend("<option value='" + key + "'>" + element + "</option>");
                });
                selectorAnyos.append("<option value='0'>Todos los años</option>");
                selectorAnyos.val(year === undefined ? 0 : year);
            },
            error: function () {
            }
        });
    };

    //Ajax para obtener los cursos de la/s comunidad/es anualmente.
    var totalCursillos = function (year, esRespuestaAnterior, tipoComunicacion) {

        var comunidadesDestinatarias = $("[data-role='destinatarios'] input");
        if (comunidadesDestinatarias.length === 0)
            return;
        var restoComunidades = [];
        comunidadesDestinatarias.each(function (idx, elem) {
            restoComunidades.push($(elem).val());
        });
        var anyos = Array();
        $.ajax({
            data: {
                'comunidadesDestinatarias': restoComunidades,
                'anyo': year,
                'esRespuestaAnterior': esRespuestaAnterior,
                'tipoComunicacion': tipoComunicacion,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'listadoCursillosRespuestas',
            success: function (data) {
                cursillosInputs.empty();
                var html = "";
                var anyoActual = (new Date).getFullYear();
                if (data.length > 0) {
                    $.each(data, function (key, element) {
                        var fecha = new Date(element.fecha_inicio);
                        html += "<table class='table-viaoptima'><thead>" +
                            "<tr class='row-fixed'>" +
                            "<th class='fixed-checkBoxLgContainer'></th>" +
                            "<th class='tabla-ancho-columna-texto'></th>" +
                            "<th class='" + (element.anyo !== anyoActual ? 'asterisco' : '') + " text-right' title='No pertenece al año actual'></th>" +
                            "</tr>" +
                            "<tr style='Background: " + element.colorFondo + ";'>" +
                            "<th colspan='3' style='Color: " + element.colorTexto + ";' " +
                            "class='text-center'>" + element.comunidad + "</th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>" +
                            "<tr data-cursillo_id='" + element.cursilloId + "' data-comunidad_id='" + element.comunidadId + "'>" + "<td rowspan='5'><input class='lg' type='checkbox' checked name='curso'></td><td>Curso</td><td>" + element.cursillo + "</td></tr>" +
                            "<tr>" + "<td>Nº Curso</td><td>" + element.num_cursillo + "</td></tr>" +
                            "<tr>" + "<td>Inicio</td><td>" + fecha.toLocaleDateString() + "  [Sem:" + element.semana + "-" + element.anyo + "]</td></tr>" +
                            "<tr>" + "<td>Participante</td><td>" + element.tipo_participante + "</td></tr>" +
                            "<tr>" + "<td>Email Env&iacute;o</td><td>" + element.email_envio + "</td></tr>" +
                            "</tbody>" +
                            "</table>";
                        //Añado el curso al contenedor de cursos
                        cursillosInputs.append("<input type='hidden' data-comunidad='" + element.comunidadId + "'name='cursos[]' value='" + element.cursilloId + "'>");
                        //Añadimos el año para el select del año
                        if ($.inArray(element.anyo, anyos) === -1) anyos.push(element.anyo);
                    });
                } else {
                    html += "<table class='table-viaoptima table-striped'><thead>" +
                        "<tr style='Background: #000;'>" +
                        "<th colspan='2' class='text-center'>Sin cursillos a procesar</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "</tbody>" +
                        "</table>";
                }
                $('[data-role="lista_cursillos"]').empty().append(html);
                totalAnyos(restoComunidades, esRespuestaAnterior, year);
            },
            error: function () {

            }
        });
    };

    function formatoFecha(date) {
        var fecha = date.toLocaleString().split("/");
        return (fecha[0].length > 1 ? fecha[0] : "0" + fecha[0]) + "/" + (fecha[1].length > 1 ? fecha[1] : "0" + fecha[1]) + "/" + date.getFullYear();
    }

    $(document).on("change", "select[name='modalidad']", function (evt) {
        evt.preventDefault();
        poner_comunicacion($(this).val());
        $("[data-role='lista_cursillos']").empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $('select[name="anyo"]').empty();
    });

    $(document).on("change", "select[name='modalidad'], select[name='incluirRespuestasAnteriores']", function (evt) {
        evt.preventDefault();
        totalCursillos(
            $('select[name="anyo"]>option:selected').val(),
            $('select[name="incluirRespuestasAnteriores"]>option:selected').val(),
            $('select[name="modalidad"]>option:selected').val()
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
        totalCursillos(
            $('select[name="anyo"]>option:selected').val(),
            $('select[name="incluirRespuestasAnteriores"]>option:selected').val(),
            $('select[name="modalidad"]>option:selected').val()
        );
    });

    $(document).on("click", "[data-role='destinatario'] .badge", function (evt) {
        evt.preventDefault();
        var $this = $(this).closest("[data-role='destinatario']");
        var val = $this.data("val");
        $("select[name='comunidadesDestinatarias']").find("option[value='" + val + "']").show();
        eliminarDestinatario(val);
        $this.remove();
        cursillosInputs.find("[data-comunidad='" + val + "']").remove();
        $("[data-role='lista_cursillos']").find("tr[data-comunidad_id='" + val + "']").closest("table").remove();
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='marcarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("select[name='comunidadesDestinatarias']>option").each(function (idx, item) {
            var elem = $(item);
            if (elem.attr("value") !== undefined) {
                elem.hide();
                ponerDestinatario(elem);
            }
        });
        scrollAlFinal();
        totalCursillos(
            $('select[name="anyo"]>option:selected').val(),
            $('select[name="incluirRespuestasAnteriores"]>option:selected').val(),
            $('select[name="modalidad"]>option:selected').val()
        );
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='eliminarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        cursillosInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("[data-role='lista_cursillos']").empty();
        $('select[name="anyo"]').empty();
        $("select[name='comunidadesDestinatarias']>option").each(function (idx, item) {
            var elem = $(item);
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

    $(document).on("submit", "form[name='formularioNuestrasRespuestas']", function (evt) {
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
    poner_comunicacion($('select[name="modalidad"]').val());
});
