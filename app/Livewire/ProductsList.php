<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\products;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $title;

    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->title = "Listado de Productos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $prtlist = products::paginate(10);

        return view('livewire.products-list', ['prtlist' => $prtlist, 'title' => $this->title]);
    }
}
