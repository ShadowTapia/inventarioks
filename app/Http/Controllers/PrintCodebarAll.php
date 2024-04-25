<?php

namespace App\Http\Controllers;

use App\Models\devices;
use Illuminate\Http\Request;

class PrintCodebarAll extends Controller
{
    public function index()
    {
        $devices = array();
        $device = devices::all();
        if ($device > 0) {
            foreach ($device as $dispo) {
                $devices[] = $dispo;
            }
        }

        return view('livewire.components.printCodebarAll', ['devices' => $devices]);
    }

    public function printCodeAll()
    {
        $device = null;
    }
}
