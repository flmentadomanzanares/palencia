{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunidades','esActivo']),['route'=>'solicitudesEnviadas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('comunidades', $comunidades, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('aceptada', array(''=>'Solicitud Aceptada...','1'=>'Aceptada','0'=>'No Aceptada'),null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Todas...','1'=>'Activa','0'=>'No Activa'),
    null,array("class"=>"form-control"))!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
