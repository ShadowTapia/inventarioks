<?php

namespace App\Livewire\Tipos;

use App\Models\productype;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;


final class ProdtypeTable extends PowerGridComponent
{

    //Creamos un listerner para refrescar la tabla desde un componente externo
    protected $listeners = [
        '$refresh'
    ];

    public function header(): array
    {
        return [
            Button::add('add')
                ->render(function () {
                    return Blade::render(<<<HTML
                    @can('protype.create')
                        <x-a-button id="createProductype" title="Crear Tipo de Producto" wire:click="dispatch('openModal',{component:'SaveProductype'})" class="p-1 bg-green-800 hover:bg-green-600 focus:ring-offset-2 focus:ring-2 focus:ring-green-600">
                            Crear
                        </x-a-button>
                    @endcan
                  HTML);
                }),
        ];
    }

    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(mode: 'short'),
        ];
    }

    public function datasource(): Builder
    {
        return productype::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('created_at_formatted', fn(productype $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('N°', 'id')->index()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),
            Column::make('Nombre', 'name')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700  text-white text-center text-sm')
                ->contentClasses('text-wrap text-balance'),

            Column::make('Creado en', 'created_at_formatted', 'created_at')
                ->sortable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::action('Acciones')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($key): void
    {
        //Abrimos el JS para que se active el msg vía SweetAlert
        $this->js('
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No se podrá revertir este proceso!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatchSelf("deletePtype", {ptype: ' . $key . '});
                }
            })
        ');
    }

    #[On('deletePtype')]
    public function deletePtype(productype $ptype)
    {
        $products = $ptype->products()->count();
        if ($products > 0) {

            $this->dispatch('alert', [
                'type' => 'warning',
                'message' => "Existen productos asociados a estos tipo de productos.-",
            ]);
        } else {
            $ptype->deleteOrFail();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Tipo Producto borrado existosamente!!",
            ]);
            $this->fillData();
        }
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(productype $row): array
    {
        return [
            Button::add('edit')
                ->render(function ($ptype) {
                    return Blade::render(<<<HTML
                        @can('protype.edit')
                            <x-a-button id="editsupp" title="Editar tipo Producto" wire:click="dispatch('openModal',{component:'SaveProductype',arguments: { id: {{ $ptype->id }} }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </x-a-button>
                        @endcan
                    HTML);
                }),
            Button::add('delete')
                ->render(function ($ptype) {
                    return Blade::render(<<<HTML
                    @can('protype.destroy')
                        <x-danger-button id="delsupp" title="Eliminar tipo Producto" wire:click="delete({{ $ptype->id }})" wire:loading.attr="disabled" class="p-sm-button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                            </svg>
                        </x-danger-button>
                    @endcan
                HTML);
                })
        ];
    }
}
