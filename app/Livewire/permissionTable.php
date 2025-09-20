<?php

namespace App\Livewire;

use App\Models\permissions;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

class permissionTable extends PowerGridComponent
{

    public array $order;
    public bool $deferLoading = true;

    public function setUp(): array
    {
        //$this->showCheckBox();

        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage(perPage: 50)
                ->showRecordCount(mode: 'short'),
        ];
    }

    public function datasource(): ?Builder
    {
        return DB::table('permissions')->orderBy('orden');
    }

    protected function rules()
    {
        return [
            'orden' => ['integer', 'nullable'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'orden' => 'Orden del Permiso',
        ];
    }

    protected function messages()
    {
        return [
            'orden' => 'Sólo se aceptan valores númericos',
        ];
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('description')
            ->add('guard_name')
            ->add('orden')
            ->add('created_at_formatted', fn($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('N°', 'id')->index(),

            Column::make('Id', 'id')->hidden(),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Guardia', 'guard_name'),

            Column::make('Orden', 'orden')
                ->sortable()
                ->editOnClick(hasPermission: true)
                ->searchable(),

            Column::make('Creado en', 'created_at_formatted', 'created_at')
                ->sortable()
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        //$this->validate();

        $updated = permissions::query()->find($id)->update([
            $field => e($value),
        ]);

        if ($updated) {
            $this->fillData();
        }
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(permissions $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    //                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
    //                                 </svg> ')
    //             ->id()
    //             ->class('mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

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
