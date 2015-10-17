<div class="inline-block pull-right">
    {!!FORM::model(Request::only(['cursillo','semanas','anyos']),['route'=>'inicio','method'=>'GET','class'=>'navbar-form
    navbar-right','role'=>'search']) !!}
    {!! FORM::select('anyos', $anyos, null,array("class"=>"select-control pull-left",'id'=>'select_anyos'))!!}
    {!! FORM::select('semanas', $semanas, null,array("class"=>"select-control pull-left",'id'=>'select_semanas'))!!}
    <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span></button>
    {!! FORM::close() !!}
</div>