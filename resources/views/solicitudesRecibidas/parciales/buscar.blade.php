{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunidades','respondida','esActivo','esActual']),['route'=>'solicitudesRecibidas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('comunidades', $comunidades, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('respondida', array(''=>'Solicitud...','1'=>'Respondida','0'=>'No Respondida'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Estado...','1'=>'Activas','0'=>'No Activas'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActual', array('1'=>'Sólo año actual','0'=>'Todos los años'),
    null,array("class"=>"form-control"))!!}
</div>

<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
