<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $name;

    public function mount()
    {
        //$this->name = "Marcelo";
    }
    public function render()
    {
        $users = User::orderBy('created_at', 'desc');

        if ($this->name) {
            $users->where('name', 'like', '%' . $this->name . '%');
        }

        $users = $users->paginate(5);

        return view('livewire.users-list', ['users' => $users]);
    }
}
