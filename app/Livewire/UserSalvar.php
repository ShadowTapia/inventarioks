<?php

namespace App\Livewire;

use App\Livewire\Users\UsersTable;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class UserSalvar extends ModalComponent
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
        'password' => 'required|min:8|',
        'userRoles.*' => 'exists:roles,id',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    public function render()
    {
        return view('livewire.user-salvar', ['enableEdit' => $this->enabledEdit, 'title' => $this->title])
            ->withRoles(
                cache()->remember('roles', 60, function () {
                    return Role::all();
                })
            );
    }

    /**
     * Se encarga de agregar un nuevo usuario
     */
    public function submit()
    {
        if ($this->user)
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->user->id;

        //Validamos la data
        $this->validate();

        $this->password = Hash::make($this->password);

        //Agregamos un nuevo usuario
        DB::beginTransaction();
        try {
            if ($this->user) {
                $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);
                $this->user->roles()->sync($this->userRoles);
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
            $this->resetFields(); //Resetamos los campos del form
            $this->closeModal(); //Cerramos el modal
            //LLamamos al listerner para refrescar la tabla de usuarios
            $this->dispatch('$refresh')->to(UsersTable::class);
            //Desplegamos el Toaster para el mensaje de actualización
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => $this->msg,
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
        }
    }

    /**
     * Se encarga de limpiar los campos del formulario
     */
    public function resetFields()
    {
        $this->resetValidation();
        $this->name = '';
        $this->email = '';
        $this->password = "";
    }

    public function init($id)
    {
        $user = null;

        if ($id) {
            $user = User::findOrFail($id);
            $this->title = "Actualizar Usuario";
            $this->userRoles = $user->roles()->pluck('id')->toArray();
        } else {
            $this->title = "Crear Usuario";
            $this->enabledEdit = false;
        }

        $this->user = $user;

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->enabledEdit = true;
        }
    }
}
