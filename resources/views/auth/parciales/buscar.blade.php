<div id="buscar-calendario" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="115"
             data-etiqueta_ancho="80">
            <span title="Buscar" class="text-center">
                <i class="glyphicon glyphicon-search text-center">
                    <div>Buscar</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['esPropia','semanas','anyos','comunidad']),
                ['route'=>'inicio','method'=>'GET','class'=>'','role'=>'search']) !!}
                <div class="form-group">
                    {!! FORM::select('esPropia', array(''=>'Tipo Comunidad...','true'=>'Propia','false'=>'No Propia'),
                   null,array("class"=>"form-control"))!!}
                </div>
                <div class="form-group">
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>
                <div class="form-group">
                    {!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
                </div>
                <div class="form-group">
                    {!! FORM::text('comunidad',null,['class'=>'form-control','placeholder'=>'Comunidad...'])!!}
                </div>
                <button type="submit" class="btn btn-primary btn-block"><span
                            class='glyphicon glyphicon-search'></span>
                </button>
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
