<?php

namespace App\Http\Controllers;

use App\Models\devices;
use Illuminate\Support\Facades\App;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PrintCodebaru extends Controller
{
    public $device;
    public $numserie;
    public $producto;
    public $modelo;

    public function index()
    {
        return view('livewire.components.printCodebaru');
    }

    /**
     * Se encarga de imprimir el código de barra de un dispositivo
     */
    public function printCodeBar($id)
    {
        $device = null;

        if ($id) {
            $device = devices::findOrFail($id);
        }

        $this->device = $device;

        if ($this->device) {
            $this->numserie = $this->device->numserie;
            $this->producto = $this->device->product->name;
            $this->modelo = $this->device->product->modelo;
        }

        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($this->numserie, $generator::TYPE_CODE_128));
        //Le paso la data con la que construirá el codebar
        $data = [
            'producto' => $this->producto,
            'barcode' => $barcode,
            'modelo' => $this->modelo,
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.components.printCodebaru', $data);
        return $pdf->stream(); //aparece en pantalla

    }
}
