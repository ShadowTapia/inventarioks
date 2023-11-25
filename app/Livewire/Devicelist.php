<?php

namespace App\Livewire;

use App\Models\devices;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Devicelist extends Component
{
    use WithPagination;

    public $title;

    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->title = "Listado de Dispositivos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $devices = devices::paginate(10);
        return view('livewire.devicelist', ['title' => $this->title, 'devices' => $devices]);
    }
}
