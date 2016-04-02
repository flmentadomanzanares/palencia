{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['tipo_secretariado']),['route'=>'tiposSecretariados.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('tipo_secretariado',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
</div>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
