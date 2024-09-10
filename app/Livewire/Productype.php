<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Productype extends Component
{

    public $title;

    public function mount()
    {
        $this->title = 'Listado de Tipos de Productos';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.productype', ['title' => $this->title]);
    }
}
