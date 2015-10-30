<html lang="sp">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    <style>
        .logo{

        }
    </style>
</head>
<body>
<div class="logo">
    <img src={!!asset('img/cabecera.png')!!} alt="Responsive image" class="img-responsive block-center">
</div>

<div>
    <div id="invoice">
        @foreach($cur as $curso)
            {{ $curso }}<br/>
            @endforeach
    </div>
</div>


</body>
</html>
