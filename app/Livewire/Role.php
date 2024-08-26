<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Role extends Component
{
    public $title;

    public function mount()
    {
        $this->title = "Lista de Roles";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.role', ['title' => $this->title]);
    }
}
