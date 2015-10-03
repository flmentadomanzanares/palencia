<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('cursillo', 'Nombre del Cursillo') !!} <br/>
    {!! FORM::text('cursillo', null, ["class" => "form-control", "title"=>"Nombre del Cursillo"]) !!}
    <br/>
    {!! FORM::label('fecha_inicio', 'Fecha Inicio') !!} <br/>
    {!! FORM::text('fecha_inicio',  date("d/m/Y",strtotime($cursillos->fecha_inicio)), ['id' => 'datepicker1', 'class' => 'form-control', 'readonly'=>''])!!} <br/>
    <br/>
    {!! FORM::label('fecha_final', 'Fecha Final') !!} <br/>
    {!! FORM::text('fecha_final',  date("d/m/Y",strtotime($cursillos->fecha_final)), ['id' => 'datepicker2', 'class' => 'form-control', 'readonly'=>''])!!} <br/>
    <br/>
    {!! FORM::label('descripcion', 'Descripción') !!} <br/>
    {!! FORM::textarea('descripcion',$cursillos->descripcion,array('class'=>'form-control', 'title'=> 'Descripción')) !!}
    <br/>
    {!! FORM::label ('comunidad', 'Comunidad') !!}
    {!! FORM::select('comunidad_id', $comunidades, $cursillos->comunidad_id, array('class'=>'form-control')) !!}
    <br/>
    {!! FORM::label ('tipoAlumnos', 'Tipo de Alumnos') !!}
    {!! FORM::select('tipoAlumnos', $filtroEnumTipoAlumnos,
    $cursillos->tipoAlumnos,array('class'=>'form-control')) !!}
    <br/>
    {!! FORM::label ('tipoCursillo', 'Tipo de Cursillo') !!}
    {!! FORM::select('tipoCursillo', $filtroEnumTipoCursillo,
    $cursillos->tipoCursillo,array('class'=>'form-control')) !!}
    <br/>

    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('0'=>'No','1'=>'Si'), $cursillos->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>