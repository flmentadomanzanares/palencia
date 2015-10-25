<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('comunidad', 'Nombre Comunidad:') !!} <br/>
    {!! FORM::text('comunidad',$comunidad->comunidad,["class" => "form-control", "title"=>"Nombre de la Comunidad",
    "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label ('secretariado', 'Secretariado:') !!} <br/>
    {!! FORM::select('tipo_secretariado_id',$secretariados, $comunidad->tipo_secretariado_id, ["class" =>
    "form-control"])
    !!} <br/>
    {!! FORM::label('responsable', 'Responsable:') !!} <br/>
    {!! FORM::text('responsable',$comunidad->responsable, ["class" => "form-control", "title"=>"Nombre del
    Responsable", "maxlength"=>"100"]) !!}
    <br/>

    <div class="heading-caption">Localización</div>
    {!! FORM::label ('pais_id', 'Pais:') !!} <br/>
    {!! FORM::select('pais_id',$paises, $comunidad->pais_id,["class" => "form-control",'id'=>'select_pais'])
    !!} <br/>
    {!! FORM::label ('provincia_id', 'Provincia:') !!} <br/>
    {!! FORM::select('provincia_id',$provincias, $comunidad->provincia_id, ["class" =>
    "form-control",'id'=>'select_provincia']) !!} <br/>
    {!! FORM::label ('localidad_id', 'Localidad:') !!} <br/>
    {!! FORM::select('localidad_id',$localidades, $comunidad->localidad_id, ["class" =>
    "form-control",'id'=>'select_localidad']) !!} <br/>
    {!! FORM::label('cp', 'Código Postal:') !!} <br/>
    {!! FORM::text('cp',$comunidad->cp, ["class" => "form-control", "title"=>"Código Postal", "maxlength"=>"5"]) !!}
    <br/>
    {!! FORM::label('direccion', 'Dirección:') !!} <br/>
    {!! FORM::textarea ('direccion',$comunidad->direccion,array('class'=> 'form-control', "title"=>"Dirección",
    "maxlength"=>"100") )!!}
    <br/>
    <div class="heading-caption">Comunicación</div>
    {!! FORM::label('email1', 'Email 1:') !!} <br/>
    {!! FORM::text('email1',$comunidad->email1, ["class" => "form-control", "title"=>"Email", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('email2', 'Email 2:') !!} <br/>
    {!! FORM::text('email2',$comunidad->email2, ["class" => "form-control", "title"=>"Email", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('web', 'WEB:') !!} <br/>
    {!! FORM::text('web',$comunidad->web, ["class" => "form-control", "title"=>"Dirección WEB", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('facebook', 'FaceBook:') !!} <br/>
    {!! FORM::text('facebook',$comunidad->facebook, ["class" => "form-control", "title"=>"FaceBook", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('telefono1', 'Telefono 1:') !!} <br/>
    {!! FORM::text('telefono1',$comunidad->telefono1, ["class" => "form-control", "title"=>"Teléfono", "maxlength"=>"13"]) !!}
    <br/>
    {!! FORM::label('telefono2', 'Telefono 2:') !!} <br/>
    {!! FORM::text('telefono2',$comunidad->telefono2, ["class" => "form-control", "title"=>"Teléfono", "maxlength"=>"13"]) !!}
    <br/>
    {!! FORM::label ('comunicacion_preferida', 'Comunicación Preferida:') !!} <br/>
    {!! FORM::select('tipo_comunicacion_preferida_id',$comunicaciones_preferidas, $comunidad->tipo_comunicacion_preferida_id, ["class" =>
    "form-control"]) !!} <br/>
    <div class="heading-caption">Participativa</div>
    {!! FORM::label ('esColaborador', 'Colabora:') !!} <br/>
    {!! FORM::select('esColaborador',array('1'=>'Si','0'=>'No'), $comunidad->esColaborador ,array('class'=>'form-control')) !!}
    <br>
    <div class="heading-caption">Otros</div>
    {!! FORM::label('observaciones', 'Observaciones:') !!} <br/>
    {!! FORM::textarea ('observaciones',$comunidad->observaciones,array('class'=> 'form-control', "title"=>"Observaciones" ) )!!}
    <br/>
@if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $comunidad->activo,array('class'=>'form-control'))
            !!}
        @endif
    @endif
</div>