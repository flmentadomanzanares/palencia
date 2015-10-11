$(document).ready(function () {
    //Ajax para calcular el número de semanas según el año
    var inicializar = function () {
        //definimos las variables
        var year = $('#select_anyo_sem').val();
        totalSemanas(year);
    };
    var totalSemanas = function (year) {
        var d = new Date(year, 11, 31);
        d.setHours(0, 0, 0);
        d.setDate(d.getDate() + 4 - ((d.getDay()<4)?7:d.getDay() || 7));
        var numeroSemanas= (year==0)?53:Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
        $('#select_semama').empty();
        $('#select_semama').append("<option value='0'>Semana...</option>");
        for (var i = 0; i < numeroSemanas; i += 1) {
            $('#select_semama')
                .append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");
        }
    }
    $('#select_anyo_sem').change(function (evt) {
        evt.preventDefault();
        totalSemanas($('#select_anyo_sem option:selected').val());
    });
    inicializar();
});
