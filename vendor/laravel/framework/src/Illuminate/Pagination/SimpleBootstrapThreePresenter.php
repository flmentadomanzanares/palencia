<?php namespace Illuminate\Pagination;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;

class SimpleBootstrapThreePresenter extends BootstrapThreePresenter
{

    /**
     * Create a simple Bootstrap 3 presenter.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator $paginator
     * @return void
     */
    public function __construct(PaginatorContract $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            $html = "<div id='paginacion' class='formularioModal'>
                        <div class='modalBackGround'></div>
                        <div class='ventanaModal'>
                            <div class='lanzarModal simpleModal'
                                data-etiqueta_ancho='80'
                                data-modal_centro_pantalla='false'
                                data-modal_en_la_derecha='false'
                                data-etiqueta_color_fondo='rgba(76, 158, 217,.8)'
                                data-etiqueta_color_texto='rgba(255,255,255,1)'
                                data-modal_posicion_vertical='115'
                                data-modal_plano_z='2'
                                data-modal_en_la_derecha='false'
                                data-modal_ancho='50'>
                                    <span title='Paginacion'>
                                        <i class='glyphicon glyphicon-search text-center'>
                                            <div>Paginacion</div>
                                        </i>
                                    </span>
                            </div>
                            <div class='cuerpoFormularioModal'>
                                <div class='scroll'>
                                    <ul class=\"pager\">%s %s</ul>
                                </div>
                            </div>
                        </div>
                    </div>";
            return sprintf(
                $html,
                $this->getPreviousButton(),
                $this->getNextButton()
            );
        }

        return '';
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages() && count($this->paginator->items()) > 0;
    }

}
