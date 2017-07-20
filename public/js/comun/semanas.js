$(document).ready(function () {

    var totalAnyos = function (comunidadesIds) {
        $.ajax({
            data: {
                'comunidadesIds': comunidadesIds,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'totalAnyos',
            success: function (data) {
                var anyos = $('select[name="anyos"]');
                var anyoActual = parseInt(anyos.val());
                anyoActual = isNaN(anyoActual) ? 0 : anyoActual;
                anyos.empty();
                $.each(data, function (key, element) {
                    anyos.append("<option value='" + element + "'>" + element + "</option>");
                });
                anyos.append("<option value='0'>Todos los años</option>");
                anyos.val(anyoActual);
                totalSemanas(
                    comunidadesIds,
                    $('select[name="anyos"]>option:selected').val()
                );
            },
            error: function () {
            }
        });
    };
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
            url: 'listadoCursillos',
            success: function (data) {
                $('#listado_cursillos').empty();
                $.each(data, function (key, element) {
                    var fecha = new Date(element.fecha_inicio);
                    var html = "<table class='table-viaoptima table-striped'><thead>" +
                        "<tr class='row-fixed'>" +
                        "<th class='tabla-ancho-columna-texto'></th>" +
                        "<th></th>" +
                        "</tr>" +
                        "<tr style='Background: " + element.color + ";'>" +
                        "<th colspan='2' class='text-center'>" + element.comunidad + "</th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "<tr>" + "<td>Curso</td><td>" + element.cursillo + "</td></tr>" +
                        "<tr>" + "<td>Nº Curso</td><td>" + element.num_cursillo + "</td></tr>" +
                        "<tr>" + "<td>Inicio</td><td>" + fecha.toLocaleDateString() + "  [Sem:" + element.semana + "]</td></tr>" +
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
    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (comunidadesIds, year) {
        $.ajax({
            data: {
                'comunidadesIds': comunidadesIds,
                'anyo': year,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'semanasTotales',
            success: function (data) {
                var semanas = $('select[name="semanas"]');
                semanas.empty();
                semanas.append("<option value='0'>Semanas...</option>");
                $.each(data, function (key, element) {
                    semanas.append("<option value='" + element.semanas + "'>" + element.semanas + "</option>");
                });

                if ($('#listado_cursillos').length === 0)
                    return;

                totalCursillos(
                    $('select[name="comunidad"]>option:selected').val(),
                    $('select[name="anyos"]>option:selected').val(), 0);
            },
            error: function () {
            }
        });
    };
    var ponerFechaParaComunidad = function (comunidadId) {
        var comunidadesIds = [];
        switch (comunidadId) {
            case 0:
                $("select[name='comunidad']>option").each(function (idx, elem) {
                    comunidadesIds.push(parseInt($(elem).val()));
                });
                break;
            default :
                comunidadesIds.push(comunidadId);
        }
        totalAnyos(comunidadesIds);
    };

    $(document).on("change", "select[name='comunidad']", function (evt) {
        evt.preventDefault();
        ponerFechaParaComunidad(parseInt($(this).val()));
    });

    $(document).on("change", "select[name='anyos']", function (evt) {
        evt.preventDefault();
        ponerFechaParaComunidad(parseInt($("select[name = 'comunidad']").val()));
    });

    $(document).on("change", "#select_semanas", function (evt) {
        evt.preventDefault();
        if ($('#listado_cursillos').length === 0)
            return;
        totalCursillos(
            $('select[name="comunidad"]>option:selected').val(),
            $('select[name="anyos"]>option:selected').val(),
            $('select[name="semanas"]>option:selected').val());
    });

    ponerFechaParaComunidad(parseInt($("select[name='comunidad']").val()));
});
