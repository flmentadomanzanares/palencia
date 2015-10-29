$(document).ready(function () {
    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (year,comunidad) {
        $.ajax({
            data: {
                'anyo': year,
                'comunidad':comunidad,
                '_token': $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'semanasTotales',
            success: function (data) {

                $('#select_semanas').empty();
                $('#select_semanas').append("<option value='0'>--</option>");
                $.each(data, function (key, element) {
                    $('#select_semanas').append("<option value='" + element.semanas + "'>" + element.semanas + "</option>");
                });
            },
            error: function () {
            }
        });
    }
    $(document).on("change", "#select_anyos , #select_comunidad", function (evt) {
        evt.preventDefault();
        totalSemanas($('#select_anyos option:selected').val(),$('#select_comunidad option:selected').val());
    });
    totalSemanas($('#select_anyos').val(),$('#select_comunidad').val());
});
