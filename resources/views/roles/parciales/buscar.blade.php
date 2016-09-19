{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['rol','esActivo']),['route'=>'roles.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('rol',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Activos + No Activos','1'=>'Activos','0'=>'No Activos'),
    null,array("class"=>"form-control"))!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
