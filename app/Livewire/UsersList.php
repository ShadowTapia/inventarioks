<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $name;
    public $title;

    protected $queryString = ['name'];

    public function mount()
    {
        $this->name = "";
        $this->title = "Lista de Usuarios";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::orderBy('created_at', 'desc');

        if ($this->name) {
            $users->where('name', 'like', '%' . $this->name . '%')
                ->orWhere('email', 'like', '%' . $this->name . '%');
        }

        $users = $users->paginate(5);

        return view('livewire.users-list', ['users' => $users])->title($this->title);
    }

    public function cleanFilter()
    {
        $this->name = "";
    }

    public function delUser(User $user)
    {
        $user->deleteOrFail();
    }
}
