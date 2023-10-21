<?php

namespace App\Livewire;

use App\Models\company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SaveCompany extends Component
{
    public $name;
    public $description;
    public $url;
    public $email;
    public $phone;
    public $contact;

    public $title;
    public $msg = "";
    public $company;

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
        return view('livewire.save-company', ['title' => $this->title]);
    }

    /**
     *
     * Función Submit
     */
    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->company) {
                $this->company->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'url' => $this->url,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'contact' => $this->contact,
                ]);
                $this->msg = 'Compañía actualizada con exito!!';
            } else {
                $company = company::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'url' => $this->url,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'contact' => $this->contact,
                ]);
                $this->msg = 'Compañia creada con exito!!';
            }
            DB::commit();
            return redirect()->route('companies')->with(['success' => $this->msg]);
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
        $company = null;

        if ($id) {
            $this->title = "Actualizar Compañia";
            $company = company::findOrFail($id);
        } else {
            $this->title = "Crear Compañía";
        }

        $this->company = $company;

        if ($this->company) {
            $this->name = $this->company->name;
            $this->description = $this->company->description;
            $this->url = $this->company->url;
            $this->phone = $this->company->phone;
            $this->email = $this->company->email;
            $this->contact = $this->company->contact;
        }
    }
}
