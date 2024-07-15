<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PermisosList extends Component
{
    public $title;

    public function mount()
    {
        $this->title = "Lista de Permisos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.permisos-list', ['title' => $this->title]);
    }
}
