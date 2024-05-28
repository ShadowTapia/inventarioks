<?php

namespace App\Http\Controllers;

use App\Models\devices;
use Illuminate\Support\Facades\App;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PrintCodebarAll extends Controller
{
    public function index()
    {
        $devlist = devices::all();

        return view('livewire.components.printCodebarAll', compact('devlist'));
    }

    /**
     * Se encarga de imprimir para todos los dispositivos sus códigos de barra
     */

    public function printCodeAll()
    {
        $devices = array();

        $devlist = devices::all();


        if ($devlist->count() > 0) {
            $conta = 0;
            foreach ($devlist as $devi) {
                $conta++;

                $generator = new BarcodeGeneratorPNG();
                $barcode = base64_encode($generator->getBarcode($devi->numserie, $generator::TYPE_CODE_128));
                $devices[$conta][0] = $devi->product->name;
                $devices[$conta][1] = $devi->product->modelo;
                $devices[$conta][2] = $devi->comentarios;
                $devices[$conta][3] = $devi->department->name;
                $devices[$conta][4] = $barcode;
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.components.printCodebarAll', compact('devices'));
        return $pdf->stream();
    }
}
