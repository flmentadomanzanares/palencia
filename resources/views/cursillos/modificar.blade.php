@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($proyectos, ['route' => ['proyectos.update', $proyectos->id], 'method' => 'patch']) !!}
        @include('proyectos.Parciales.nuevoYmodificar')
        <div class="btn-action">
            <a title="Volver" href="{{route('proyectos.index')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
            <button type="submit" title="Guardar" class="pull-right">
                <i class='glyphicon glyphicon-floppy-disk full-Width'>
                    <div>Guardar</div>
                </i>
            </button>
        </div>
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
    {!! HTML::style("css/vendor/chosen/chosen.min.css") !!}
    {!! HTML::style("css/vendor/datepicker/datepicker.css") !!}
@stop
@section('js')
    {!! HTML::script('js/vendor/chosen/chosen.jquery.min.js') !!}
    {!! HTML::script("js/comun/selectMultiple.js")!!}
    {{-- {!! HTML::script('js/vendor/tinymce/tinymce.min.js') !!}
    {!! HTML::script('js/comun/tinymce.js') !!} --}}
    {!! HTML::script('js/comun/tooltips.js') !!}
    {!! HTML::script('js/vendor/datepicker/datepicker.js') !!}
    {!! HTML::script('js/comun/date.js') !!}
@endsection