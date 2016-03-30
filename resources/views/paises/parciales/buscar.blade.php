{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['pais']),['route'=>'paises.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::text('pais',null,['class'=>'form-control','placeholder'=>'Buscar país ...'])!!}
</div>
<br>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
