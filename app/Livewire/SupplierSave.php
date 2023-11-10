<?php

namespace App\Livewire;

use App\Models\supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SupplierSave extends Component
{
    public $name;
    public $address;
    public $phone;
    public $contact;
    public $email;

    public $title;
    public $msg = "";
    public $supplier;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'email|nullable',
        'contact' => 'string|nullable',
    ];

    public function mount($id = null)
    {
        $this->init($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.supplier-save', ['title' => $this->title]);
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->supplier) {
                $this->supplier->update([
                    'name' => $this->name,
                    'address' => $this->address,
                    'contact' => $this->contact,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ]);
                $this->msg = 'Proveedor actualizado con exito!!';
            } else {
                $supplier = supplier::create([
                    'name' => $this->name,
                    'address' => $this->address,
                    'contact' => $this->contact,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ]);
                $this->msg = 'Proveedor creado con exito!!';
            }
            DB::commit();
            return redirect()->route('suppliers')->with(['success' => $this->msg]);
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
        $supplier = null;

        if ($id) {
            $this->title = "Actualizar Proveedor";
            $supplier = supplier::findOrFail($id);
        } else {
            $this->title = "Crear Proveedor";
        }

        $this->supplier = $supplier;

        if ($this->supplier) {
            $this->name = $this->supplier->name;
            $this->address = $this->supplier->address;
            $this->contact = $this->supplier->contact;
            $this->email = $this->supplier->email;
            $this->phone = $this->supplier->phone;
        }
    }
}
