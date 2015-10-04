<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('comunidad', 'Nombre Comunidad') !!} <br/>
    {!! FORM::text('comunidad',$comunidad->comunidad, ["class" => "form-control", "title"=>"Nombre del Cursillo"], maxlength="50") !!}
    <br/>



    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activa',array('1'=>'Si','0'=>'No'), $comunidad->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>