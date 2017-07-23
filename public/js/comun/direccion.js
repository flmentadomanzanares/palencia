+/**
 * Created by fmentado on 18/05/2015.
 */
    $(document).ready(function () {
        var pais = $('select[name="pais"]');
        var listarProvincias = function (paisId, provincia) {
            $.ajax({
                data: {
                    'pais_id': paisId,
                    _token: $('input[name="_token"]').val()
                },
                dataType: "json",
                type: 'post',
                url: '/palencia/public/cambiarProvincias',
                success: function (data) {
                    var provincias = $('select[name="provincias"]');
                    var placeHolderProvincia = provincias.data("placeholder");
                    provincias.empty();
                    //Rellenamos los selects
                    if (placeHolderProvincia !== undefined) {
                        provincias.append("<option selected value='0'>" + placeHolderProvincia + "</option>");
                    }
                    $.each(data, function (key, element) {
                        provincias.append("<option " + (element.id === provincia ? "selected" : '') + " value='" + element.id + "'>" + element.provincia + "</option>");
                    });
                }
            });
        };
        pais.change(function (evt) {
            evt.preventDefault();
            listarProvincias(pais.find("option:selected").val());
        });
        listarProvincias(pais.val());
    });