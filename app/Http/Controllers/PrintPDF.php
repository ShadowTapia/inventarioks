<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Support\Facades\App;

class PrintPDF extends Controller
{
    public function index()
    {
        $prtlist = products::all();
        return view('livewire.components.printPDF', compact('prtlist'));
    }

    /**
     * Se encarga de imprimir el listado de productos
     */
    public function printPDF()
    {
        $prtlist = products::all();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.components.printPDF', compact('prtlist'));
        return $pdf->stream();
    }
}
