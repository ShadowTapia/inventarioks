<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Devibyestado extends Component
{

    public $title;
    public $msg = "";

    public function mount()
    {
        $this->title = "Dispositivos por Estado";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.devibyestado', [
            'title' => $this->title,
        ]);
    }
}
