<div id="buscar-calendario" class="formularioModal">
    <div class="ventanaModal">
        <div class="headerFormularioModal">
            <span class="text-center"></span>

            <div title="Cerrar" class="closeFormModal">X</div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['esPropia','semanas','anyos']),
                ['route'=>'inicio','method'=>'GET','class'=>'navbar-form navbar-right','role'=>'search']) !!}
                {!! FORM::select('esPropia', array(''=>'Tipo Comunidad...','1'=>'Propia','0'=>'No Propia'),
               null,array("class"=>"select-control pull-left"))!!}
                {!! FORM::select('anyo', $anyos, null,array("class"=>"select-control pull-left",'id'=>'select_anyos'))!!}
                {!! FORM::select('semana', $semanas, null,array("class"=>"select-control pull-left",'id'=>'select_semanas'))!!}
                <button type="submit" class="btn-register pull-right"><span class='glyphicon glyphicon-search'></span>
                </button>
                {!! FORM::close() !!}

            </div>
        </div>
        <div class="footerFormularioModal">
            <div class="btn btn-success pull-left"></div>
            <div class="btn btn-danger pull-right actionOkClick"></div>
        </div>
    </div>
</div>