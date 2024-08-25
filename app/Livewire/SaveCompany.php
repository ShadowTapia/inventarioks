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
        'name' => 'required|min:3|max:70|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'description' => 'nullable|string',
        'url' => 'url|nullable',
        'phone' => 'nullable',
        'email' => 'nullable|email',
        'contact' => 'string|nullable|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
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
            $this->js('
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                        icon: "success",
                        title: " ' . $this->msg . ' "
                });
            ');
            return redirect()->route('companies');
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->js('
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                        icon: "error",
                        title: " ' . $message . ' "
                });
            ');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->js('
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                        icon: "error",
                        title: " ' . $message . ' "
                });
            ');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $message = "Error, " . $e->getMessage() . ".¡Favor de informar al Administrador!";
            throw $e;
            $this->js('
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                        icon: "error",
                        title: " ' . $message . ' "
                });
            ');
            return redirect()->back();
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
