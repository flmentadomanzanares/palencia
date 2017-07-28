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
                var anyoSeleccionado = data[anyos.val()] === undefined ? 0 : anyos.val();
                anyos.empty();
                $.each(data, function (key, element) {
                    anyos.prepend("<option value='" + key + "'>" + element + "</option>");
                });
                anyos.append("<option value='0'>Todos los años</option>");
                anyos.val(anyoSeleccionado);
                totalSemanas(
                    comunidadesIds,
                    anyos.val()
                );
            },
            error: function () {
            }
        });
    };

    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (comunidadesIds, year) {
        var esPropia = $("select[name='esPropia']").val();
        $.ajax({
            data: {
                'comunidadesIds': comunidadesIds,
                'anyo': year,
                'esComunidadPropia': (esPropia === undefined ? null : esPropia),
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

    ponerFechaParaComunidad(parseInt($("select[name='comunidad']").val()));
});
