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
        $('#datepicker2')[0].focus();
    }).data('datepicker');
    var fechaFinal = $('#datepicker2').datepicker({
        onRender: function (date) {
            return date.valueOf() <= fechaInicio.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (evt) {
        fechaFinal.hide();
    }).data('datepicker');

     $('#profesionalFechaNacimiento').datepicker({
        maxViewMode: 'years',
        viewMode: 'years',
        onRender: function (date) {
            var date1 = new Date(date.valueOf());
            var date2 = new Date(this.date.valueOf() - 18);
            return date1.getFullYear() > date2.getFullYear() ? 'disabled' : '';
        }
    })

   var soloAnyo =$('#soloAnyo').datepicker({
        format:'yyyy',
        viewMode:'years',
        minViewMode:'years',
       onRender: function (date) {
           var date1 = new Date(date.valueOf());
           var date2 = new Date(this.date.valueOf());
           return date1.getFullYear() > date2.getFullYear() ? 'disabled' : '';
       }
    }).on('changeDate', function (evt) {
       soloAnyo.hide();
   }).data('datepicker');


});