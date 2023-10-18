<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $columns = [
        'id',
        'name',
        'email'
    ];

    public $name;
    public $title;

    public $sortColumn = "id";
    public $sortDirection = "asc";

    public $confirmingUserDeletion = false;

    protected $paginationTheme = "bootstrap";

    protected $queryString = ['name'];

    public function mount()
    {
        $this->name = "";
        $this->title = "Lista de Usuarios";
    }

    public function updatingName()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::orderBy($this->sortColumn, $this->sortDirection);

        if ($this->name) {
            $users->where('name', 'like', '%' . $this->name . '%')
                ->orWhere('email', 'like', '%' . $this->name . '%');
        }

        $users = $users->paginate(10);

        return view('livewire.users-list', ['users' => $users, 'title' => $this->title]);
    }

    /**
     * Se encarga de limpiar el input de filtrado
     */
    public function cleanFilter()
    {
        $this->name = "";
    }

    /**
     * Se encarga de eliminar un usuario
     */
    public function delUser(User $user)
    {
        $products = $user->products()->count();
        if ($products > 0) {
            $this->confirmingUserDeletion = false;
            return redirect()->back()->with(['error' => 'Existen productos asociados a este Usuario, favor de verificar.-']);
        } else {
            $user->deleteOrFail();
            $this->confirmingUserDeletion = false;
            return redirect()->back()->with(['success' => 'Usuario borrado correctamente.-']);
        }
    }

    /**
     * Recibe la confirmación para mostrar el modal de eliminación
     */
    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = $id;
    }

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }
}
