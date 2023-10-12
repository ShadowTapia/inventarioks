<?php

namespace App\Livewire;

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
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.role-save', ['title' => $this->title])
            ->withPermissions(
                cache()->remember('permissions', 60, function () {
                    return Permission::all();
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
            return redirect()->route('roles')->with(['success' => $this->msg]);
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->msg = "Error, ¡favor de intentar mas tarde!";
            return redirect()->back()->with(['error' => $this->msg]);
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
