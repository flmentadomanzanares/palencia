$(document).ready(function () {
    //Ajax para calcular el número de semanas según el año
    var totalSemanas = function (year) {
        $.ajax({
            data: {
                'anyo': year,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            type: 'post',
            url: 'semanasTotales',
            success: function (data) {

                $('#select_semanas').empty();
                $.each(data, function (key, element) {
                    $('#select_semanas').append("<option value='" + element.semanas + "'>" + element.semanas + "</option>");
                });
            },
            error: function () {
            }
        });
    }
    $(document).on("change", "#select_anyos", function (evt) {
        evt.preventDefault();
        totalSemanas($('#select_anyos option:selected').val());
    });
    totalSemanas($('#select_anyos').val());
});
