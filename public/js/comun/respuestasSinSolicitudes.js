$(document).ready(function () {
    var inputsContainer = $("[data-role='contenedor_imputs']");
    var cursillosInputs = inputsContainer.find("[data-role='cursillos']");
    var destinatarioInputs = inputsContainer.find("[data-role='destinatarios']");

    var scrollAlFinal = function () {
        window.scrollTo(0, document.body.scrollHeight);
    };

    var quitarPonerUnCursoFormulario = function (cursillo) {
        var curso = $(cursillo);
        var id = curso.closest("tr").data("id");
        if (curso.prop("checked")) {
            cursillosInputs.append("<input type='hidden' name='cursos[]' value='" + id + "'>");
        } else {
            cursillosInputs.find("[value='" + id + "']").remove();
        }
    };

    var ponerDestinatario = function (destinatario) {
        if (isNaN(parseInt($(destinatario).val())))
            return false;
        destinatarioInputs.append("<input type='hidden' name='comunidadesDestinatarias[]' value='" + destinatario.val() + "'>");
        destinatario.closest(".table-size-optima")
            .find("[data-role='comunidades_destinatarias']")
            .append("<div data-role='destinatario' data-val='" + destinatario.val() + "' class='alert alert-info'>" + destinatario.text() + "<span class='badge pointer pull-right'>Quitar</span></div>");
        return true;
    };

    var eliminarDestinatario = function (destinatarioId) {
        destinatarioInputs.find("[value='" + destinatarioId + "']").remove();
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
                var anyo = $('select[name="anyo"]');
                var anyoSeleccionado = data[anyo.val()] === undefined ? 0 : anyo.val();
                anyo.empty();
                $.each(data, function (key, element) {
                    anyo.prepend("<option value='" + key + "'>" + element + "</option>");
                });
                anyo.append("<option value='0'>Todos los años</option>");
                anyo.val(anyoSeleccionado);
                totalCursillos(
                    comunidadPropiaId,
                    anyo.val()
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

    $(document).on("change", "select[name='anyo']", function (evt) {
        evt.preventDefault();
        totalCursillos(
            $("select[name='nuestrasComunidades']>option:selected").val(),
            $(this).val()
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
        var val = $this.data("val");
        $("#comunidadesDestinatarias").find("option[value='" + val + "']").show();
        eliminarDestinatario(val);
        $this.remove();
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='marcarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("select[name='comunidadesDestinatarias'] option").each(function (idx, elem) {
            var comunidadDestinataria = $(elem);
            if (comunidadDestinataria.attr("value") !== undefined) {
                comunidadDestinataria.hide();
                ponerDestinatario(comunidadDestinataria);
            }
        });
        scrollAlFinal();
    });

    $(document).on("click", "[data-role='seleccion_destinatarios'] [data-role='eliminarTodos']", function (evt) {
        evt.preventDefault();
        destinatarioInputs.empty();
        $("[data-role='comunidades_destinatarias']").empty();
        $("select[name='comunidadesDestinatarias'] option").each(function (idx, elem) {
            var comunidadDestinataria = $(elem);
            comunidadDestinataria.show();
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

    $(document).on("submit", "form[name='formularioRespuestasSinSolicitudes']", function (evt) {
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
    totalAnyos($("select[name='nuestrasComunidades']").val());
});
