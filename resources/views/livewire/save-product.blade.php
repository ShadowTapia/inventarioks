<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo producto.') }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            {{-- nombre --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre Producto *') }}"></x-label>
                <x-bladewind.input id="name" wire:model.lazy="name"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus" />
                <x-input-error for="name" class="mt-2"></x-input-error>
            </div>
            {{-- Descripción --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Descripción') }}"></x-label>
                <x-bladewind.textarea id="description" wire:model.lazy="description"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus" />
                <x-input-error for="description" class="mt-2"></x-input-error>
            </div>
            {{-- modelo --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="modelo" value="{{ __('Modelo') }}"></x-label>
                <x-bladewind.input id="modelo" wire:model.lazy="modelo"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus" />
                <x-input-error for="modelo" class="mt-2"></x-input-error>
            </div>
            @if ($enableEdit) {{-- Si se habilita muestra el ingreso de imagenes --}}
                {{-- Subir foto --}}
                <div class="mb-3 row">
                    <div class="col">
                        <div class="bg-gray-900">
                            @if ($file)
                                <img id="picture" src="{{ $file->temporaryUrl() }}" alt="">
                            @else
                                <img id="picture" src="{{ asset('images/insertfoto.png') }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <x-label for="file" value="{{ __('Foto') }}"></x-label>
                        <input id="file" type="file" wire:model="file" class="form-control-file" />
                        @error('file')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <p>Se deben subir archivos fotograficos de tipo png o jpg y de un máximo de 800Kb.</p>
                    </div>
                </div>
            @endif

            {{-- Tipo de Producto --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="productype" value="{{ __('Tipo de Producto') }}"></x-label>
                <select id="productype" wire:model="productype_id"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm form-control focus">
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
                <select id="supplier" wire:model="supplier_id"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm form-control focus">
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
                <select id="company" wire:model="company_id"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm form-control focus">
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
            {{-- Botón Guardar --}}
            <x-bladewind.button color="purple" name="save-prodct" can_submit="true"
                class="px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>

            <div wire:loading wire:target="file">Subiendo...</div>
        </form>
    </x-slot>
</x-action-section>
