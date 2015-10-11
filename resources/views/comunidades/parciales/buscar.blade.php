<div class="panel-viaoptima-search">

    <a title="nuevo" href="{{route('comunidades.create')}}" class="pull-left">
        <i class="glyphicon glyphicon-plus">
            <div>Nueva</div>
        </i>
    </a>
    <a title="Listar" href="{{route('comunidades.index')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['comunidad','secretariado','pais']),['route'=>'comunidades.index','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('pais', $paises, null,array("class"=>"select-control pull-left"))!!}
    {!! FORM::select('secretariado', $secretariados, null,array("class"=>"select-control pull-left"))!!}
    {!! FORM::text('comunidad',null,['class'=>'select-control pull-left','placeholder'=>'Comunidad....'])!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>