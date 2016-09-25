$(document).ready(function () {

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
                $("form[name='formularioRespuestasSinSolicitudes'] .contenedor").empty();
                if (data.length > 0) {
                    $.each(data, function (key, element) {
                        var fecha = formatoFecha(new Date(element.fecha_inicio));
                        html += "<table class='table-viaoptima'><thead>" +
                            "<tr class='row-fixed'>" +
                            "<th class='fixed-checkBoxLgContainer'></th>" +
                            "<th class='tabla-ancho-columna-texto'></th>" +
                            "<th></th>" +
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
                        "<th colspan='2' class='text-center'>Sin cursillos</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "</tbody>" +
                        "</table>";
                }
                $('#listado_cursillos').empty().append(html);
                totalAnyos(comunidadPropiaId);
            },
            error: function () {
                totalCursillos($('#select_comunidad_propia option:selected').val(), $('#select_anyos option:selected').val());
            }
        });
    };

    function formatoFecha(date) {
        var fecha = date.toLocaleString().split("/");
        return (fecha[0].length > 1 ? fecha[0] : "0" + fecha[0]) + "/" + (fecha[1].length > 1 ? fecha[1] : "0" + fecha[1]) + "/" + date.getFullYear();
    }

    $(document).on("change", "#select_comunidad", function (evt) {
        evt.preventDefault();
        totalCursillos($(this).val(), $('#select_anyos option:selected').val());
    });

    $(document).on("change", "#select_anyos", function (evt) {
        evt.preventDefault();
        totalCursillos($('#select_comunidad_propia option:selected').val(), $('#select_anyos option:selected').val());
    });

    $(document).on("click", "input[type='checkbox'][name='curso']", function (evt) {
        var target = $(this);
        var id = target.closest("tr").data("id");
        if (target.prop("checked")) {
            $("form[name='formularioRespuestasSinSolicitudes'] .contenedor").append("<input type='hidden' name='cursos[]' data-id='" + id + "' value='" + id + "'>");
        } else {
            $("form[name='formularioRespuestasSinSolicitudes'] .contenedor").find("[data-id='" + id + "']").remove();
        }
    });

    totalCursillos($('#select_comunidad_propia option:selected').val(), $('#select_anyos option:selected').val());
});
