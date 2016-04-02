{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunicacion_preferida']),['route'=>'tiposComunicacionesPreferidas.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('comunicacion_preferida',null,['class'=>'select-control pull-left','placeholder'=>'Buscar....'])!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
    {!! FORM::close() !!}
