<div class="form-group">
    <div class="heading-caption">Comunidad</div>
    {!! FORM::label ('comunidad', 'Comunidad') !!}
    {!! FORM::select('comunidad_id', $comunidades, $cursillo->comunidad_id, array('class'=>'form-control')) !!}
    <br/>
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('cursillo', 'Nombre del Cursillo') !!} <br/>
    {!! FORM::text('cursillo', $cursillo->cursillo, ["class" => "form-control", "title"=>"Nombre del Cursillo"]) !!}
    <br/>
    {!! FORM::label('numCursillo', 'Número del Cursillo') !!} <br/>
    {!! FORM::text('num_cursillo', $cursillo->num_cursillo, ["class" => "form-control", "title"=>"Número de Cursillo"]) !!}
    <br/>
    {!! FORM::label('fecha_inicio', 'Fecha Inicio') !!} <br/>
    {!! FORM::text('fecha_inicio',  date("d/m/Y",strtotime($cursillo->fecha_inicio)), ['id' => 'datepicker1', 'class' => 'form-control calendario', 'readonly'=>''])!!} <br/>
    <br/>
    {!! FORM::label('fecha_final', 'Fecha Final') !!} <br/>
    {!! FORM::text('fecha_final',  date("d/m/Y",strtotime($cursillo->fecha_final)), ['id' => 'datepicker2', 'class' => 'form-control calendario', 'readonly'=>''])!!} <br/>
    <br/>
    {!! FORM::label('descripcion', 'Descripción') !!} <br/>
    {!! FORM::textarea('descripcion',$cursillo->descripcion,array('class'=>'form-control', 'title'=> 'Descripción')) !!}
    <br/>
    <div class="heading-caption">Asistentes</div>
    {!! FORM::label ('tipoAlumnos', 'Asistentes al Curso') !!}
    {!! FORM::select('tipo_participante_id', $tipos_participantes,
    $cursillo->tipo_participante,array('class'=>'form-control')) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('esSolicitud', 'Tiene Solicitud') !!} <br/>
            {!! FORM::select('esSolicitud',array('0'=>'No','1'=>'Si'), $cursillo->esSolicitud,array('class'=>'form-control')) !!}
            {!! FORM::label ('esRespuesta', 'Tiene Respuesta') !!} <br/>
            {!! FORM::select('esRespuesta',array('0'=>'No','1'=>'Si'), $cursillo->esRespuesta,array('class'=>'form-control')) !!}
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $cursillo->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>