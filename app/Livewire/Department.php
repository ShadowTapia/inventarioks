<?php

namespace App\Livewire;

use App\Models\department as ModelsDepartment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Department extends Component
{
    use WithPagination;

    public $title;
    public $confirmingDepaDeletion = false;

    protected $paginationTheme = "bootstrap"; //Importante para tener un estilo distinto para la paginación

    public function mount()
    {
        $this->title = "Lista de Departamentos";
    }

    #[Layout('layouts.app')]
    public function render()
    {

        $depas = ModelsDepartment::paginate(10);


        return view('livewire.department', ['depas' => $depas, 'title' => $this->title]);
    }

    /**
     * Se encarga de borrar un departamento
     */
    public function delDepa(ModelsDepartment $depa)
    {
        $device = $depa->devices()->count(); //Verificamos que no existan dispositivos asociados al departamento
        if ($device > 0) {
            $this->confirmingDepaDeletion = false;
            return redirect()->back()->with(['error' => 'Existen dispositivos asociados a este departamento.-']);
        } else {
            $depa->deleteOrFail();
            $this->confirmingDepaDeletion = false;
            return redirect()->back()->with(['success' => 'Departamento borrado correctamente.-']);
        }
    }

    public function confirmDepaDeletion($id)
    {
        $this->confirmingDepaDeletion = $id;
    }
}
