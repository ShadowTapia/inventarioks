<?php

namespace App\Livewire\Devices;

use App\Models\devices;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
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

final class DeviceTable extends PowerGridComponent
{
    use WithExport;


    //Creamos un listerner para refrescar la tabla desde un componente externo
    protected $listeners = [
        '$refresh'
    ];

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function header(): array
    {
        return [
            Button::add('print')
                ->render(function () {
                    return Blade::render(<<<HTML
                    @can('print.barraAll')
                        <x-a-button id="printDeviceCodebar" title="Todos los códigos" href="{{ route('print.barraAll') }}" class="p-1 bg-sky-800 hover:bg-sky-600 focus:ring-offset-2 right-1 focus:ring-2 focus:ring-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                            </svg>
                            Imprimir
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
        return devices::query()->with('product')->with('department');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('numserie')
            ->add('fechacompra_formatted', fn(devices $model) => Carbon::parse($model->fechacompra)->format('d/m/Y'))
            ->add('comentarios')
            //Ocupamos operador ternario para la siguiente declaración
            ->add('estado', fn($dev) => e(($dev->estado == '1') ? 'Activo' : (($dev->estado == '2') ? 'Inactivo' : 'De baja')))
            ->add('products_name', fn($devi) => e($devi->product->name))
            ->add('department_name', fn($dev) => e($dev->department->name))
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('N°', 'id')
                ->index()
                ->visibleInExport(visible: true)
                ->hidden(),
            Column::make('Serie', 'numserie')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('F. Compra', 'fechacompra_formatted', 'fechacompra')
                ->sortable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Comentarios', 'comentarios')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Estado', 'estado')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Producto', 'products_name')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Departamento', 'department_name')
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::action('Action')
                ->visibleInExport(visible: false)
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
        ];
    }

    public function filters(): array
    {
        $estado_array = [
            ['estado' => 1, 'name' => 'Activo'],
            ['estado' => 2, 'name' => 'Inactivo'],
            ['estado' => 3, 'name' => 'De baja'],
        ];
        return [
            Filter::select('name', 'estado')
                ->dataSource($estado_array)
                ->optionLabel('name')
                ->optionValue('estado'),

        ];
    }

    public function actions(devices $row): array
    {
        return [
            Button::add('edit')
                ->render(function ($dvs) {
                    return Blade::render(<<<HTML
                        @can('devi.edit')
                        <x-a-button id="editDevice" title="Editar Dispositivo" wire:click="dispatch('openModal',{component: 'DeviSalvar', arguments: {id: null , idDispo: {{ $dvs->id }} }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </x-a-button>
                        @endcan
                    HTML);
                }),
            //Se encarga de imprimir el código de barra del producto
            Button::add('print')
                ->render(function ($devi) {
                    return Blade::render(<<<HTML
                        @can('print.barra')
                            <x-a-button id="createCodeBar" title="Código de Barra" href="{{ route('print.barra',$devi->id) }}"  class="mr-2 bg-yellow-800 p-sm-button hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                </svg>
                            </x-a-button>
                        @endcan
                    HTML);
                })
        ];
    }

    /**
     * Reglas de validación condicionales
     */
    public function actionRules($row): array
    {
        return [
            Rule::rows() //indicamos que cuando el estado es igual a 2 la fila toma el color amber
                ->when(fn($dev) => $dev->estado === '2')
                ->setAttribute('class', 'bg-amber-400 hover:bg-amber-300'),
            Rule::rows() //Si el estado de la fila es 3 el color de ella sera rojo
                ->when(fn($dev) => $dev->estado === '3')
                ->setAttribute('class', 'bg-red-800 hover:bg-red-600'),
            Rule::button('print') //Deshabilitamos el boton imprimir código de barra cuando el estado del dispositivo sea de baja
                ->when(fn($dev) => $dev->estado === '3')
                ->bladeComponent('livewire-powergrid::icons.arrow', [
                    'class'   => 'w-5 h-5 !text-red-500',
                ]),
        ];
    }
}
