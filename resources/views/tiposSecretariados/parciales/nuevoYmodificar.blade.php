<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('tipoSecretariado', 'Tipo Secretariado') !!} <br/>
    {!! FORM::text('tipo_secretariado', $tipos_secretariados->secretariado, ["class" => "form-control", "title"=>"Tipo de secretariado"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $tipos_secretariados->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>
