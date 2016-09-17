<div id="operaciones" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(85, 200, 75,.9)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
             data-modal_posicion_vertical="150"
             data-modal_plano_z="2"
             data-modal_ancho="80">
            <span title="Operaciones a realizar" class="text-center">
                <i class="glyphicon glyphicon-briefcase text-center">
                    <div>Acci&oacuten</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                <div class="panel-search">
                    @if(isset($accion))
                        <a title="{{$accion}}" href="{{route($tabla.'.create')}}">
                            <i class="glyphicon glyphicon-plus">
                                <div>{{$accion}}</div>
                            </i>
                        </a>
                    @endif
                    <a title="Listar" href="{{route($tabla.'.index')}}">
                        <i class="glyphicon glyphicon-list">
                            <div>Listar</div>
                        </i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>