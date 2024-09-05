<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;


class Department extends Component
{
    public $title;

    public function mount()
    {
        $this->title = "Lista de Departamentos";
    }

    #[Layout('layouts.app')]
    public function render()
    {

        return view('livewire.department', ['title' => $this->title]);
    }
}
