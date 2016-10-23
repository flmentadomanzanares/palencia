@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaNuestrasRespuestas')
            <div data-role="cursullos">
            <div class="heading-caption">Cursillos</div>
            <div id="listado_cursillos" class="text-left"></div>
            </div>
            <div data-role="Destinatarios">
                <div class="heading-caption">Comunidades Destinatarias</div>
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    @if (Auth::check())
        {!! HTML::script('js/comun/nuestrasRespuestas.js') !!}
    @endif
@endsection
