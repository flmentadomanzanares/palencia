<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label ('pais', 'Nombre del País') !!}
    {!! FORM::select('pais',$paises, $provincias->pais_id ,array("class"=>"form-control")) !!}
    {!! FORM::label('provincia', 'Nombre de la Provincia') !!} <br/>
    {!! FORM::text('provincia', null, ["class" => "form-control", "title"=>"Nombre de la Provincia"]) !!}
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activa') !!} <br/>
            {!! FORM::select('activo',array('0'=>'No','1'=>'Si'), $provincias->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif
</div>