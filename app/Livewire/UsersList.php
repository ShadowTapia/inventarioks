<?php

namespace App\Livewire;


use Livewire\Attributes\Layout;
use Livewire\Component;

class UsersList extends Component
{
    public $title;

    public function mount()
    {
        $this->title = 'Listado de Usuarios';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.users-list', ['title' => $this->title]);
    }
}
