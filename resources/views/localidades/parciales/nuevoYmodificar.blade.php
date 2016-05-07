<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('pais', 'Nombre País') !!} <br/>
    {!! FORM::select('pais', $paises, null,["class" => "form-control",'id'=>'select_pais']) !!}
    {!! FORM::label('provincia', 'Nombre Provincia') !!} <br/>
    {!! FORM::select('provincia',$provincias, $localidad->provincia_id, ["class" => "form-control",'id'=>'select_provincia']) !!}
    {!! FORM::label('localidad', 'Nombre Localidad') !!} <br/>
    {!! FORM::text('localidad', null, ["class" => "form-control"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $localidad->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif
</div>