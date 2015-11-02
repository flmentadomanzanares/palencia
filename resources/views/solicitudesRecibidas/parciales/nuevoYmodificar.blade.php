<div class="form-group">
    <div class="heading-caption">Comunidad</div>
    {!! FORM::label ('comunidad', 'Comunidad') !!}
    {!! FORM::select('comunidad_id', $comunidades, $solicitudRecibida->comunidad_id, array('class'=>'form-control')) !!}
    <br/>
    <div class="heading-caption">Cursillo</div>
    {!! FORM::label ('cursillo', 'Cursillo') !!}
    {!! FORM::select('cursillo_id', $cursillos, $solicitudRecibida->cursillo_id, array('class'=>'form-control')) !!}
    <br/>

    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $solicitudRecibida->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>