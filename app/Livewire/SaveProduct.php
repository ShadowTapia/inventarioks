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
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

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

    #[Validate('image|max:1024|nullable')] // 1MB Max
    public $file;

    public $enableEdit = false; //Se encargará de mostrar el ingreso de fotos para los productos

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
            //Crear codigo para actualizar el producto
            if ($this->products) {
                $this->products->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'modelo' => $this->modelo,
                    'productype_id' => $this->productype_id,
                    'supplier_id' => $this->supplier_id,
                    'company_id' => $this->company_id,
                ]);
                $this->msg = "Producto actualizado con exito.!";
            } else {
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

                if ($this->file) {
                    $url = $this->file->store('public/products');
                    $product->image()->create([
                        'url' => $url
                    ]);
                } else {
                    $url = "products/no_photo.png";
                    $product->image()->create([
                        'url' => $url
                    ]);
                }
            }
            DB::commit();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => $this->msg,
            ]);
            return redirect()->route('productslist');
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

    #[Layout('layouts.app')]
    public function render()
    {
        $productypes = productype::all();
        $suppliers = supplier::all();
        $companys = company::all();
        return view('livewire.save-product', [
            'title' => $this->title,
            'enableEdit' => $this->enableEdit,
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
            $this->enableEdit = false;
        } else {
            $this->title = "Crear Producto";
            $this->enableEdit = true;
        }

        $this->products = $products;

        if ($this->products) {
            $this->name = $this->products->name;
            $this->description = $this->products->description;
            $this->modelo = $this->products->modelo;
            $this->url = $this->products->url;
            $this->productype_id = $this->products->productype_id;
            $this->supplier_id = $this->products->supplier_id;
            $this->company_id = $this->products->company_id;
        }
    }
}
