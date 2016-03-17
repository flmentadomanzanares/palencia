<div id="buscar-paises" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="115"
             data-modal_plano_z="2"
             data-etiqueta_ancho="80">
            <span title="Buscar">
                <i class="glyphicon glyphicon-search text-center">
                    <div>Buscar</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['pais']),['route'=>'paises.index','method'=>'GET','role'=>'search']) !!}
                {!! FORM::text('pais',null,['class'=>'form-control','placeholder'=>'Buscar país ...'])!!}
                <br>
                <button type="submit" class="btn btn-primary btn-block"><span
                            class='glyphicon glyphicon-search'></span>
                </button>
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
<div id="operaciones-paises" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="165"
             data-modal_plano_z="1"
             data-modal_ancho="98">
            <span title="Operaciones a realizar" class="text-center">
                <i class="glyphicon glyphicon-briefcase text-center">
                    <div>Acci&oacuten</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="panel-search" style="padding:15px;">
                <a title="inicio" href="{{route('inicio')}}">
                    <i class="glyphicon glyphicon-home">
                        <div>Inicio</div>
                    </i>
                </a>
                <a title="nuevo" href="{{route('paises.create')}}">
                    <i class="glyphicon glyphicon-plus">
                        <div>Nuevo</div>
                    </i>
                </a>
                <a title="Listar" href="{{route('paises.index')}}">
                    <i class="glyphicon glyphicon-list">
                        <div>Listar</div>
                    </i>
                </a>
            </div>
        </div>
    </div>
</div>
