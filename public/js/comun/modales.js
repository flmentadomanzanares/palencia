$(document).ready(function () {
    $("#buscar-calendario .lanzarModal").simplemodal({
        ventanaPosicionY: 115,
        etiquetaAncho: 80,

    });
    $("#buscar-paises .lanzarModal").simplemodal({
        ventanaPosicionY: 115,
        etiquetaAncho: 80,
        ventanaPlano: 1

    });
    $("#operaciones-paises .lanzarModal").simplemodal({
        ventanaPosicionY: 165,
        ventanaAnchoMaximo: 100,
        etiquetaAncho: 80,
        enLaDerecha: false,
        etiquetaColorFondo: 'yellow',
        etiquetaColorTexto: 'black',
        ventanaCabeceraColorFondo: 'gray',
        ventanaCabeceraColorTexto: 'green',
        ventanaCuerpoColorFondo: 'black',
        ventanaCuerpoColorTexto: 'white',
        ventanaCuerpoColorFondo: 'green',
        ventanaCuerpoColorTexto: 'blue',
    });
    $(".pull-right.lanzarModal").last().simplemodal({
        sinEtiqueta: true,
        ventanaPosicionY: 250,
        ventanaAnchoMaximo: 350,
        etiquetaAncho: 80,
        enLaDerecha: false,
        ventanaCabeceraColorFondo: 'gray',
        ventanaCabeceraColorTexto: 'green',
        ventanaCuerpoColorFondo: 'black',
        ventanaCuerpoColorTexto: 'white',
        ventanaPieColorFondo: 'green',
        ventanaPieColorTexto: 'blue',
    });
    $(".pull-right.lanzarModal").first().simplemodal({
        sinEtiqueta: true,
        ventanaPosicionY: 250,
        ventanaAnchoMaximo: 350,
        etiquetaAncho: 80,
        enLaDerecha: true,
        ventanaCabeceraColorFondo: 'gray',
        ventanaCabeceraColorTexto: 'green',
        ventanaCuerpoColorFondo: 'rgba(0,0,0,.4)',
        ventanaCuerpoColorTexto: 'white',
        ventanaPieColorFondo: 'rgba(0,128,0,.4)',
        ventanaPieColorTexto: 'yellow',
    });
});