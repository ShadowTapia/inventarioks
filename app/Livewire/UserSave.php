<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserSave extends Component
{
    public $name;
    public $email;
    public $password;
    public $enabledEdit = false; //Se encargara de habilitar la asignación de roles cuando exista el usuario

    public array $userRoles;

    public $user;
    public $title;
    public $msg = "";


    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'userRoles.*' => 'exists:roles,id',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user-save', ['title' => $this->title, 'enableEdit' => $this->enabledEdit])
            ->withRoles(
                cache()->remember('roles', 60, function () {
                    return Role::all();
                })
            );
    }

    public function submit()
    {
        if ($this->user)
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->user->id;


        //TODO validar
        $this->validate();

        $this->password = Hash::make($this->password);

        //Se inicia la transacción
        DB::beginTransaction();
        try {
            if ($this->user) { //Si el existe el usuario, se produce la actualización
                $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);
                $this->user->roles()->sync($this->userRoles);
                $this->msg = "Usuario actualizado con exito!!";
            } else {
                User::create([ //Si no existe se procede a guardar la info
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);
                $this->msg = "Usuario creado con exito!!";
            }
            DB::commit();
            return redirect()->route('usuarios')->with(['success' => $this->msg]);
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            return redirect()->back()->withError($message);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            return redirect()->back()->withError($message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            return redirect()->back()->withError($message);
        }
    }

    public function init($id)
    {
        $user = null;

        if ($id) {
            $this->title = "Actualizar Usuario";
            $user = User::findOrFail($id);
            $this->userRoles = $user->roles()->pluck('id')->toArray();
        } else {
            $this->enabledEdit = false;
            $this->title = "Crear Usuario";
        }

        $this->user = $user;

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->enabledEdit = true;
        }
    }
}
