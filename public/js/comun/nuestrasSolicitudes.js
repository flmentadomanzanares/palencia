$(document).ready(function () {

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
                var comunidadesNoPropias = $('#select_resto_comunidades');
                comunidadesNoPropias.empty();
                if (data.placeholder.length > 0) {
                    comunidadesNoPropias.append("<option value='0'>" + data.placeholder + "</option>");
                }
                $.each(data.comunidades, function (key, element) {
                    comunidadesNoPropias.append("<option value='" + element.id + "'>" + element.comunidad + "</option>");
                });
            },
            error: function () {
            }
        });
    };

    var totalAnyos = function (comunidadPropiaId) {
        $.ajax({
            data: {
                'comunidadId': comunidadPropiaId,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'totalAnyos',
            success: function (data) {
                var anyos = $('#select_anyos');
                anyos.empty();
                $.each(data, function (key, element) {
                    anyos.append("<option value='" + element + "'>" + element + "</option>");
                });
                totalCursillos($('#select_comunidad option:selected').val(), $('#select_anyos option:selected').val(), $('#select_boolean option:selected').val());
            },
            error: function () {
            }
        });
    };


    //Ajax para obtener los cursos de la/s comunidad/es anualmente
    var totalCursillos = function (comunidadPropiaId, year, esSolicitudAnterior) {
        $.ajax({
            data: {
                'comunidad': comunidadPropiaId,
                'anyo': year,
                'esSolicitudAnterior': Boolean(parseInt(esSolicitudAnterior)),
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'listadoCursillosSolicitudes',
            success: function (data) {
                var html = "";
                if (data.length > 0) {
                    $.each(data, function (key, element) {
                        var fecha = formatoFecha(new Date(element.fecha_inicio));
                        html += "<table class='table-viaoptima table-striped'><thead>" +
                            "<tr style='Background: " + element.color + ";'>" +
                            "<th colspan='2' class='text-center'>" + element.comunidad + "</th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>" +
                            "<tr>" + "<td class='table-autenticado-columna-1'>Curso</td><td>" + element.cursillo + "</td></tr>" +
                            "<tr>" + "<td>Nº Curso</td><td>" + element.num_cursillo + "</td></tr>" +
                            "<tr>" + "<td>Inicio</td><td>" + fecha + "  [Sem:" + element.semana + "-" + element.anyo + "]</td></tr>" +
                            "<tr>" + "<td>Participante</td><td>" + element.tipo_participante + "</td></tr>" +
                            "</tbody>" +
                            "</table>";

                    });
                }
                else {
                    html += "<table class='table-viaoptima table-striped'><thead>" +
                        "<tr style='Background: #000;'>" +
                        "<th colspan='2' class='text-center'>Sin cursillos a procesar</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "</tbody>" +
                        "</table>";
                }
                $('#listado_cursillos').empty().append(html);
            },
            error: function () {
            }
        });
    };

    function formatoFecha(date) {
        var fecha = date.toLocaleString().split("/");
        return (fecha[0].length > 1 ? fecha[0] : "0" + fecha[0]) + "/" + (fecha[1].length > 1 ? fecha[1] : "0" + fecha[1]) + "/" + date.getFullYear();
    }

    $(document).on("change", "#select_comunidad", function (evt) {
        evt.preventDefault();
        totalAnyos($(this).val());
    });
    $(document).on("change", "#select_comunicacion", function (evt) {
        evt.preventDefault();
        poner_comunicacion($(this).val());
    });
    $(document).on("change", "#select_anyos, #select_boolean", function (evt) {
        evt.preventDefault();
        var generarSusRespuestas = parseInt($('#select_boolean').val());
        totalCursillos($('#select_comunidad option:selected').val(), $('#select_anyos option:selected').val(), $('#select_boolean option:selected').val());
        $('#select_generar_sus_respuestas').prop('disabled', generarSusRespuestas ? false : true);

    });
    $('#select_generar_sus_respuestas').prop('disabled', true);
    poner_comunicacion($('#select_comunicacion').val());
    totalAnyos($('#select_comunidad option:selected').val());
});
