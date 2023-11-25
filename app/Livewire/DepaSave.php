<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\department;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DepaSave extends Component
{
    public $name;
    public $description;
    public $responsible;

    public $msg = "";
    public $title;
    public $department;

    protected $rules = [
        'name' => 'required|min:3',
        'responsible' => 'regex:/^[\pL\s\-]+$/u',
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
            return redirect()->route('departamentos')->with(['success' => $this->msg]);
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
