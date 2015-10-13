<div class="panel-viaoptima-search">
    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>
    <a title="nueva" href="{{route('localidades.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nueva</div>
        </i>
    </a>
    <a title="Listar" href="{{route('localidades.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['pais','provincia','localidad']),['route'=>'localidades.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"select-control pull-left"))!!}
    {!! FORM::select('provincia',$provincias ,null,array('id'=>'select_provincia',"class"=>"select-control pull-left"))!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>

