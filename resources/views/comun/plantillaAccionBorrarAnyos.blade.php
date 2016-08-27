<div id="borrar" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="115"
             data-modal_plano_z="2"
             data-modal_ancho="80">
            <span title="Operaciones a realizar" class="text-center">
                <i class="glyphicon glyphicon-briefcase text-center">
                    <div>Acci&oacuten</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="btn-action">
                <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                        class="simpleModal"
                        data-modal_centro_pantalla="true"
                        data-modal_en_la_derecha="false"
                        data-selector-id="modal-borrar"
                        data-modal_sin_etiqueta="true"
                        data-modal_ancho="330"
                        data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                        data-modal_cabecera_color_texto='#ffffff'
                        data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
                        data-modal_cuerpo_color_texto='"#ffffff'
                        data-modal_pie_color_fondo='#400090'
                        data-modal_pie_color_texto='"#ffffff'
                        data-modal_posicion_vertical="220"
                        data-titulo="BORRAR"
                        data-pie="true"
                        data-descripcion="¿Seguro que deseas eliminar los cursos y sus solicitudes?
                                <h3><strong class='green'></strong></h3>"
                        @endif >
                    <i class='glyphicon glyphicon-trash full-Width'>
                        <div>Borrar</div>
                    </i>
                </button>
            </div>
        </div>
    </div>
</div>
