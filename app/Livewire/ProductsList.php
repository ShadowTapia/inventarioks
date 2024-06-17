<?php

namespace App\Livewire;

use App\Models\company;
use App\Models\department;
use App\Models\devices;
use App\Models\product;
use Livewire\Attributes\Layout;
use App\Models\products;
use App\Models\productype;
use App\Models\supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    //variables para ingresar dispositivo
    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $products_id;
    public $numSerial;

    //variables para editar producto
    public $name;
    public $description;
    public $modelo;
    public $productype_id;
    public $supplier_id;
    public $company_id;

    public $title;
    public $msg = "";
    public $confirmingDeviItemAdd = false;
    public $confirmingProductItemEdit = false;

    public $product;

    protected $paginationTheme = "bootstrap";

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

    public function mount()
    {
        $this->title = "Listado de Productos";
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $prtlist = products::paginate(50);
        $departments = department::all();
        $productypes = productype::all();
        $suppliers = supplier::all();
        $companys = company::all();

        return view('livewire.products-list', [
            'prtlist' => $prtlist,
            'departments' => $departments,
            'productypes' => $productypes,
            'suppliers' => $suppliers,
            'companys' => $companys,
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
     * Encargado de llenar el form de edición de producto
     */
    public function confirmProduEditItem(product $pro)
    {
        $this->product = $pro; //Recibimos el producto a editar
        if ($this->product) {
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->modelo = $this->product->modelo;
            $this->productype_id = $this->product->productype_id;
            $this->supplier_id = $this->product->supplier_id;
            $this->company_id = $this->product->company_id;
            $this->products_id = $this->product->id; //Asignamos a la variable id el id del producto recibido
        }
        $this->confirmingProductItemEdit = true;
    }

    /**
     * Se encarga de editar un producto
     */
    public function editProduct()
    {
        DB::beginTransaction();
        try {
            if ($this->product) {
                $this->product->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'modelo' => $this->modelo,
                    'productype_id' => $this->productype_id,
                    'supplier_id' => $this->supplier_id,
                    'company_id' => $this->company_id,
                ]);
                $this->msg = "Producto editado con exito.!";
                DB::commit();
                return redirect()->route('productslist')->with(['success' => $this->msg]);
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
