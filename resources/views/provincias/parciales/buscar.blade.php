<div class="panel-search">
    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="nueva" href="{{route('provincias.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nueva</div>
        </i>
    </a>
    <a title="Listar" href="{{route('provincias.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['pais','provincia']),['route'=>'provincias.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"form-control select-control pull-left"))!!}
    {!! FORM::text('provincia',null,['class'=>'form-control','placeholder'=>'Provincia....'])!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>