<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;
use Palencia\Entities\Cursillos;

use Illuminate\Http\Request;

class PdfController extends Controller {

    public function invoice()
    {
        $data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('pdf.invoice', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');
    }

    public function getData()
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }

    // Listado 'Cursillos en el Mundo'
    public function cursillos()
    {
        $titulo = "Cursillos en el Mundo";

        $date = date('d-m-Y');
        $semana = date('W-Y');
        $cursillos = Cursillos::getCursillosPorPaises();
        //dd($cursillos);
        $view =  \View::make('pdf.cursillos', compact('cursillos', 'semana', 'date', 'titulo'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice'); /* muestra en pantalla*/
        //return $pdf->download('invoice'); /* crea pdf en directorio descargas */
    }

}
