<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public $msg = "";


    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
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
        if ($this->user)
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->user->id;

        //TODO validar
        $this->validate();

        $this->password = Hash::make($this->password);

        DB::beginTransaction();
        try {
            if ($this->user) {
                $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);
                $this->msg = "Usuario actualizado con exito!!";
            } else {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);
                $this->msg = "Usuario creado con exito!!";
            }
            DB::commit();
            return redirect()->route('usuarios')->with(['success' => $this->msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->msg = "Error, ¡favor de intentar mas tarde!";
            return redirect()->back()->with(['error' => $this->msg]);
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
