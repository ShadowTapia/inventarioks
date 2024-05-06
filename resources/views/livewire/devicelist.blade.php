<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        <div class="flex flex-row mt-1">
                <div class="shrink w-45">
                    <x-input id="numserie" type="text" placeholder="Ingrese N° de Serie" name="numserie" wire:model.live="numserie" wire:keydown.enter="$refresh" class="mt-1"/>
                </div>
                <div class="items-center flex-initial pt-2 pl-2">
                    <x-secondary-button wire:click="cleanFilter" class="p-filter-button" tooltip="Filtrar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                          </svg>
                    </x-secondary-button>
                </div>
                <div class="content-end flex-auto w-32 right-3" style="padding-left: 60%">
                    <x-a-button id="printDeviceCodebar" title="Imprimir" href="{{ route('print.barraAll') }}" class="p-1 bg-sky-800 hover:bg-sky-600 focus:ring-offset-2 right-1 focus:ring-2 focus:ring-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                          </svg>
                        Imprimir
                    </x-a-button>
                </div>
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
                        <td class="w-40 p-3 border">Acción</td>
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
                            <td class="w-40 p-3 border">
                                <x-a-button id="editDevice" title="Editar Dispositivo" wire:click="confirmDeviEditItem({{ $dvs->id }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </x-a-button>
                                <x-a-button id="createCodeBar" title="Código de Barra" href="{{ route('print.barra',$dvs) }}"  class="mr-2 bg-yellow-800 p-sm-button hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                      </svg>
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
