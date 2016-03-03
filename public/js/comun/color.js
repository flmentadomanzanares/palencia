/**
 * Created by fmentado on 06/05/2015.
 */
$(document).ready(function () {
    $('#select-color-fondo').simplecolorpicker({picker: true, theme: 'glyphicons', backgroundColor: '#eee'});
    $('#select-color-texto').simplecolorpicker({picker: true, theme: 'glyphicons', backgroundColor: '#eee'});
    $('#select-color-fondo,#select-color-texto').on("change", function (evt) {
        evt.preventDefault();
        $("#muestraColoresComunidad").css("background-color", $('#select-color-fondo+span').css("background-color"));
        $("#muestraColoresComunidad").css("color", $('#select-color-texto + span').css("background-color"));
    });
    $('#select-color-fondo').trigger("change");
});