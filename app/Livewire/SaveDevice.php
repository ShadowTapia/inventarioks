<?php

namespace App\Livewire;

use App\Models\department;
use App\Models\devices;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SaveDevice extends Component
{
    public $devices;
    public $numserie;
    public $fechacompra;
    public $comentarios;
    public $estado;
    public $department_id;
    public $products_id;
    public $product;

    public $title;
    public $msg = "";


    protected $rules = [
        'numserie' => 'required|min:3',
        'fechacompra' => 'date|nullable',
        'comentarios' => 'string|nullable',
        'estado' => 'required|in:1,2',
    ];


    public function mount($id)
    {
        $this->product = product::find($id);
        $this->products_id = $this->product->id;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $departments = department::all();
        return view('livewire.save-device', [
            'title' => $this->title,
            'departments' => $departments
        ]);
    }

    public function submit()
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
