<?php

namespace App\Livewire;

use App\Models\devices;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Devicelist extends Component
{
    use WithPagination;

    public $numserie;

    public $title;

    public $sortColumn = "id";
    public $sortDirection = "asc";

    protected $paginationTheme = "bootstrap";

    protected $queryString = ['numserie'];

    public function mount()
    {
        $this->title = "Listado de Dispositivos";
    }

    public function updatingNumserie()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $devices = devices::orderBy($this->sortColumn, $this->sortDirection);

        if ($this->numserie) {
            $devices->where('numserie', 'like', '%' . $this->numserie . '%');
        }

        $devices = $devices->paginate(10);

        return view('livewire.devicelist', ['title' => $this->title, 'devices' => $devices]);
    }

    public function cleanFilter()
    {
        $this->numserie = "";
    }

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }
}
