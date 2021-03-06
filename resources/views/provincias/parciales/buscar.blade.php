{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['pais','provincia','esActivo']),['route'=>'provincias.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Activas + No Activas','1'=>'Activas','0'=>'No Activas'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::text('provincia',null,['class'=>'form-control','placeholder'=>'Provincia....'])!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block">
    <span class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}