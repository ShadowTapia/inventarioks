<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Companies extends Component
{

    public $title;

    public function mount()
    {
        $this->title = 'Listado de Compañias';
    }

    #[Layout('layouts.app')]
    public function render()
    {

        return view('livewire.companies', ['title' => $this->title]);
    }
}
