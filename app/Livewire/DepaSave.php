<?php

namespace App\Livewire;

use App\Livewire\Department\DepaTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\department;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use LivewireUI\Modal\ModalComponent;

class DepaSave extends ModalComponent
{
    public $name;
    public $description;
    public $responsible;

    public $msg = "";
    public $title;
    public $department;

    protected $rules = [
        'name' => 'required|min:3|max:50|string',
        'description' => 'string|nullable|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'responsible' => 'string|nullable|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.depa-save', ['title' => $this->title]);
    }

    public function submit()
    {
        //TODO validar
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->department) {
                $this->department->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'responsible' => $this->responsible,
                ]);
                $this->msg = 'Departamento actualizado con exito!!';
            } else {
                $department = department::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'responsible' => $this->responsible,
                ]);
                $this->msg = "Departamento creado con exito!!";
            }
            DB::commit();
            $this->resetFields();
            $this->closeModal();
            $this->dispatch('$refresh')->to(DepaTable::class);
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

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->responsible = '';
        $this->resetValidation();
    }

    public function init($id)
    {
        $department = null;

        if ($id) {
            $this->title = "Actualizar Departamento";
            $department = department::findOrFail($id);
        } else {
            $this->title = "Crear Departamento";
        }

        $this->department = $department;

        if ($this->department) {
            $this->name = $this->department->name;
            $this->description = $this->department->description;
            $this->responsible = $this->department->responsible;
        }
    }
}
