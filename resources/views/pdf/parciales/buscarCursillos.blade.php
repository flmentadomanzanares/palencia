<div class="panel-viaoptima-search">

    <a title="inicio" href="{{route('inicio')}}" class="pull-left">
        <i class="glyphicon glyphicon-home">
            <div>Inicio</div>
        </i>
    </a>

    <a title="Listar" href="{{route('getCursillos')}}" class="pull-left">
        <i class="glyphicon glyphicon-list">
            <div>Listar</div>
        </i>
    </a>

    <a title="Imprimir" href="{{route('imprimirCursillos')}}" class="pull-left">
        <i class="glyphicon glyphicon-print">
            <div>Imprimir</div>
        </i>
    </a>
</div>
<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['semanas','anyos']),['route'=>'getCursillos','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('anyos', $anyos, null,array("class"=>"select-control pull-left",'id'=>'select_anyos'))!!}
    {!! FORM::select('semanas', $semanas, null,array("class"=>"select-control pull-left",'id'=>'select_semanas'))!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>