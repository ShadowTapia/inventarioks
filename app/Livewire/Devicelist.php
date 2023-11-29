<?php

namespace App\Livewire;

use App\Models\department;
use App\Models\devices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Devicelist extends Component
{
    use WithPagination;

    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $device;

    public $confirmingDeviItemEdit = false;

    public $title;
    public $msg = "";

    public $sortColumn = "id";
    public $sortDirection = "asc";

    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'numserie' => 'required|min:3',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable',
        'estado' => 'required|in:1,2',
    ];

    protected $queryString = ['numserie'];

    public function mount()
    {
        $this->title = "Listado de Dispositivos";
    }

    public function updatingNumserie()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $devices = devices::orderBy($this->sortColumn, $this->sortDirection);

        if ($this->numserie) {
            $devices->where('numserie', 'like', '%' . $this->numserie . '%');
        }

        $devices = $devices->paginate(10);
        $departments = department::all();

        return view('livewire.devicelist', [
            'title' => $this->title,
            'devices' => $devices,
            'departments' => $departments,
        ]);
    }

    public function cleanFilter()
    {
        $this->numserie = "";
    }

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }


    public function confirmDeviEditItem(devices $devi)
    {
        $this->device = $devi;
        if ($this->device) {
            $this->numserie = $this->device->numserie;
            $this->fechacompra = $this->device->fechacompra;
            $this->comentarios = $this->device->comentarios;
            $this->estado = $this->device->estado;
            $this->department_id = $this->device->department_id;
        }
        $this->confirmingDeviItemEdit = true;
    }

    /**
     * Se encarga de editar un dispositivo
     */
    public function editDevi()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if ($this->device) {
                $this->device->update([
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
}
