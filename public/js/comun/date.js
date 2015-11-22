/**
 * Created by abecerra on 07/05/2015.
 */
$(document).ready(function () {
    var fechaActualTemporal = new Date();
    var now = new Date(fechaActualTemporal.getFullYear(),
        fechaActualTemporal.getMonth(),
        fechaActualTemporal.getDate(),
        0, 0, 0, 0);

    var fechaInicio = $('#datepicker1').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (evt) {
        if (evt.date.valueOf() > fechaFinal.date.valueOf()) {
            var newDate = new Date(evt.date)
            newDate.setDate(newDate.getDate() + 1);
            fechaFinal.setValue(newDate);
        }
        fechaInicio.hide();
        }).data('datepicker');

    var fechaFinal = $('#datepicker2').datepicker({
        onRender: function (date) {
            return date.valueOf() <= (fechaInicio.date.valueOf() || now.valueOf()()) ? 'disabled' : '';
        }
    }).on('changeDate', function (evt) {
        fechaFinal.hide();
    }).data('datepicker');
});
