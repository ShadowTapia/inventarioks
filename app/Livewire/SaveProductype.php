<?php

namespace App\Livewire;

use App\Livewire\Tipos\ProdtypeTable;
use App\Models\productype;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use LivewireUI\Modal\ModalComponent;

class SaveProductype extends ModalComponent
{
    public $name;
    public $description;

    public $title;
    public $msg = "";
    public $productype;

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.save-productype', ['title' => $this->title]);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->productype) {
                $this->productype->update([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
                $this->msg = "Tipo producto actualizado correctamente!";
            } else {
                $productype = productype::create([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
                $this->msg = "Tipo de producto creado con exito!!";
            }
            DB::commit();
            $this->resetFields();
            $this->closeModal();
            $this->dispatch('$refresh')->to(ProdtypeTable::class);
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
     * Se encarga de resetear los campos
     */
    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->resetValidation();
    }

    public function init($id)
    {
        $productype = null;

        if ($id) {
            $this->title = "Actualizar Tipo de Productos";
            $productype = productype::findOrFail($id);
        } else {
            $this->title = "Crear Tipo de Productos";
        }

        $this->productype = $productype;

        if ($this->productype) {
            $this->name = $this->productype->name;
            $this->description = $this->productype->description;
        }
    }
}
