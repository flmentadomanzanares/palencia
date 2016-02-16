<div class="panel-search">
    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="nuevo" href="{{route('tiposComunicacionesPreferidas.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nuevo</div>
        </i>
    </a>
    <a title="Listar" href="{{route('tiposComunicacionesPreferidas.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['comunicacion_preferida']),['route'=>'tiposComunicacionesPreferidas.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::text('comunicacion_preferida',null,['class'=>'select-control pull-left','placeholder'=>'Buscar....'])!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>