<?php

namespace App\Livewire\Productos;

use App\Models\products;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ProductsTable extends PowerGridComponent
{
    use WithExport;

    //Creamos un listerner para refrescar la tabla desde un componente externo
    protected $listeners = [
        '$refresh'
    ];

    public function header(): array
    {
        return [
            Button::add('add') //Crear un producto
                ->render(function () {
                    return Blade::render(<<<HTML
                        @can('pro.create')
                            <x-a-button id="creaProducts" title="Crear Producto" href="{{ route('pro.create') }}" class="p-1 bg-green-800 hover:bg-green-600 focus:ring-offset-2 focus:ring-2 focus:ring-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                </svg> Crear
                            </x-a-button>
                        @endcan
                    HTML);
                }),
            Button::add('print') //Impresión de todos los productos
                ->render(function () {
                    return Blade::render(<<<HTML
                        @can('print.product')
                            <x-a-button id="printProducts" title="Imprimir Productos" href="{{ route('print.product')}}" class="p-1 bg-sky-800 hover:bg-sky-600 focus:ring-offset-2 right-1 focus:ring-2 focus:ring-sky-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg> Imprimir
                            </x-a-button>
                        @endcan
                    HTML);
                })
        ];
    }

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(mode: 'short'),
        ];
    }

    public function datasource(): Builder
    {
        return products::query()->with('productypes')->with('suppliers')->with('companies');
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
            ->add('modelo')
            ->add('users_id')
            ->add('productype_id')
            ->add('tipo_name', fn($pro) => e($pro->productypes->name))
            ->add('supplier_id')
            ->add('proveedor_name', fn($proo) => e($proo->suppliers->name))
            ->add('company_id')
            ->add('empresa_name', fn($com) => e($com->companies->name))
            ->add('avatar', fn($item) => '<img class="w-8 h-8 rounded-full shrink-0 grow-0" src="' .  Storage::url($item->image->url) . '">' ?? 'nIEG')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->hidden(),
            Column::make('Nombre', 'name')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
                ->contentClasses('text-wrap text-balance'),

            Column::make('Modelo', 'modelo')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Tipo Producto', 'tipo_name')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),
            Column::make('Proveedor', 'proveedor_name')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),
            Column::make('Empresa', 'empresa_name')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),
            Column::make('Foto', 'avatar')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),
            Column::action('Acciones')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actionRules(): array
    {
        return [];
    }

    public function actions(products $row): array
    {
        return [
            Button::add('add')
                ->render(function ($pro) {
                    return Blade::render(<<<HTML
                        @can('devi.create')
                            <x-a-button id="addDevice" title="Agregar Dispositivo" wire:click="dispatch('openModal',{component: 'DeviSalvar', arguments: {id: {{ $pro->id }} }})"  class="mr-2 p-sm-button bg-lime-800 hover:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                                </svg>
                            </x-a-button>
                        @endcan
                    HTML);
                }),
            Button::add('edit')
                ->render(function ($pro) {
                    return Blade::render(<<<HTML
                        @can('pro.edit')
                        <x-a-button id="editProduct" title="Editar Producto" href="{{ route('pro.edit',$pro->id) }}" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </x-a-button>
                        @endcan
                    HTML);
                })
        ];
    }
}
