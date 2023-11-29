<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        <div class="flex mt-1">
            <div>
                <x-input id="numserie" type="text" placeholder="Ingrese N° de Serie" name="numserie" wire:model.live="numserie" wire:keydown.enter="$refresh" class="mt-1"/>

            </div>
            <x-secondary-button wire:click="cleanFilter" class="ml-2 p-filter-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                  </svg>
            </x-secondary-button>
        </div>

        @if ($devices->count())
            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        <td class="p-3 border">ID</td>
                        <td class="p-3 border">Serie</td>
                        <td class="p-3 border">F. Compra</td>
                        <td class="p-3 border">Comentarios</td>
                        <td class="p-3 border">Estado</td>
                        <td class="p-3 border">Producto</td>
                        <td class="p-3 border">Departamento</td>
                        <td class="p-3 border">Acción</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $dvs)
                        <tr>
                            <td class="p-3 border">{{ $dvs->id }}</td>
                            <td class="p-3 border">{{ $dvs->numserie }}</td>
                            <td class="p-3 border">{{ \Carbon\Carbon::parse($dvs->fechacompra)->format('d/m/Y') }}</td>
                            <td class="p-3 border">{{ $dvs->comentarios }}</td>
                            <td class="p-3 border">{{ $dvs->estado == '1' ? 'Activo':'inactivo' }}</td>
                            <td class="p-3 border">{{ $dvs->product->name }}</td>
                            <td class="p-3 border">{{ $dvs->department->name }}</td>
                            <td class="p-3 border">
                                <x-a-button id="editDevice" title="Editar Dispositivo" wire:click="confirmDeviEditItem({{ $dvs->id }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </x-a-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="card-body">
                <strong>No existen registros</strong>
            </div>
        @endif
        <br>
        <div class="card-footer">
            {{ $devices->links() }}
        </div>
        {{-- Editar dispositivo Modal --}}
        <x-dialog-modal id="ModalEditDevi" wire:model.live="confirmingDeviItemEdit">
            <x-slot name="title">
                {{ __('Editar Dispositivo') }}
            </x-slot>
            <x-slot name="content">
                {{-- N° de serie --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="numserie" value="{{ __('N° Serie') }}"></x-label>
                    <x-bladewind.input id="numserie" wire:model="numserie" readonly="true" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="numserie" class="mt-2"></x-input-error>
                </div>
                {{-- fecha compra --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="fechacompra" value="{{ __('Fecha Compra') }}"></x-label>
                    {{-- Inicio datepicker --}}
                    <x-input.date wire:model.defer="fechacompra" id="fechacompra" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    {{-- Fin datepicker --}}
                    <x-input-error for="fechacompra" class="mt-2"></x-input-error>
                </div>
                {{-- comentarios --}}
                <div class="colspan-3 sm:col-span-4">
                    <x-label for="comentarios" value="{{ __('Comentarios') }}"></x-label>
                    <x-bladewind.textarea id="comentarios" wire:model.lazy="comentarios" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="comentarios" class="mt-2"></x-input-error>
                </div>
                {{-- estado --}}
                <div class="colspan-3 sm:col-span-4">
                    <label>
                        <x-input type="radio" wire:model="estado" value="1"/> Activo
                    </label>
                    <label>
                        <x-input type="radio" wire:model="estado" value="2"/> No Activo
                    </label>
                </div>
                {{-- Departmento --}}
                <div class="colspan-3 sm:col-span-4">
                    <x-label for="department" value="{{ __('Departamento') }}"></x-label>
                    <select id="department_id" wire:model="department_id" class="form-control">
                        <option value="">Seleccione un Departamento</option>
                        @if ($departments->count())
                            @foreach ($departments as $depa )
                                <option value="{{ $depa->id }}">
                                    {{ $depa->name }}
                                </option>
                            @endforeach
                        @else
                                No existen registros
                        @endif
                    </select>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button  wire:click="editDevi()"  wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="$toggle('confirmingDeviItemEdit',false)"  wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-fondo-card>
