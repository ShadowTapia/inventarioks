<?php

namespace App\Livewire\Permisos;

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



final class PermisosTable extends PowerGridComponent
{
    public array $orden;
    public bool $deferLoading = true;

    public function setUp(): array
    {

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
            'orden.*' => ['integer', 'nullable'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'orden.*' => 'Orden del Permiso',
        ];
    }

    protected function messages()
    {
        return [
            'orden.*' => 'Sólo se aceptan valores númericos',
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
            Column::make('N°', 'id')->index()->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Id', 'id')->hidden(),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Guardia', 'guard_name')->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Orden', 'orden')
                ->sortable()
                ->editOnClick(hasPermission: true)
                ->searchable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm'),

            Column::make('Creado en', 'created_at_formatted', 'created_at')
                ->sortable()
                ->headerAttribute('bg-sky-700 text-white text-center text-sm')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    /**
     * Función que se encarga de editar la columna orden
     */
    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        $this->validate();

        $updated = permissions::query()->find($id)->update([
            $field => e($value),
        ]);

        if ($updated) {
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
                        title: "¡Actualización exitosa!"
                });
            ');
            $this->fillData();
        } else {
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
                        title: "No se pudo editar el valor.-"
                });
            ');
        }
    }
}
