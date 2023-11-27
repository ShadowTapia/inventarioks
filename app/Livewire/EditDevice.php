<?php

namespace App\Livewire;

use App\Models\department;
use App\Models\devices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;


class EditDevice extends Component
{
    public $devices;
    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $products_id;

    public $title;
    public $msg = '';

    protected $rules = [
        'numserie' => 'required|min:3',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable',
        'estado' => 'required|in:1,2',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $departments = department::all();
        return view('livewire.edit-device', [
            'title' => $this->title,
            'departments' => $departments,
        ]);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->devices) {
                $this->devices->update([
                    'numserie' => $this->numserie,
                    'fechacompra' => date('y-m-d', strtotime($this->fechacompra)),
                    'comentarios' => $this->comentarios,
                    'estado' => $this->estado,
                    'department_id' => $this->department_id,
                ]);
                $this->msg = "Dispositivo editado con exito.!";
                DB::commit();
                return redirect()->route('devicelist')->with(['success' => $this->msg]);
            }
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
        $devices = null;

        if ($id) {
            $this->title = "Actualizar Dispositivo";
            $devices = devices::findOrFail($id);
        }

        $this->devices = $devices;
        if ($this->devices) {
            $this->numserie = $this->devices->numserie;
            $this->fechacompra = $this->devices->fechacompra;
            $this->comentarios = $this->devices->comentarios;
            $this->estado = $this->devices->estado;
            $this->department_id = $this->devices->department_id;
        }
    }
}
