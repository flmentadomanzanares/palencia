{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['tipo_participante','esActivo']),['route'=>'tiposParticipantes.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('tipo_participante',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Todos...','1'=>'Activo','0'=>'No Activo'),
    null,array("class"=>"form-control"))!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
