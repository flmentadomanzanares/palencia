$(document).ready(function () {
    //Ajax para calcular el número de semanas según el año
    var inicializar = function () {
        //definimos las variables
        var year = $('#select_anyos').val();
        totalSemanas(year);
    };
    var totalSemanas = function (year) {
        $.ajax({
            data: {
                'anyo': year,
                _token: $('input[name="_token"]').val()
            },
            dataType: "json",
            type: 'post',
            url: 'semanasTotales',
            success: function (data) {
                console.log(data);
                $('#select_semanas').empty();
                $.each(data, function (key, element) {
                    $('#select_semanas').append("<option value='" + element.semanas + "'>" + element.semanas + "</option>");
                });
            }
        });
    }
    $('#select_anyos').change(function (evt) {
        evt.preventDefault();
        totalSemanas($('#select_anyos option:selected').val());
    });
    inicializar();
});
