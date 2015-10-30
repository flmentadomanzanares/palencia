<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PdfController extends Controller {

    public function invoice()
    {
        $data = $this->getData();
        $date = date('d-m-Y');
        $invoice = "2222";
        $pdf = \App::make('dompdf.wrapper');
         $pdf->loadView('cursillos.index',compact('data','date','invoice'),[],'UTF-8')->save('pruebaok.pdf');
        return null;
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

    public function cursillos(Request $request)
    {
        $date = date('d-m-Y');
        $semana = date('W-Y');
        $cursillos = Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio',
            'cursillos.activo', 'comunidades.comunidad', 'tipos_cursillos.tipo_cursillo',
            'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('tipos_cursillos', 'tipos_cursillos.id', '=', 'cursillos.tipo_cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC');
    }
}
