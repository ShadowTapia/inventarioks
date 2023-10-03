<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends Component
{
    public $title;
    public $confirmingRolDeletion = false;

    public function mount()
    {
        $this->title = "Lista de Roles";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $roles = ModelsRole::all();

        return view('livewire.role', ['roles' => $roles, 'title' => $this->title]);
    }

    /**
     * Se encarga de borrar un rol
     */
    public function delRol(ModelsRole $rol)
    {
        $rol->deleteOrFail();
        $this->confirmingRolDeletion = false;
        return redirect()->back()->with(['success' => 'Rol borrado correctamente.-']);
    }

    public function confirmRolDeletion($id)
    {
        $this->confirmingRolDeletion = $id;
    }
}
