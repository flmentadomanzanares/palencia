@extends ("plantillas.admin")
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden">
        @if (!Auth::check())
            @if (!empty($calendar))
                @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'auth.parciales.buscar'])
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            @else
                <h1 class="alert alert-info text-center">No existen cursillos programados</h1>
            @endif

        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('css')
    @if (!Auth::check())
        {!! HTML::style('css/vendor/fullCalendar/fullcalendar.css') !!}
    @endif
@endsection
@section('js')
    @if (!Auth::check())
        {!! HTML::script('js/comun/semanas.js') !!}
        {!! HTML::script("js/vendor/fullcalendar/moment.min.js")!!}
        {!! HTML::script("js/vendor/fullcalendar/fullcalendar.js")!!}
        {!! HTML::script("js/vendor/fullcalendar/lang/es.js")!!}
    @endif
@endsection