$(document).ready(function () {

    //Ajax para calcular las semanas con solicitudes recibidas
    var totalSemanasSolicitudesEnviadas = function (year) {
        $.ajax({
            data: {
                'anyo': year,
                '_token': $('input[name="_token"]').val()

            },
            dataType: "json",
            type: 'post',
            url: '/semanasSolicitudes',
            success: function (data) {
                var semanas = $('#select_semanas');
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
    };
    $(document).on("change", "#select_anyos", function (evt) {
        evt.preventDefault();
        totalSemanasSolicitudesEnviadas($('#select_anyos option:selected').val());
    });

    totalSemanasSolicitudesEnviadas($('#select_anyos').val());

});
