<?php

namespace App\Livewire;

use App\Livewire\Devices\DeviceTable;
use App\Models\department;
use App\Models\devices;
use Carbon\Carbon;
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

    public $enableEdit = false; //Se encarga de habilitar el item de Baja de dispositivo

    public $title;
    public $msg;
    public $dispositivo;

    /**
     * Definimos las reglas del modelo
     */
    protected $rules = [
        'numserie' => 'min:2|max:255|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable|regex:/^([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'estado' => 'required|min:1|max:2|in:1,2,3',
        'products_id' => 'required|min:1|max:99999999',
        'department_id' => 'required|min:1|max:99999999',
    ];

    public function mount($id = null, $idDispo = null) //editar permite actualizar los dispositivos
    {
        $this->init($id, $idDispo);
    }

    public function render()
    {
        $departments = department::all();
        return view('livewire.devi-salvar', ['departments' => $departments, 'title' => $this->title, 'enableEdit' => $this->enableEdit]);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction(); //Se inicia la transacción
        try {
            if ($this->dispositivo) {
                $this->dispositivo->update([
                    'numserie' => $this->numserie,
                    'fechacompra' => Carbon::parse($this->fechacompra)->format('y-m-d'),
                    'comentarios' => $this->comentarios,
                    'estado' => $this->estado,
                    'products_id' => $this->products_id,
                    'department_id' => $this->department_id
                ]);
                $this->msg = "Dispositivo actualizado con exito!";
            } else {
                $device = devices::create([
                    'numserie' => $this->numserie,
                    'fechacompra' => date('y-m-d', strtotime($this->fechacompra)),
                    'comentarios' => $this->comentarios,
                    'estado' => $this->estado,
                    'products_id' => $this->products_id,
                    'department_id' => $this->department_id
                ]);
                $this->msg = "Dispositivo creado con exito!";
            }
            DB::commit();
            //Limpiamos los campos llenos
            $this->resetFields();
            //Cerramos el modal
            $this->closeModal();
            //Actualizamos la tabla de dispositivos
            $this->dispatch('$refresh')->to(DeviceTable::class);
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

    /**
     * Procedimiento inicial, distribuye segun si existe o no el dispositivo
     */
    public function init($id, $idDevice)
    {
        $dispositivo = null;

        if ($idDevice == null) {
            $this->title = "Ingresar dispositivo";
            if ($id) {
                $this->products_id = $id;
            }
        } else {
            $this->title = "Actualizar dispositivo";
            $dispositivo = devices::findOrFail($idDevice);
        }

        $this->dispositivo = $dispositivo;

        if ($this->dispositivo) {
            $this->numserie = $this->dispositivo->numserie;
            $this->fechacompra = Carbon::parse($this->dispositivo->fechacompra)->format('d-m-Y');
            $this->comentarios = $this->dispositivo->comentarios;
            $this->estado = $this->dispositivo->estado;
            $this->products_id = $this->dispositivo->products_id;
            $this->department_id = $this->dispositivo->department_id;
            $this->enableEdit = true;
        }
    }
}
