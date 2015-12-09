<div class="panel-viaoptima-search">

    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="nuevo" href="{{route('solicitudesEnviadas.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nuevo</div>
        </i>
    </a>
    <a title="Listar" href="{{route('solicitudesEnviadas.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['semanas','anyos', 'cursillo']),['route'=>'solicitudesEnviadas.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('anyos', $anyos, null,array("class"=>"select-control pull-left",'id'=>'select_anyos'))!!}
    {!! FORM::select('semanas', $semanas, null,array("class"=>"select-control pull-left",'id'=>'select_semanas'))!!}
    {!! FORM::select('cursillo', $cursillos, null,array("class"=>"select-control pull-left"))!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>