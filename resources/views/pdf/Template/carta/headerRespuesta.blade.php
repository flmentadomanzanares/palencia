<div style="width:100%;text-align: right">
    <img class="logo" src='img/logo/logo.png' alt=""/>
</div>
<div class="remitente">
    <span class="alineacion">{{$remitente->comunidad}}</span>
    @if(strlen($remitente->direccion)){{$remitente->direccion}}<br/>@endif
    {{$remitente->cp}} {{$remitente->localidad}}@if(strlen($remitente->pais)>0)-{{$remitente->pais}} @endif
</div>
<div class="destinatario">
    CURSILLOS DE CRISTIANDA DE
    @if(strlen($destinatario->comunidad)>0){{strtoupper($destinatario->comunidad)}}<br/>@endif
    @if(strlen($destinatario->direccion)>0){{$destinatario->direccion}}<br/>
    @else
        @if(strlen($destinatario->direccion_postal)>0){{$destinatario->direccion_postal}}<br/> @endif
    @endif
    @if(strlen($destinatario->cp)>0){{$destinatario->cp}} @endif
    @if(strlen($destinatario->localidad)>0)-{{$destinatario->localidad}} @endif

    @if(strlen($destinatario->cp)>0 || strlen($destinatario->localidad)>0)<br/> @endif
    @if(strlen($destinatario->provincia)>0){{$destinatario->provincia}}
    @if(strlen($destinatario->pais)>0)-{{$destinatario->pais}}@endif
    @endif
</div>
