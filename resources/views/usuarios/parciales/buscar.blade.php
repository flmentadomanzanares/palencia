{{-- Formulario de busqueda --}}

{!!FORM::model(Request::only(['campo','value','rol']),['route'=>'usuarios.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('rol',$roles ,null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('campo',config('opciones.campoUser') ,null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::text('value',null,['class'=>'form-control','placeholder'=>'Buscar....'])!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
