<div class="panel-viaoptima-search">

    <a title="nuevo" href="{{route('cursillos.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nuevo</div>
        </i>
    </a>
    <a title="Listar" href="{{route('cursillos.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['cursillo']),['route'=>'cursillos.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::text('cursillo',null,['class'=>'select-control pull-left','placeholder'=>'Buscar....'])!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>