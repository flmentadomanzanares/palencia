@extends ("plantillas.admin")
@section ("css")
@endsection
@section ("contenido")
    <div class="row">
        <img src="../public/img/portada.jpg" alt="Portada" class="img-responsive ">
{{--
        <div > <!-- row carrousel -->
            <div id="myCarousel" class="carousel slide hidden-xs" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
    <div class="altoMaximo">
        <div class="row">

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                    <div class="item active">
                        <img src="../public/img/slider/slider1.jpg" alt="Slide1" class="img-responsive ">

                    </div>

                    <div class="item">
                        <img src="../public/img/slider/slider2.jpg" alt="Slide2" class="img-responsive ">

                    </div>

                    <div class="item">
                        <img src="../public/img/slider/slider3.jpg" alt="Slide3" class="img-responsive ">
                    </div>

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>  <!-- end row carrousel -->
    </div>
    {{-- Formulario Registrarse --}}
    <div id="formularioModal">
        <div class="ventanaModal">
            <div class="headerFormularioModal">
                <span class="headerFormularioModalTitle"></span>
                <a title="Cerrar" class="closeFormModal">X</a>
            </div>
            <div class="cuerpoFormularioModal">
                <div class="scroll">
                    {!! FORM::open(array('url' => 'auth/register')) !!}

                    {!! FORM::label('fullname', 'nombre completo') !!} <br/>
                    {!! FORM::text ('fullname',"",array("class"=>"form-control")) !!} <br/>

                    {!! FORM::label('username', 'nombre usuario') !!} <br/>
                    {!! FORM::text ('name',"",array("maxlength"=>"20","class"=>"form-control")) !!} <br/>

                    {!! FORM::label ('email', 'email') !!} <br/>
                    {!! FORM::text('email',"",array("class"=>"form-control")) !!} <br/>

                    {!! FORM::label ('password', 'contraseña') !!} <br/>
                    {!! FORM::password ('password',array("class"=>"form-control")) !!} <br/>

                    {!! FORM::label ('passwordConfrmation', 'repetir contraseña') !!} <br/>
                    {!! FORM::password ('password_confirmation',array("class"=>"form-control")) !!}

                    {!! FORM::hidden ('activo', 1) !!}

                    <br/>

                    {!! FORM::submit('registrarse',array("class"=>"btn btn-success btn-block")) !!}

                    {!! FORM::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    {!! HTML::script('js/publico/modal.js') !!}
@endsection
