<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label ('pais_id', 'Pais:') !!} <br/>
    {!! FORM::select('pais_id',$paises, $localidades->pais,["class" => "form-control",'id'=>'select_pais'])
    !!} <br/>
    {!! FORM::label ('provincia_id', 'Provincia:') !!} <br/>
    {!! FORM::select('provincia_id',$provincias, $localidades->provincia_id, ["class" =>
    "form-control",'id'=>'select_provincia']) !!} <br/>
    {!! FORM::label('localidad', 'Nombre Localidad') !!} <br/>
    {!! FORM::text('localidad', null, ["class" => "form-control"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $localidades->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif

</div>