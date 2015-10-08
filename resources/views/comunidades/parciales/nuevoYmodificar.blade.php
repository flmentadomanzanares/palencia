<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('comunidad', 'Nombre Comunidad:') !!} <br/>
    {!! FORM::text('comunidad',$comunidades->comunidad,["class" => "form-control", "title"=>"Nombre de la Comunidad",
    "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label ('secretariado', 'Secretariado:') !!} <br/>
    {!! FORM::select('tipo_secretariado_id',$secretariados, $comunidades->tipo_secretariado_id, ["class" =>
    "form-control"])
    !!} <br/>
    {!! FORM::label('responsable', 'Responsable:') !!} <br/>
    {!! FORM::text('responsable',$comunidades->responsable, ["class" => "form-control", "title"=>"Nombre del
    Responsable", "maxlength"=>"100"]) !!}
    <br/>

    <div class="heading-caption">Localización</div>
    {!! FORM::label ('pais_id', 'Pais:') !!} <br/>
    {!! FORM::select('pais_id',$paises, $comunidades->pais_id,["class" => "form-control",'id'=>'select_pais'])
    !!} <br/>
    {!! FORM::label ('provincia_id', 'Provincia:') !!} <br/>
    {!! FORM::select('provincia_id',$provincias, $comunidades->provincia_id, ["class" =>
    "form-control",'id'=>'select_provincia']) !!} <br/>
    {!! FORM::label ('localidad_id', 'Localidad:') !!} <br/>
    {!! FORM::select('localidad_id',$localidades, $comunidades->localidad_id, ["class" =>
    "form-control",'id'=>'select_localidad']) !!} <br/>
    {!! FORM::label('cp', 'Código Postal:') !!} <br/>
    {!! FORM::text('cp',$comunidades->cp, ["class" => "form-control", "title"=>"Código Postal", "maxlength"=>"5"]) !!}
    <br/>
    {!! FORM::label('direccion', 'Dirección:') !!} <br/>
    {!! FORM::textarea ('direccion',$comunidades->direccion,array('class'=> 'form-control', "title"=>"Dirección",
    "maxlength"=>"100") )!!}
    <br/>
    <div class="heading-caption">Comunicación</div>
    {!! FORM::label('email1', 'Email 1:') !!} <br/>
    {!! FORM::text('email1',$comunidades->email1, ["class" => "form-control", "title"=>"Email", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('email2', 'Email 2:') !!} <br/>
    {!! FORM::text('email2',$comunidades->email2, ["class" => "form-control", "title"=>"Email", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('web', 'WEB:') !!} <br/>
    {!! FORM::text('web',$comunidades->web, ["class" => "form-control", "title"=>"Dirección WEB", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('facebook', 'FaceBook:') !!} <br/>
    {!! FORM::text('facebook',$comunidades->facebook, ["class" => "form-control", "title"=>"FaceBook", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('telefono1', 'Telefono 1:') !!} <br/>
    {!! FORM::text('telefono1',$comunidades->telefono1, ["class" => "form-control", "title"=>"Teléfono", "maxlength"=>"13"]) !!}
    <br/>
    {!! FORM::label('telefono2', 'Telefono 2:') !!} <br/>
    {!! FORM::text('telefono2',$comunidades->telefono2, ["class" => "form-control", "title"=>"Teléfono", "maxlength"=>"13"]) !!}
    <br/>
    {!! FORM::label ('comunicacion_preferida', 'Comunicación Preferida:') !!} <br/>
    {!! FORM::select('tipo_comunicacion_preferida_id',$comunicaciones_preferidas, $comunidades->tipo_comunicacion_preferida_id, ["class" =>
    "form-control"]) !!} <br/>
    <div class="heading-caption">Otros</div>
    {!! FORM::label('observaciones', 'Observaciones:') !!} <br/>
    {!! FORM::textarea ('observaciones',$comunidades->observaciones,array('class'=> 'form-control', "title"=>"Observaciones" ) )!!}
    <br/>
@if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $comunidades->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif
</div>