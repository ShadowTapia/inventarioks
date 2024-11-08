<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSave extends Component
{
    public $name;
    public $title;
    public $msg = "";
    public $rol;

    public array $userPermissions;

    protected $rules = [
        'name' => 'required|min:3',
        'userPermissions.*' => 'exists:permissions,id',
    ];

    public function mount($id = null)
    {
        $this->init($id);
        /** \App\User */
        $user = auth()->user();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.role-save', ['title' => $this->title])
            ->withPermissions(
                cache()->remember('permissions', 60, function () {
                    return Permission::all()->sortBy('order');
                })
            );
    }

    public function submit()
    {
        //TODO validar
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->rol) {
                $this->rol->update([
                    'name' => $this->name,
                ]);
                $this->rol->permissions()->sync($this->userPermissions);
                $this->msg = 'Rol actualizado con exito!!';
            } else {
                $role = Role::create([
                    'name' => $this->name,
                ]);
                $role->permissions()->sync($this->userPermissions);
                $this->msg = "Rol creado con exito!!";
            }
            DB::commit();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => $this->msg,
            ]);
            return redirect()->route('roles');
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
            return redirect()->back();
        }
    }
    /**
     *
     */
    public function init($id)
    {
        $rol = null;

        if ($id) {
            $this->title = "Actualizar Rol";
            $rol = Role::findOrFail($id);
            $this->userPermissions = $rol->permissions()->pluck('id')->toArray();
        } else {
            $this->title = "Crear Rol";
        }

        $this->rol = $rol;

        if ($this->rol) {
            $this->name = $this->rol->name;
        }
    }
}
