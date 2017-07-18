<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('comunidad', 'Nombre Comunidad:') !!} <br/>
    {!! FORM::text('comunidad',$comunidad->comunidad,["class" => "form-control text-uppercase", "title"=>"Nombre de la Comunidad",
    "maxlength"=>"50"]) !!}
    @if($numeroComunidadesPropias < config('opciones.numeroComunidadesPropias')  && $comunidad->id == 0 || $comunidad->esPropia == true && $numeroComunidadesPropias > 1)
        <br/>
        {!! FORM::label ('esPropia', 'Es Propia:') !!} <br/>
        {!! FORM::select('esPropia',array('0'=>'No','1'=>'Si'), $comunidad->esPropia ,array('class'=>'form-control')) !!}
    @endif
    <br>
    {!! FORM::label ('secretariado', 'Secretariado:') !!} <br/>
    {!! FORM::select('tipo_secretariado_id',$secretariados, $comunidad->tipo_secretariado_id, ["class" =>
    "form-control"])
    !!} <br/>
    {!! FORM::label('responsable', 'Responsable:') !!} <br/>
    {!! FORM::text('responsable',$comunidad->responsable, ["class" => "form-control", "title"=>"Nombre del
    Responsable", "maxlength"=>"100"]) !!}
    <br/>

    <div class="heading-caption">Localizaci&oacute;n</div>
    {!! FORM::label ('pais_id', 'Pa&iacute;s:') !!} <br/>
    {!! FORM::select('pais_id',$paises, $comunidad->pais_id,["class" => "form-control",'id'=>'select_pais'])
    !!} <br/>
    {!! FORM::label ('select_provincia', 'Provincia:') !!} <br/>

    {!! FORM::select('select_provincia',$provincias, $comunidad->provincia_id, ["class" =>
    "form-control",'id'=>'select_provincia']) !!} <br/>

    {!! FORM::label ('localidad_id', 'Localidad:') !!} <br/>
    {!! FORM::select('select_localidad',$localidades, $comunidad->localidad_id, ["class" =>
    "form-control",'id'=>'select_localidad']) !!} <br/>
    {!! FORM::label('cp', 'C&oacute;digo Postal:') !!} <br/>
    {!! FORM::text('cp',$comunidad->cp, ["class" => "form-control", "title"=>"C&oacute;digo Postal", "maxlength"=>"9"]) !!}
    <br/>
    {!! FORM::label('direccion_postal', 'Apartado de Correos:') !!} <br/>
    {!! FORM::text('direccion_postal',$comunidad->direccion_postal, ["class" => "form-control", "title"=>"Email", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('direccion', 'Direcci&oacute;n:') !!} <br/>
    {!! FORM::text ('direccion',$comunidad->direccion,array('class'=> 'form-control', "title"=>"Direcci&oacute;n",
    "maxlength"=>"100") )!!}
    <br/>

    <div class="heading-caption">Comunicaci&oacute;n</div>
    {!! FORM::label ('comunicacion_preferida', 'Comunicaci&oacute;n Preferida:') !!} <br/>
    {!! FORM::select('tipo_comunicacion_preferida_id',$comunicaciones_preferidas,
    $comunidad->tipo_comunicacion_preferida_id, ["class" =>
    "form-control"]) !!} <br/>
    {!! FORM::label('email_solicitud', 'Email para solicitar intendencia:') !!} <br/>
    {!! FORM::text('email_solicitud',$comunidad->email_solicitud, ["class" => "form-control", "title"=>"Email", "maxlength"=>"60"]) !!}
    <br/>
    {!! FORM::label('email_envio', 'Email para enviar nuestras respuestas:') !!} <br/>
    {!! FORM::text('email_envio',$comunidad->email_envio, ["class" => "form-control", "title"=>"Email", "maxlength"=>"60"]) !!}
    <br/>
    {!! FORM::label('web', 'WEB:') !!} <br/>
    {!! FORM::text('web',$comunidad->web, ["class" => "form-control", "title"=>"Direcci&oacute;n WEB", "maxlength"=>"50"]) !!}
    <br/>
    {!! FORM::label('facebook', 'FaceBook:') !!} <br/>
    {!! FORM::text('facebook',$comunidad->facebook, ["class" => "form-control", "title"=>"FaceBook", "maxlength"=>"50"])
    !!}
    <br/>
    {!! FORM::label('telefono1', 'Tel&eacute;fono 1:') !!} <br/>
    {!! FORM::text('telefono1',$comunidad->telefono1, ["class" => "form-control", "title"=>"Tel&eacute;fono",
    "maxlength"=>"13"]) !!}
    <br/>
    {!! FORM::label('telefono2', 'Tel&eacute;fono 2:') !!} <br/>
    {!! FORM::text('telefono2',$comunidad->telefono2, ["class" => "form-control", "title"=>"Tel&eacute;fono",
    "maxlength"=>"13"]) !!}
    <br/>


    <div class="heading-caption">Participativa</div>
    {!! FORM::label ('esColaborador', 'Colabora:') !!} <br/>
    {!! FORM::select('esColaborador',array('1'=>'Si','0'=>'No'), $comunidad->esColaborador
    ,array('class'=>'form-control')) !!}
    <br>

    <div class="heading-caption">Color Mis Cursos</div>
    {!! FORM::label ('colorFondo', 'Color Fondo Cursos') !!}
    <select id="select-color-fondo" class="form-control" name="colorFondo">
        @foreach ($coloresFondo as $color)
            <option value="{{$color->codigo_color}}" @if($color->codigo_color==$comunidad->colorFondo)
            selected="selected" @endif>{{$color->nombre_color}}</option>
        @endforeach
    </select>
    {!! FORM::label ('colorTexto', 'Color Texto Cursos') !!}
    <select id="select-color-texto" class="form-control" name="colorTexto">
        @foreach ($coloresTexto as $color)
            <option value="{{$color->codigo_color}}" @if($color->codigo_color==$comunidad->colorTexto)
            selected="selected" @endif>{{$color->nombre_color}}</option>
        @endforeach
    </select>
    <br/>
    <div class="panel panel-default panel-body text-center">
        <div id="muestraColoresComunidad" class="icon-size-large">Resultado Color Fondo + Color Texto</div>
    </div>
    <div class="heading-caption">Otros</div>
    {!! FORM::label('observaciones', 'Observaciones:') !!} <br/>
    {!! FORM::textarea ('observaciones',$comunidad->observaciones,array('class'=> 'form-control',
    "title"=>"Observaciones" ) )!!}
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