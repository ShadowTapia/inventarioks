<?php

namespace App\Livewire;

use App\Models\department as ModelsDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Department extends Component
{
    use WithPagination;

    //Campos del formulario
    public $name;
    public $description;
    public $responsible;

    public $title;
    public $msg = "";

    public $confirmingDepaDeletion = false;
    public $confirmingDepaItemAdd = false;

    public $department;

    protected $paginationTheme = "bootstrap"; //Importante para tener un estilo distinto para la paginación

    protected $rules = [
        'name' => 'required|min:3|string',
        'description' => 'string|nullable',
        'responsible' => 'regex:/^[\pL\s\-]+$/u|string|nullable',
    ];

    public function mount()
    {
        $this->title = "Lista de Departamentos";
    }

    #[Layout('layouts.app')]
    public function render()
    {

        $depas = ModelsDepartment::paginate(10);
        return view('livewire.department', ['depas' => $depas, 'title' => $this->title]);
    }

    /**
     * Se encarga de borrar un departamento
     */
    public function delDepa(ModelsDepartment $depa)
    {
        $device = $depa->devices()->count(); //Verificamos que no existan dispositivos asociados al departamento
        if ($device > 0) {
            $this->confirmingDepaDeletion = false;
            return redirect()->back()->with(['error' => 'Existen dispositivos asociados a este departamento.-']);
        } else {
            $depa->deleteOrFail();
            $this->confirmingDepaDeletion = false;
            return redirect()->back()->with(['success' => 'Departamento borrado correctamente.-']);
        }
    }

    public function confirmDepaDeletion($id)
    {
        $this->confirmingDepaDeletion = $id;
    }

    public function confirmDepaAddItem()
    {
        $this->reset();
        $this->confirmingDepaItemAdd = true;
    }

    public function confirmDepaEditItem(ModelsDepartment $depa)
    {
        $this->department = $depa;
        if ($this->department) {
            $this->name = $this->department->name;
            $this->description = $this->department->description;
            $this->responsible = $this->department->responsible;
        }
        $this->confirmingDepaItemAdd = true;
    }

    /**
     * Se encarga de guardar los datos de Departamentos
     */
    public function saveDepa()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->department) {
                $this->department->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'responsible' => $this->responsible,
                ]);
                $this->msg = "Departamento actualizado con exito!!";
            } else {
                $department = ModelsDepartment::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'responsible' => $this->responsible,
                ]);
                $this->msg = "Departamento creado con exito!!";
            }
            DB::commit();
            $this->confirmingDepaItemAdd = false;
            return redirect()->back()->with(['success' => $this->msg]);
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
