{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunicacion_preferida','esActivo']),['route'=>'tiposComunicacionesPreferidas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('comunicacion_preferida',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
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
