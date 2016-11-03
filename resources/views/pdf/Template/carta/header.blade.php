<div style="width:100%;text-align: right">
    <img class="logo" src='img/logo/logo.png' alt=""/>
</div>
<div class="remitente">
    <span class="alineacion">M.C.C. {{$remitente->comunidad}}</span>
    @if(strlen($remitente->direccion)){{$remitente->direccion}}<br/>@endif
    {{$remitente->cp}} {{$remitente->localidad}}@if(strlen($remitente->pais)>0)-{{$remitente->pais}} @endif
</div>
<div class="destinatario">
    <span>CURSILLOS DE CRISTIANDAD DE</span><br>
    @if(strlen($comunidadDestinataria->comunidad)>0){{strtoupper($comunidadDestinataria->comunidad)}}<br/>@endif
    @if(strlen($comunidadDestinataria->direccion_postal)>0){{$comunidadDestinataria->direccion_postal}}<br/>
    @else
        @if(strlen($comunidadDestinataria->direccion)>0){{$comunidadDestinataria->direccion}}<br/>@endif
    @endif
    @if(strlen($comunidadDestinataria->cp)>0){{$comunidadDestinataria->cp}}- @endif
    @if(strlen($comunidadDestinataria->localidad)>0){{$comunidadDestinataria->localidad}} @endif
    @if(strlen($comunidadDestinataria->cp)>0 || strlen($comunidadDestinataria->localidad)>0)<br/> @endif
    @if(strlen($comunidadDestinataria->provincia)>0){{$comunidadDestinataria->provincia}}
    @if(strlen($comunidadDestinataria->pais)>0)-{{$comunidadDestinataria->pais}}@endif
    @endif
</div>
