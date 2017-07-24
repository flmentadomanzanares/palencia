+/**
 * Created by fmentado on 18/05/2015.
 */
    $(document).ready(function () {
        var pais = $('select[name="pais"]');
        var provincias = $('select[name="provincias"]');
        var localidades = $('select[name="localidades"]');
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
                    var placeHolderProvincia = provincias.data("placeholder");
                    provincias.empty();
                    //Rellenamos los selects
                    if (placeHolderProvincia !== undefined) {
                        provincias.append("<option selected value='0'>" + placeHolderProvincia + "</option>");
                    }
                    $.each(data, function (key, element) {
                        provincias.append("<option " + (parseInt(element.id) === parseInt(provincia) ? "selected" : '') + " value='" + element.id + "'>" + element.provincia + "</option>");
                    });
                    listarLocalidades(provincias.val(), localidades.val());
                }
            });
        };
        var listarLocalidades = function (provincia, localidad) {
            $.ajax({
                data: {
                    provincia: provincia,
                    _token: $('input[name="_token"]').val()
                },
                dataType: "json",
                type: "post",
                url: '/palencia/public/cambiarLocalidades',
                success: function (data) {
                    var placeHolderLocalidad = provincias.data("placeholder");
                    localidades.empty();
                    $.each(data, function (key, element) {
                        localidades.append("<option " + (parseInt(element.id) === parseInt(localidad) ? "selected" : '') + " value='" + element.id + "'>" + element.localidad + "</option>");
                    });
                }
            });
        };



        pais.change(function (evt) {
            evt.preventDefault();
            listarProvincias(pais.find("option:selected").val());
        });

        provincias.change(function (evt) {
            if (localidades === undefined)
                return false;
            listarLocalidades(provincias.val());
        });

        listarProvincias(pais.val(), provincias.val());
    });