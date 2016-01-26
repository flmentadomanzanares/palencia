+/**
 * Created by fmentado on 18/05/2015.
 */
    $(document).ready(function () {
        //Cambio provincias.
        var inicializar = function(){
            //definimos las variables
            var pais = $('#select_pais').val();
            var provincia = $('#select_provincia').val();
            var localidad = $('#select_localidad').val();
            //Rellenamos los selects
            listarProvincias(pais,provincia);
            listarLocalidades(provincia, localidad);
        };
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
                    $('#select_provincia').empty();
                    $.each(data, function (key, element) {
                        if (element.id == provincia)
                            $('#select_provincia').append("<option selected value='" + element.id + "'>" + element.provincia + "</option>");
                        else
                            $('#select_provincia').append("<option value='" + element.id + "'>" + element.provincia + "</option>");
                    });
                   if (provincia == undefined) {
                        listarLocalidades($('#select_provincia option:selected').val());
                    }

                }
            });
        };
        var listarLocalidades = function (provincia, localidad) {
            $.ajax({
                data: {
                    'provincia_id': provincia,
                    _token: $('input[name="_token"]').val()
                },
                dataType: "json",
                type: 'post',
                url: '/palencia/public/cambiarLocalidades',
                success: function (data) {
                    $('#select_localidad').empty();
                    $.each(data, function (key, element) {
                        if (element.id == localidad)
                            $('#select_localidad').append("<option selected value='" + element.id + "'>" + element.localidad + "</option>");
                        else
                            $('#select_localidad').append("<option value='" + element.id + "'>" + element.localidad + "</option>");
                    });
                }
            });
        };
        $('#select_pais').change(function (evt) {
            evt.preventDefault();
            if ( ($('#select_provincia').length == 0 ))
                return;
            listarProvincias($('#select_pais option:selected').val());
        });
        //Cambio Localidades.
        $('#select_provincia').change(function (evt) {
            evt.preventDefault();
            if ( ($('#select_localidad').length == 0 ))
                return;
            listarLocalidades($('#select_provincia option:selected').val());
        });
        inicializar();
    });