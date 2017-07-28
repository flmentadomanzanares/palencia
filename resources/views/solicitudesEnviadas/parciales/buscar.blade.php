{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunidades','aceptada','esManual','esActivo','esActual']),['route'=>'solicitudesEnviadas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('comunidades', $comunidades, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('aceptada', array(''=>'Solicitudes...','1'=>'Aceptadas','0'=>'No Aceptadas'),null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esManual', array(''=>'Procesado...','0'=>'Automático','1'=>'Manual'),null,array("class"=>"form-control"))!!}
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
