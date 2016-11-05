{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunidades','aceptada','esManual','esActivo']),['route'=>'solicitudesEnviadas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('comunidades', $comunidades, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('aceptada', array(''=>'Solicitud Aceptada...','1'=>'Aceptada','0'=>'No Aceptada'),null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esManual', array(''=>'Solicitud creada...','1'=>'Manual','0'=>'Automática'),null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Activas + No Activas','1'=>'Activas','0'=>'No Activas'),
    null,array("class"=>"form-control"))!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
