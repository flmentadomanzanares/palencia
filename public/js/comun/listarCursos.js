/**
 * Created by fmentado on 21/11/2015.
 */
$(document).ready(function () {
    console.log(window.location.pathname);
    var cursillos = function (comunidadId) {
        $.ajax(
                {
                data: {
                    'comunidadId': comunidadId,
                    '_token': $('input[name="_token"]').val()
                },
                dataType: "json",
                type: "post",
                    url: "/cursillosTotales",
                success: function (data) {

                    var cursillos = $("#select-cursillos");
                    cursillos.empty();
                    $.each(data, function (idx, element) {
                        cursillos.append("<option value='" + element.id + "'>" + element.cursillo + "</option>");
                    });
                },
                error: function (err) {
                }
            }
        );
    };
    $(document).on("change", "#select-comunidades", function (evt) {
        evt.preventDefault();
        cursillos($("#select-comunidades").val());
    });
    $("#select-comunidades").trigger("change");
});
