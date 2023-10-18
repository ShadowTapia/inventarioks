<?php

namespace App\Livewire;

use App\Models\supplier as ModelsSupplier;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Supplier extends Component
{
    use WithPagination;

    public $title;
    public $confirmingSuppDeletion = false;

    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->title = "Listado de Proveedores";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $suppliers = ModelsSupplier::paginate(10);

        return view('livewire.supplier', ['suppliers' => $suppliers, 'title' => $this->title]);
    }

    /**
     * Función eliminado de proveedores
     */
    public function delSupp(ModelsSupplier $supp)
    {
        //Verificamos que no existan productos asociados al proveedor
        $products = $supp->products()->count();
        if ($products > 0) {
            $this->confirmingSuppDeletion = false;
            return redirect()->back()->with(['error' => 'Existen productos asociados a este Proveedor.-']);
        } else {
            $supp->deleteOrFail();
            $this->confirmingSuppDeletion = false;
            return redirect()->back()->with(['success' => 'Proveedor borrado correctamente.-']);
        }
    }

    public function confirmSuppDeletion($id)
    {
        $this->confirmingSuppDeletion = $id;
    }
}
