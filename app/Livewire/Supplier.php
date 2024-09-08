<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Supplier extends Component
{
    public $title;

    public function mount()
    {
        $this->title = "Listado de Proveedores";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.supplier', ['title' => $this->title]);
    }
}
