{!!FORM::model(Request::only(['pais','provincia','localidad']),['route'=>'localidades.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('pais',$paises ,null,array('id'=>'select_pais',"class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('provincia',$provincias ,null,array('id'=>'select_provincia',"class"=>"form-control"))!!}
</div>
<button type="submit" class="btn btn-primary btn-block"><span class='glyphicon glyphicon-search'></span></button>
{!! FORM::close() !!}


