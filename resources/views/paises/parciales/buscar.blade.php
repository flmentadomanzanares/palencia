<div id="buscar-paises" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="fixed-right lanzarModal" data-title="BUSCAR">
            <span title="Buscar">
                <i class="glyphicon glyphicon-search text-center">
                    <div>Buscar</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['pais']),['route'=>'paises.index','method'=>'GET','class'=>'','role'=>'search']) !!}
                {!! FORM::text('pais',null,['class'=>'form-control','placeholder'=>'Buscar país ...'])!!}
                <br/>
                <button type="submit" class="btn btn-primary btn-block"><span
                            class='glyphicon glyphicon-search'></span>
                </button>
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
<div id="opciones-paises" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal" data-title="OPCIONES">
            <span title="Operaciones a realizar" class="text-center">
                <i class="glyphicon glyphicon-briefcase text-center">
                    <div>Operaciones</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal withBorder">

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
