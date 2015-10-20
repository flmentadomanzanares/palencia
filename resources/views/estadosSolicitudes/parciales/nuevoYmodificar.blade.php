<div class="form-group">
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('estadoSolicitud', 'Estado solicitud') !!} <br/>
    {!! FORM::text('estado_solicitud', $estados_solicitudes->estado_solicitud, ["class" => "form-control", "title"=>"Tipo de cursillo"]) !!}
    <br/>
    {!! FORM::label ('color', 'Color de fondo') !!}
    <select id="select-color" class="form-control" name="color">
        @foreach ($colors as $color)
            <option  value="{{$color->codigo_color}}"@if($color->codigo_color==$estados_solicitudes->color) selected="selected" @endif>{{$color->nombre_color}}</option>
        @endforeach
    </select>
    <br/>
    @if (Auth::check())
        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('1'=>'Si','0'=>'No'), $estados_solicitudes->activo,array('class'=>'form-control')) !!}
        @endif
    @endif
</div>