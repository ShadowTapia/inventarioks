<?php

namespace App\Livewire;

use App\Models\company;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $title;
    public $confirmingCompDeletion;

    protected $paginationTheme = "bootstrap";

    public function mount()
    {
        $this->title = 'Listado de Compañias';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $companys = company::paginate(10);

        return view('livewire.companies', ['companys' => $companys, 'title' => $this->title]);
    }

    /**
     *
     * Procedimiento de borrado de compañías
     */
    public function delComp(company $comp)
    {
        $products = $comp->products()->count();
        if ($products > 0) {
            $this->confirmingCompDeletion = false;
            return redirect()->back()->with(['error' => 'Existen productos asociados a esta compañía.-']);
        } else {
            $comp->deleteOrFail();
            $this->confirmingCompDeletion = false;
            return redirect()->back()->with(['success' => 'Compañía borrada correctamente.-']);
        }
    }

    public function confirmCompDeletion($id)
    {
        $this->confirmingCompDeletion = $id;
    }
}
