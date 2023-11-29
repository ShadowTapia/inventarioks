<?php

namespace App\Livewire;

use App\Models\department;
use App\Models\devices;
use App\Models\product;
use Livewire\Attributes\Layout;
use App\Models\products;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $products_id;

    public $title;
    public $msg = "";
    public $confirmingDeviItemAdd = false;

    public $product;

    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'numserie' => 'required|min:3',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable',
        'estado' => 'required|in:1,2',
    ];

    public function mount()
    {
        $this->title = "Listado de Productos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $prtlist = products::paginate(10);
        $departments = department::all();

        return view('livewire.products-list', [
            'prtlist' => $prtlist,
            'departments' => $departments,
            'title' => $this->title
        ]);
    }

    public function confirmDeviAddItem(product $pro)
    {
        $this->reset();
        $this->product = $pro;
        if ($this->product) {
            $this->products_id = $this->product->id;
        }
        $this->confirmingDeviItemAdd = true;
    }

    /**
     * Se encarga de grabar el dispositivo
     */
    public function saveDevi()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $devices = devices::create([
                'numserie' => $this->numserie,
                'fechacompra' => date('y-m-d', strtotime($this->fechacompra)),
                'comentarios' => $this->comentarios,
                'estado' => $this->estado,
                'department_id' => $this->department_id,
                'products_id' => $this->products_id,
            ]);
            $this->msg = "Dispositivo creado con exito.!";
            DB::commit();
            return redirect()->route('productslist')->with(['success' => $this->msg]);
        } catch (ValidationException  $e) {
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
