@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden">
        <div class="row table-size-optima">
            {!! FORM::open(['route' => 'estadosSolicitudes.store']) !!}
            @include('estadosSolicitudes.parciales.nuevoYmodificar')
            <div class="btn-action margin-bottom">
                <a title="Volver" href="{{route('estadosSolicitudes.index')}}" class="pull-left">
                    <i class="glyphicon glyphicon-arrow-left">
                        <div>Volver</div>
                    </i>
                </a>
                <button type="submit" title="Crear" class="pull-right">
                    <i class='glyphicon glyphicon-plus full-Width'>
                        <div>Crear</div>
                    </i>
                </button>
            </div>
            {!! FORM::close() !!}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#select-color').simplecolorpicker({picker: true, theme: 'glyphicons'});
        });
    </script>
@endsection
@section("css")
    {!! HTML::style("css/vendor/ColorPicker/jquery.simplecolorpicker.css")!!}
@stop
@section('js')
    {!! HTML::script("js/vendor/ColorPicker/jquery.simplecolorpicker.js")!!}
@endsection
