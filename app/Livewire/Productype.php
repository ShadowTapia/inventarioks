<?php

namespace App\Livewire;

use App\Models\productype as ModelsProductype;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Productype extends Component
{
    use WithPagination;

    public $name;
    public $description;

    public $title;
    public $msg = "";

    public $confirmingProtypeDeletion = false;
    public $confirmingProtypeItemAdd = false;

    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'name' => 'required|string|min:3',
        'description' => 'string|nullable',
    ];

    public function mount()
    {
        $this->title = 'Listado de Tipos de Productos';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $productypes = ModelsProductype::paginate(10);
        return view('livewire.productype', ['productypes' => $productypes, 'title' => $this->title]);
    }

    /**
     * Se encarga de borrar el tipo de producto
     */
    public function delProtype(ModelsProductype $protype)
    {
        $products = $protype->products()->count();
        if ($products > 0) {
            $this->confirmingProtypeDeletion = false;
            return redirect()->back()->with(['error' => 'Existen productos asociados a este tipo de producto.-']);
        } else {
            $protype->deleteOrFail();
            $this->confirmingProtypeDeletion = false;
            return redirect()->back()->with(['success' => 'Tipo de producto borrado existosamente.-']);
        }
    }

    public function confirmProtypeDeletion($id)
    {
        $this->confirmingProtypeDeletion = $id;
    }

    public function confirmProtypeaddItem()
    {
        $this->reset();
        $this->confirmingProtypeItemAdd = true;
    }

    /**
     * Encargado de guardar los tipos de productos
     */
    public function savePrtype()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $productype = ModelsProductype::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            DB::commit();
            $this->msg = "Tipo de producto creado con exito!!";
            $this->confirmingProtypeItemAdd = false;
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
