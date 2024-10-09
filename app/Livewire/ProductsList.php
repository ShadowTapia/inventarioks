<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductsList extends Component
{

    public $title;

    public function mount()
    {
        $this->title = "Listado de Productos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.products-list', [
            'title' => $this->title
        ]);
    }
}
