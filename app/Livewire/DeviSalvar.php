<?php

namespace App\Livewire;

use App\Livewire\Productos\ProductsTable;
use App\Models\department;
use App\Models\devices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class DeviSalvar extends ModalComponent
{

    //variables para ingresar dispositivo
    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $products_id;
    public $numSerial;

    public $title;
    public $msg;

    /**
     * Definimos las reglas del modelo
     */
    protected $rules = [
        'numserie' => 'required|unique:devices|min:2|max:255|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable|regex:/^([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'estado' => 'required|min:1|max:2|in:1,2',
        'products_id' => 'required|min:1|max:99999999',
        'department_id' => 'required|min:1|max:99999999',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    public function render()
    {
        $departments = department::all();
        return view('livewire.devi-salvar', ['departments' => $departments, 'title' => $this->title]);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $device = devices::create([
                'numserie' => $this->numserie,
                'fechacompra' => date('y-m-d', strtotime($this->fechacompra)),
                'comentarios' => $this->comentarios,
                'estado' => $this->estado,
                'products_id' => $this->products_id,
                'department_id' => $this->department_id
            ]);
            DB::commit();
            $this->resetFields();
            $this->closeModal();
            $this->dispatch('$refresh')->to(ProductsTable::class);
            $this->msg = "Dispositivo creado con exito!";
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

    public function resetFields()
    {
        $this->numserie = '';
        $this->fechacompra = '';
        $this->comentarios = '';
        $this->estado = '';
        $this->products_id = '';
        $this->department_id = '';
        $this->resetValidation();
    }

    public function init($id)
    {
        if ($id) {
            $this->title = "Ingresar dispositivo";
            $this->products_id = $id;
        }
    }
}
