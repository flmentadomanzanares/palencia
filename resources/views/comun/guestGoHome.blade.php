@extends('plantillas.admin')
@section('contenido')
    <div width="100%" height="400px" class="row">
        <div class="form-group">
            <div class="heading-caption">Has perdido la sesión</div>
            <a title="Volver" href="{{route('cursillos.index')}}" class="pull-right">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Ir login</div>
                </i>
            </a>
        </div>
    </div>
@endsection
