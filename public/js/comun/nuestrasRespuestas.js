$(document).ready(function () {
    var totalAnyos = function (comunidadPropiaId) {
        $.ajax({
            data: {
                'comunidadPropia': comunidadPropiaId,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'totalAnyosRespuestas',
            success: function (data) {
                var anyos = $('#select_anyos');
                anyos.empty();
                $.each(data, function (key, element) {
                    anyos.append("<option value='" + element + "'>" + element + "</option>");
                });
                totalCursillos($('#select_comunidad_no_propia option:selected').val(), $('#select_anyos option:selected').val(), $('#select_boolean option:selected').val());
            },
            error: function () {
            }
        });
    };
    //Ajax para obtener los cursos de la/s comunidad/es anualmente.
    var totalCursillos = function (comunidadNoPropiaId, year, esRespuestaAnterior) {
        $.ajax({
            data: {
                'comunidadNoPropia': comunidadNoPropiaId,
                'anyo': year,
                'esRespuestaAnterior': esRespuestaAnterior,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'listadoCursillosRespuestas',
            success: function (data) {
                $('#listado_cursillos').empty();
                $.each(data, function (key, element) {
                    var fecha = new Date(element.fecha_inicio);
                    var html = "<table class='table-viaoptima table-striped'><thead>" +
                        "<tr style='Background: " + element.color + ";'>" +
                        "<th colspan='2' class='text-center'>" + element.comunidad + "</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "<tr>" + "<td class='table-autenticado-columna-1'>Curso</td><td>" + element.cursillo + "</td></tr>" +
                        "<tr>" + "<td>Nº Curso</td><td>" + element.num_cursillo + "</td></tr>" +
                        "<tr>" + "<td>Inicio</td><td>" + fecha.toLocaleDateString() + "  [Sem:" + element.semana + "-" + element.anyo + "]</td></tr>" +
                        "<tr>" + "<td>Participante</td><td>" + element.tipo_participante + "</td></tr>" +
                        "</tbody>" +
                        "</table>";
                    $('#listado_cursillos').append(html);
                });
            },
            error: function () {
            }
        });
    };

    function formatoFecha(date) {
        var fecha = date.toLocaleString().split("/");
        return (fecha[0].length > 1 ? fecha[0] : "0" + fecha[0]) + "/" + (fecha[1].length > 1 ? fecha[1] : "0" + fecha[1]) + "/" + date.getFullYear();
    }
    $(document).on("change", "#select_comunidad_no_propia", function (evt) {
        evt.preventDefault();
        totalAnyos($(this).val());
    });
    $(document).on("change", "#select_anyos, #select_boolean", function (evt) {
        evt.preventDefault();
        totalCursillos($('#select_comunidad_no_propia option:selected').val(), $('#select_anyos option:selected').val(), $('#select_boolean option:selected').val());
    });
    $("#select_comunidad_no_propia").trigger('change');
});
