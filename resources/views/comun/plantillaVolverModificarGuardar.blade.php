<div id="volver-modificar-guardar" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="100"
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
                @if(isset($index))
                    <a title="Volver" href="{{route($index)}}">
                        <i class="glyphicon glyphicon-arrow-left">
                            <div>Volver</div>
                        </i>
                    </a>
                @endif
                @if(isset($accion) && strlen($accion)>0)
                    <button type="submit" title="{{$accion}}">
                        <i class='glyphicon  @if(isset($icon) && strlen($icon)>0) {{$icon}} @else glyphicon-floppy-disk full-Width @endif'>
                            <div>{!! $accion !!}</div>
                        </i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

