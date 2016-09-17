{!!FORM::model(Request::only(['pais','provincias','localidad','esActivo']),['route'=>'localidades.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('provincias',$provincias ,null,array('id'=>'select_provincia',"class"=>"form-control", "data-placeholder"=>"Provincias...."))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Activas + No Activas','1'=>'Activas','0'=>'No Activas'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::text('localidad',null,['class'=>'form-control','placeholder'=>'Buscar localidad ...'])!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block"><span class='glyphicon glyphicon-search'></span></button>
{!! FORM::close() !!}


