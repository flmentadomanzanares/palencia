<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('rol', 'Nombre del Rol') !!} <br/>
    {!! FORM::text('rol', $rol->rol, ["class" => "form-control", "title"=>"Nombre del Rol"]) !!}
    <br/>
    {!! FORM::label('peso', 'Peso') !!} <br/>
    {!! FORM::text('peso', $rol->peso, ["class" => "form-control", "title"=>"Peso"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $rol->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>