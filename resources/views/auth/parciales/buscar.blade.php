{{-- Formulario de busqueda --}}
{!!FORM::model(Request::only(['esPropia','semanas','anyos','comunidad']),
['route'=>'inicio','method'=>'GET','role'=>'search']) !!}
<div class="form-group">
    {!! FORM::select('esPropia', array(''=>'Tipo Comunidad...','true'=>'Propia','false'=>'No Propia'),
   null,array("class"=>"form-control"))!!}
</div>
<div class="form-group">
    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
</div>
<div class="form-group">
    {!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
</div>
<div class="form-group">
    {!! FORM::text('comunidad',null,['class'=>'form-control','placeholder'=>'Comunidad...'])!!}
</div>
<button type="submit" class="btn btn-primary btn-block"><span
            class='glyphicon glyphicon-search'></span>
</button>
{!! FORM::close() !!}
