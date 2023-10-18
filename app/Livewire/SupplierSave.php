<?php

namespace App\Livewire;

use App\Models\supplier;
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
        'email' => 'email',
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
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->msg = "Error, ¡favor de intentar mas tarde!";
            return redirect()->back()->with(['error' => $this->msg]);
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
