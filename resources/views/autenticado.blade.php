@extends ("plantillas.admin")
@section('contenido')
    <div class="container">
        <div class="row">
            <div class="table-size-optima">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
             </div>
        </div>
    </div>
@endsection
@section('js')
    {!! HTML::script("js/vendor/fullcalendar/moment.min.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/fullcalendar.js")!!}
    {!! HTML::script("js/vendor/fullcalendar/lang/es.js")!!}
@endsection