@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @include('pdf.parciales.buscarComunidades')
            </div>
            @if(!$cursillos->isEmpty())

                <?php $pais = null; ?>

                <div>
                    <table class="table-viaoptima">
                        <thead>

                        </thead>
                        <tbody>

                        @foreach ($cursillos as $cursillo)

                            @if($cursillo->pais != $pais)
                                <tr>
                                    <th  class="bg-primary text-center">
                                        País: {!! $cursillo->pais !!}

                                    </th>
                                    <th><hr></th>
                                </tr>

                                <?php $pais = $cursillo->pais; ?>
                            @endif


                                <tr>
                                    <th class="text-center">
                                        Comunidad: {!! $cursillo->comunidad !!}
                                    </th>
                                </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun cursillo que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row text-center">
                {!! $cursillos->appends(Request::only(['cursillosPaises','semanas','anyos']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanas.js') !!}
@endsection
