<div class="panel-search">
    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="Listar" href="{{route('usuarios.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['campo','value','rol']),['route'=>'usuarios.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('rol',$roles ,null,array("class"=>"select-control pull-left"))!!}
    {!! FORM::select('campo',config('opciones.campoUser') ,null,array("class"=>"select-control pull-left"))!!}
    {!! FORM::text('value',null,['class'=>'select-control pull-left','placeholder'=>'Buscar....'])!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>