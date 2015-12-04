$(document).ready(function () {
    //Ajax para obtener los cursos de la/s comunidad/es anualmente o por semana.
    var totalCursillos = function (comunidad, year, semana) {
        $.ajax({
            data: {
                'anyo': year,
                'semana': semana,
                'comunidad': comunidad,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: '/listadoCursillos',
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
                        "<tr>" + "<td>Inicio</td><td>" + fecha.toLocaleDateString()+ "  [Sem:"+element.semana + "]</td></tr>" +
                        "<tr>" + "<td>Participante</td><td>" + element.tipo_participante + "</td></tr>" +
                        "</tbody>" +
                        "</table>"
                    $('#listado_cursillos').append(html);
                });
            },
            error: function () {
            }
        });
    };
    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (year, comunidad) {
        $.ajax({
            data: {
                'anyo': year,
                'comunidad': comunidad,
                '_token': $('input[name="_token"]').val()

            },
            dataType: "json",
            type: 'post',
            url: '/semanasTotales',
            success: function (data) {
                var semanas = $('#select_semanas')
                semanas.empty();
                semanas.append("<option value='0'>--</option>");
                $.each(data, function (key, element) {
                    semanas.append("<option value='" + element.semanas + "'>" + element.semanas + "</option>");
                });
                if ($('#listado_cursillos').length == 0)
                    return;
                totalCursillos($('#select_comunidad option:selected').val(), $('#select_anyos option:selected').val(), 0);
            },
            error: function () {
            }
        });
    }
    $(document).on("change", "#select_anyos , #select_comunidad", function (evt) {
        evt.preventDefault();
        totalSemanas($('#select_anyos option:selected').val(), $('#select_comunidad option:selected').val());
    });
    $(document).on("change", "#select_semanas", function (evt) {
        evt.preventDefault();
        if ($('#listado_cursillos').length == 0)
            return;
        totalCursillos($('#select_comunidad option:selected').val(), $('#select_anyos option:selected').val(), $('#select_semanas option:selected').val());
    });
    totalSemanas($('#select_anyos').val(), $('#select_comunidad').val());

});
