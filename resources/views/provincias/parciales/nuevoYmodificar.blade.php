<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label ('pais', 'Nombre del Pa&iacute;s') !!}
    {!! FORM::select('pais',$paises, $provincia->pais_id ,array("class"=>"form-control")) !!}
    {!! FORM::label('provincia', 'Nombre de la Provincia') !!} <br/>
    {!! FORM::text('provincia', null, ["class" => "form-control text-uppercase", "title"=>"Nombre de la Provincia"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $provincia->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif
</div>