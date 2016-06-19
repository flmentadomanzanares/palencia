{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['comunidad','esPropia','secretariado','pais','esActivo']),['route'=>'comunidades.index','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('pais', $paises, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('secretariado', $secretariados, null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esPropia', array(''=>'Tipo Comunidad...','1'=>'Propia','0'=>'No Propia'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('esActivo', array(''=>'Todas...','1'=>'Activa','0'=>'No Activa'),
    null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::text('comunidad',null,['class'=>'form-control','placeholder'=>'Comunidad....'])!!}
</div>
<br/>
<button type="submit" class="btn btn-success btn-block"><span class='glyphicon glyphicon-search'></span></button>
{!! FORM::close() !!}
