<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('pais', 'Nombre del Pais') !!} <br/>
    {!! FORM::text('pais', null, ["class" => "form-control", "title"=>"Nombre del Pais"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('0'=>'No','1'=>'Si'), $paises->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>
