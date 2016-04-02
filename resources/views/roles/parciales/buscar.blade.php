{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['rol']),['route'=>'roles.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('rol',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
</div>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
