<div class="panel-viaoptima-search">

    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="nuevo" href="{{route('solicitudesRecibidas.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nuevo</div>
        </i>
    </a>
    <a title="Listar" href="{{route('solicitudesRecibidas.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['comunidades']),['route'=>'solicitudesRecibidas.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('comunidades', $comunidades, null,array("class"=>"select-control pull-left"))!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>