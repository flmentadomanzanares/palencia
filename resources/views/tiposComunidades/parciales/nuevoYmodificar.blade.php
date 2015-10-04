<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('tipoComunidad', 'Tipo Comunidad') !!} <br/>
    {!! FORM::text('comunidad', $tipos_comunidades->comunidad, ["class" => "form-control", "title"=>"Tipo de comunidad"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $tipos_comunidades->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>
