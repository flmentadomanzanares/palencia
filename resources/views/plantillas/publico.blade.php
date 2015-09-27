<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield("titulo","ViaOptima")</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{!!asset('img/index/logo_viaioptima_250.png')!!}" type="image/png"/>
    <!-- Bootstrap CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/palencia.css') !!}

    @yield("css")
</head>
<body>

<div class="container-fluid">
    <div class="row"> <!-- Cabecera -->
        <!--a href="http://viaoptima.es"><img src="{!!asset('img/logo_viaoptima.png')!!}" alt="logo" class="img-responsive"></a-->
    </div>
    <!-- end Cabecera -->
    <nav role="navigation" id="barra" class="navbar navbar-default navbar-static-top block-center">
        <!-- Grouping Brand with Toggle for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="http://viaoptima.es" class="navbar-brand"><img src="{!!asset('img/logo_viaoptimax.png')!!}"
                                                                    alt="logo"></a>
        </div>
        <!-- Next nav links in the Navbar -->
        <div id="navbarCollapse" class="collapse navbar-collapse" id="myScrollspy">
            <ul class="nav navbar-nav">

                <li class="divider">&nbsp;&nbsp;</li>
                <li><a href="">lanzadera</a></li>
                <li><a href="{{ url('#scrollStop') }}" data-tab="proyectos">insertar proyecto</a></li>
                <li><a href="{{ url('#scrollStop') }}" data-tab="iniciativas">insertar iniciativa</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle login" href="login" data-toggle="dropdown"><strong>login/sign in </strong><strong
                                class="caret"></strong></a>

                    <div class="dropdown-menu" style="padding: 20px;width:240px">
                        {!! FORM::open(array('url' => 'auth/login')) !!}

                        {!! FORM::label('email', 'email') !!} <br/>
                        {!! FORM::text ('email','',array("placeholder"=>"email de usuario",
                        "class"=>"form-control")) !!}
                        <br/>

                        {!! FORM::label ('password', 'contraseña') !!} <br/>
                        {!! FORM::password ('password',array("class"=>"form-control","placeholder"=>"password"))
                        !!} <br/>

                        {!! FORM::submit('login',array("class"=>"btn btn-success btn-block")) !!}
                        <br/>
                        <a class="formularioModal btn btn-success btn-block" href="">sign in</a>
                        {!! FORM::close() !!}
                    </div>
                </li>
            </ul>

        </div>
    </nav>


    <div class="col-md-12">

        <h1>@yield ('titulo')</h1>
        @yield("contenido")
    </div>
</div>

</div>

<footer>
    <div class="row">

        <div class="col-xs-12 col-sm-3">
            <p class="centrar">&copy; V&iacute;a &Oacute;ptima | desarrollado por KOALNET - 2015</p>
        </div>
        <!-- end col-sm-4 -->

        <div class="col-sm-offset-1 col-xs-12 col-sm-2 text-center">
            <p><a href="{!!asset('aboutus')!!}">quienes somos</a></p>
        </div>
        <!-- end col-sm-2 -->

        <div class="col-xs-12 col-sm-1 text-center">
            <p><a href="{!!asset('contacto')!!}">contactanos</a></p>
        </div>
        <!-- end col-sm-2 -->
        <div class=" col-sm-offset-3 col-xs-12 col-sm-2 ">
            <p class="text-center"><a href="https://es-es.facebook.com/pages/Via-Optima/1418818705037988"
                                      target="_blank"><img src="{!!asset('img/footer/icono-fb.png')!!}" alt="Facebook"
                                                           class="redes"/></a>
                <a href="https://twitter.com/viaoptima360" target="_blank"><img src="{!!asset('img/footer/icono-twitter.png')!!}"
                                                                                alt="Twitter" class="redes"/></a>
                <a href="https://plus.google.com/110800081299946980331/posts" target="_blank"><img
                            src="{!!asset('img/footer/icono-googleplus.png')!!}" alt="Google+" class="redes"/></a></p>
        </div>
        <!-- end col-sm-2 -->


    </div>
    <!-- end row -->
</footer>

</div>
<!-- jQuery -->
{!! HTML::script('js/jquery-2.1.1.js') !!}
<!-- Bootstrap JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}
<!--User JavaScript -->
@yield("js")
</body>
</html>
