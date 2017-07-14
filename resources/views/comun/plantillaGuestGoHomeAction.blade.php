<div id="salir" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="100"
             data-modal_plano_z="2"
             data-modal_ancho="80">
            <div title="Operaciones a realizar" class="text-center">
                <i class="glyphicon glyphicon-briefcase text-center"></i>
                <div>Acci&oacuten</div>
            </div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="btn-action">
                <a href="{{ url('/auth/logout') }}"
                   data-modal_sin_etiqueta="false"
                   data-modal_ancho="330"
                   data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
                   data-modal_cuerpo_color_texto='"#ffffff'
                   data-modal_posicion_vertical="110"
                >
                    <i class='glyphicon glyphicon-log-out full-Width'>
                        <div>Salir</div>
                    </i>
                </a>
            </div>
        </div>
    </div>
</div>
