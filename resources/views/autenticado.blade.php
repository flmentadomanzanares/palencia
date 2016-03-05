@extends ("plantillas.admin")
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden">
        @if (Auth::check())
            @if (!empty($calendar))
                <div class="row ">
                    @include('auth.parciales.buscar')
                </div>
                <div class="calendar-container">
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                </div>
            @else
                <h1 class="alert alert-info text-center">No existen cursillos programados</h1>
            @endif
        @endif
    </div>
@endsection
@section('css')
    {!! HTML::style('css/vendor/fullCalendar/fullcalendar.css') !!}
@endsection
@section('js')
    {!! HTML::script('js/comun/semanas.js') !!}
    {!! HTML::script("js/vendor/fullcalendar/moment.min.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/fullcalendar.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/lang/es.js")!!}
@endsection