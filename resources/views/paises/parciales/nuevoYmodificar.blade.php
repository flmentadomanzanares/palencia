<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('pais', 'Nombre del Pa&iacute;s') !!} <br/>
    {!! FORM::text('pais', null, ["class" => "form-control text-uppercase", "title"=>"Nombre del Pa&iacute;s"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $pais->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>
