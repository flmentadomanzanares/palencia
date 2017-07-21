$(document).ready(function () {

    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (year) {
        var esComunidadPropia = $("select[name='esPropia']").val();
        $.ajax({
            data: {
                'comunidadesIds': [],
                'anyo': (isNaN(year) ? 0 : year),
                'esComunidadPropia': isNaN(esComunidadPropia) ? '' : esComunidadPropia,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'semanasTotales',
            success: function (data) {
                var semanas = $('select[name="semana"]');
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

    $(document).on("change", "select[name='esPropia']", function (evt) {
        evt.preventDefault();
        totalSemanas(parseInt($("select[name = 'anyo']").val()));
    });

    $(document).on("change", "select[name='anyo']", function (evt) {
        evt.preventDefault();
        totalSemanas(parseInt($("select[name = 'anyo']").val()));
    });

    totalSemanas(parseInt($("select[name = 'anyo']").val()));
});
