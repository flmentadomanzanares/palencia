$(document).ready(function () {

    //Ajax para calcular las semanas con solicitudes recibidas
    var totalSemanasSolicitudesRecibidas = function (year) {
        $.ajax({
            data: {
                'anyo': year,
                '_token': $('input[name="_token"]').val()

            },
            dataType: "json",
            type: 'post',
            url: 'semanasSolicitudesRecibidasCursillos',
            success: function (data) {
                var semanas = $('#select_semanas');
                semanas.empty();
                $.each(data, function (key, element) {
                    var weekSelected = new Date().getWeek() === parseInt(element.semanas) ? "selected" : "";
                    semanas.append("<option value='" + element.semanas + "' " + weekSelected + " >" + element.semanas + "</option>");
                });
                if ($('#listado_cursillos').length === 0)
                    return;
                totalCursillos($('#select_comunidad option:selected').val(), $('#select_anyos option:selected').val(), 0);
            },
            error: function () {
            }
        });
    };
    $(document).on("change", "#select_anyos", function (evt) {
        evt.preventDefault();
        totalSemanasSolicitudesRecibidas($('#select_anyos option:selected').val());
    });

    totalSemanasSolicitudesRecibidas($('#select_anyos').val());

});
