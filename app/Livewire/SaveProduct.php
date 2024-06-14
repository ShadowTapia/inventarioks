<?php

namespace App\Livewire;

use App\Models\company;
use App\Models\products;
use App\Models\productype;
use App\Models\supplier;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SaveProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $modelo;
    public $url;
    public $productype_id;
    public $supplier_id;
    public $company_id;

    #[Rule('image|max:1024|nullable')] // 1MB Max
    public $file;

    public $title;
    public $msg = "";
    public $products;

    protected $rules = [
        'name' => 'required|min:3|max:50|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'description' => 'string|nullable|regex:/^([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z°,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'modelo' => 'nullable|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',

    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    /**
     * Botón submit
     */
    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $product = products::create([
                'name' => $this->name,
                'description' => $this->description,
                'modelo' => $this->modelo,
                'users_id' => auth()->id(), //Guardamos el id de usuario logueado
                'productype_id' => $this->productype_id,
                'supplier_id' => $this->supplier_id,
                'company_id' => $this->company_id,

            ]);

            $this->msg = "Producto creado con exito.!";
            DB::commit();


            if ($this->file) {
                $url = $this->file->store('public/products');
                $product->image()->create([
                    'url' => $url
                ]);
            }
            return redirect()->route('productslist')->with(['success' => $this->msg]);
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

    #[Layout('layouts.app')]
    public function render()
    {
        $productypes = productype::all();
        $suppliers = supplier::all();
        $companys = company::all();
        return view('livewire.save-product', [
            'title' => $this->title,
            'productypes' => $productypes,
            'suppliers' => $suppliers,
            'companys' => $companys
        ]);
    }

    public function init($id)
    {
        $products = null;

        if ($id) {
            $this->title = "Actualizar Producto";
            $products = products::findOrFail($id);
        } else {
            $this->title = "Crear Producto";
        }

        $this->products = $products;

        if ($this->products) {
            $this->name = $this->products->name;
            $this->description = $this->products->description;
            $this->modelo = $this->products->modelo;
            $this->url = $this->products->url;
        }
    }
}
