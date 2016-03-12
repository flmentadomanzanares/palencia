@extends ("plantillas.admin")
@section ("css")
@endsection
@section ("contenido")
    <div class="spinner"></div>
    <div class="hidden">
        <div class="row ">
            <div class="full-width"
                 style='height:450px;
                         background-repeat:no-repeat;
                         background-position:center center;
                         background-size:100% 100%;
                         background-image:url("{{asset('img/portada/portada.jpg')}}")'>
            </div>
        </div>
    </div>
@stop
@section('js')
@endsection
