<div class="form-group">
    <div class="heading-caption">Imagen/Logo</div>
    <div class="logo">
        <div>
            <img src="{!! asset('uploads/usuarios/'.$usuario->foto) !!}" alt="" title="{!!$usuario->foto!!}">
            {!! FORM::file ('foto','',$usuario->foto) !!}
        </div>
    </div>
    <div class="heading-caption">Datos Generales</div>
    {!! FORM::label('fullname', 'Nombre') !!} <br/>
    {!! FORM::text ('fullname',$usuario->fullname,array("class"=>"form-control")) !!} <br/>

    {!! FORM::label('name', 'Usuario') !!} <br/>
    {!! FORM::text ('name',$usuario->name,array("class"=>"form-control")) !!} <br/>

    {!! FORM::label ('password', 'Contraseña') !!} <br/>
    {!! FORM::password ('password',array("class"=>"form-control")) !!} <br/>

    {!! FORM::label ('repass', 'Repetir Contraseña') !!} <br/>
    {!! FORM::password ('password_confirmation',array("class"=>"form-control")) !!}<br/>
    @if (Auth::check())
        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
            <div class="heading-caption">Zona Administrador</div>
            {!! FORM::label ('rol_id', 'Rol') !!} <br/>
            {!! FORM::select('rol_id',$roles, $usuario->rol_id,array("class"=>"form-control")) !!} <br/>

            {!! FORM::label ('estado', 'Activo') !!} <br/>
            {!! FORM::select('activo',array('0'=>'No','1'=>'Si'), $usuario->activo,array("class"=>"form-control")) !!}
            <br/>
        @endif
    @endif
</div>