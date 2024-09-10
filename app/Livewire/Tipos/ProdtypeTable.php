<?php

namespace App\Livewire\Tipos;

use App\Models\productype;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

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
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Creado en', 'created_at_formatted', 'created_at')
                ->sortable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::action('Acciones')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
        ];
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
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
