<?php

namespace App\Livewire;

use App\Models\productype as ModelsProductype;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Productype extends Component
{
    use WithPagination;

    public $title;
    public $confirmingProtypeDeletion = false;

    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->title = 'Listado de Tipos de Productos';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $productypes = ModelsProductype::paginate(10);
        return view('livewire.productype', ['productypes' => $productypes, 'title' => $this->title]);
    }

    /**
     * Se encarga de borrar el tipo de producto
     */
    public function delProtype(ModelsProductype $protype)
    {
        $products = $protype->products()->count();
        if ($products > 0) {
            $this->confirmingProtypeDeletion = false;
            return redirect()->back()->with(['error' => 'Existen productos asociados a este tipo de producto.-']);
        } else {
            $protype->deleteOrFail();
            $this->confirmingProtypeDeletion = false;
            return redirect()->back()->with(['success' => 'Tipo de producto borrado existosamente.-']);
        }
    }

    public function confirmProtypeDeletion($id)
    {
        $this->confirmingProtypeDeletion = $id;
    }
}
