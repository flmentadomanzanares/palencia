<div class="form-group">
    <div class="heading-caption">Comunidad</div>
    {!! FORM::label ('comunidad', 'Comunidad') !!}
    {!! FORM::select('comunidad',$comunidades, null ,array("class"=>"form-control")) !!}
    <br/>
    {!! FORM::label ('aceptada', 'Respondida') !!} <br/>
    {!! FORM::select('aceptada',array('1'=>'Si','0'=>'No'), $solicitudRecibida->aceptada,array('class'=>'form-control')) !!}
    <br/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $solicitudRecibida->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>