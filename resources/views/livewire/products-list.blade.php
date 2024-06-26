<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        <div class="flex flex-row mt-1">
            <div>
                @can('pro.create')
                    <x-a-button id="creaProducts" title="Crear Producto" href="{{ route('pro.create') }}" class="p-1 bg-green-800 hover:bg-green-600 focus:ring-offset-2 focus:ring-2 focus:ring-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg> Crear
                    </x-a-button>
                @endcan

            </div>
            <div class="content-end flex-auto w-32 right-3" style="padding-left: 60%">
                @can('print.product')
                    <x-a-button id="printProducts" title="Imprimir Productos" href="{{ route('print.product')}}" class="p-1 bg-sky-800 hover:bg-sky-600 focus:ring-offset-2 right-1 focus:ring-2 focus:ring-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Imprimir
                    </x-a-button>
                @endcan
            </div>
        </div>

        @if ($prtlist->count())
            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        <td class="p-3 border">Nombre</td>
                        <td class="p-3 border">Descripción</td>
                        <td class="p-3 border">Modelo</td>
                        <td class="p-3 border">Tipo Producto</td>
                        <td class="p-3 border">Proveedor</td>
                        <td class="p-3 border">Empresa</td>
                        <td class="p-3 border">Foto</td>
                        <td class="p-3 border">Acciones</td>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($prtlist as $prt )
                        <tr>
                            <td class="p-3 border">{{ $prt->name }}</td>
                            <td class="p-3 border">{{ $prt->description }}</td>
                            <td class="p-3 border">{{ $prt->modelo }}</td>
                            <td class="p-3 border">{{ $prt->productypes->name }}</td>
                            <td class="p-3 border">{{ $prt->suppliers->name }}</td>
                            <td class="p-3 border">{{ $prt->companies->name }}</td>
                            <td class="p-3 border">
                                @if ($prt->image)
                                    <img class="object-cover object-center h-12" alt="" src="{{ Storage::url($prt->image->url) }}">
                                @else
                                    <img id="nophoto" src="{{ asset('images/no_photo.jpg') }}" alt="">
                                @endif
                            </td>
                            <td class="w-40 p-3 border">
                                @can('devi.create')
                                    <x-a-button id="addDevice" title="Agregar Dispositivo" wire:click="confirmDeviAddItem({{ $prt->id }})" class="mr-2 p-sm-button bg-lime-800 hover:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                                        </svg>
                                    </x-a-button>
                                @endcan
                                @can('pro.edit')
                                    <x-a-button id="editProduct" title="Editar Producto" wire:click="confirmProduEditItem({{ $prt->id }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </x-a-button>
                                @endcan

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
            {{ $prtlist->links() }}
        </div>
        {{-- Editar Producto Modal --}}
        <x-dialog-modal id="ModalEditProduct" wire:model.live="confirmingProductItemEdit">
            <x-slot name="title">
                {{ __('Editar Producto') }}
            </x-slot>
            <x-slot name="content">
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="name" value="{{ __('Nombre Producto *') }}"></x-label>
                    <x-bladewind.input id="name" wire:model.lazy="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="name" class="mt-2"></x-input-error>
                </div>
                {{-- Descripción --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="description" value="{{ __('Descripción') }}"></x-label>
                    <x-bladewind.textarea id="description" wire:model.lazy="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="description" class="mt-2"></x-input-error>
                </div>
                {{-- modelo --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="modelo" value="{{ __('Modelo') }}"></x-label>
                    <x-bladewind.input id="modelo" wire:model.lazy="modelo" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="modelo" class="mt-2"></x-input-error>
                </div>
                {{-- Tipo de Producto --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="productype" value="{{ __('Tipo de Producto') }}"></x-label>
                    <select id="productype" wire:model="productype_id" class="form-control">
                        <option value="">Seleccione un Tipo de producto</option>
                        @if ($productypes->count())
                            @foreach ($productypes as $pt)
                                <option value="{{ $pt->id }}">
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        @else
                                No existen Registros
                        @endif
                    </select>
                </div>
                {{-- Proveedor --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="supplier" value="{{ __('Proveedor') }}"></x-label>
                    <select id="supplier" wire:model="supplier_id" class="form-control">
                        <option value="">Seleccione un Proveedor</option>
                        @if ($suppliers->count())
                            @foreach ($suppliers as $sup)
                                    <option value="{{ $sup->id }}">
                                        {{ $sup->name }}
                                    </option>
                            @endforeach
                        @else
                                No existen registros
                        @endif
                    </select>
                </div>
                {{-- Compañía --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="company" value="{{ __('Empresa') }}"></x-label>
                    <select id="company" wire:model="company_id" class="form-control">
                        <option value="">Seleccione una Empresa</option>
                        @if ($companys->count())
                            @foreach ($companys as $com)
                                <option value="{{ $com->id }}">
                                    {{ $com->name }}
                                </option>
                            @endforeach
                        @else
                                No existen registros
                        @endif
                    </select>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button  wire:click="editProduct()"  wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="$toggle('confirmingProductItemEdit',false)"  wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        {{-- Ingresar dispositivo modal --}}
        <x-dialog-modal id="ModalAddDevi" wire:model.live="confirmingDeviItemAdd">
            <x-slot name="title">
                {{ __('Ingresar Dispositivo') }}
            </x-slot>
            <x-slot name="content">
                {{-- N° de Serie --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="numserie" value="{{ __('N° Serie *') }}"></x-label>
                    <x-bladewind.input id="numserie" wire:model.lazy="numserie" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                    <x-input-error for="numserie" class="mt-2"></x-input-error>
                </div>
                {{-- fecha compra --}}
                <div class="colspan-3 sm:col-span-2">
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
                <x-secondary-button  wire:click="saveDevi()"  wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="$toggle('confirmingDeviItemAdd',false)"  wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-fondo-card>
