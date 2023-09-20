<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserSave extends Component
{
    public $name;
    public $email;
    public $password;

    public $user;
    public $title;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user-save')->title($this->title);
    }

    public function submit()
    {
        //TODO validar
        $this->validate();

        if ($this->user) {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
            ]);
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
            ]);
        }
    }

    public function init($id)
    {
        $user = null;

        if ($id) {
            $this->title = "Actualizar Usuario";
            $user = User::findOrFail($id);
        } else {
            $this->title = "Crear Usuario";
        }

        $this->user = $user;

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
        }
    }
}
