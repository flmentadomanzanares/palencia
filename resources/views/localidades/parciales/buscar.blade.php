{!!FORM::model(Request::only(['pais','provincia','localidad','esActivo']),['route'=>'localidades.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('provincia',$provincias ,null,array('id'=>'select_provincia',"class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Todas...','1'=>'Activa','0'=>'No Activa'),
    null,array("class"=>"form-control"))!!}
</div>
<br/>
<button type="submit" class="btn btn-primary btn-block"><span class='glyphicon glyphicon-search'></span></button>
{!! FORM::close() !!}


