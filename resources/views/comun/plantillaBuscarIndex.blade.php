<div id="buscar" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="100"
             data-modal_plano_z="3"
             data-etiqueta_ancho="80">
            <div title="Buscar">
                <i class="glyphicon glyphicon-search text-center"></i>
                <div>Buscar</div>
            </div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                @include($htmlTemplate)
            </div>
        </div>
    </div>
</div>
