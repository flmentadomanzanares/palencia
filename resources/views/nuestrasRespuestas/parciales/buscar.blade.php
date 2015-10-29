{!!FORM::model(Request::only(['nuestrasComunidades','restoComunidades','cursillo','semanas','anyos']),['route'=>'nuestrasRespuestas.index','method'=>'GET']) !!}
<div class="heading-caption">Remitente</div>
{!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control"))!!}
<br/>
<div class="heading-caption">Destinatario/s</div>
{!! FORM::select('restoComunidades', $restoComunidades, null,array("class"=>"form-control",'id'=>'select_comunidad'))!!}
<br/>
<div class="heading-caption">Cursos</div>
{!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
<br/>
{!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
<br/>
<div class="heading-caption">Listado de Cursos</div>
{!! FORM::textarea('cursillos', null, ['class' => 'form-control','disabled'=>'disabled','id'=>'listado_cursillos']) !!}
<br/>
<button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
{!! FORM::close() !!}


