@extends ("plantillas.admin")
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden" style="height:100%">
        @if (Auth::check())
            <div class="row ">
                @include('auth.parciales.buscar')
            </div>
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanas.js') !!}
    {!! HTML::script("js/vendor/fullcalendar/moment.min.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/fullcalendar.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/lang/es.js")!!}
@endsection