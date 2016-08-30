@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">Cambiar Contrase&ntilde;a</h1>
@endsection
@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default m-20">
                    <div class="panel-body">
                        <form class="" role="form" method="POST" action="password/reset">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label>Nueva contrase&ntilde;a</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label>Confirmar contrase&ntilde;a</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">
                                    Cambiar contrase&ntilde;a
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
