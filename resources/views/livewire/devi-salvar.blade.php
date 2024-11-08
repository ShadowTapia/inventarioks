<div class="p-6">
    <div class="text-lg font-medium text-gray-100">
        {{ $title }}
    </div>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form id="AddDevi" wire:submit.prevent="submit">
        <div>
            @if ($enableEdit == false)
                {{-- N° de Serie --}}
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="numserie" value="{{ __('N° Serie *') }}"></x-label>
                    <x-bladewind.input id="numserie" wire:model.lazy="numserie" required="true"
                        class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                    <x-input-error for="numserie" class="mt-2"></x-input-error>
                </div>
            @else
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="numserie" value="{{ __('N° Serie') }}"></x-label>
                    <x-input id="numserie"
                        class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                        readonly name="numserie" value="{{ $numserie }}" />
                    <x-input-error for="numserie" class="mt-2"></x-input-error>
                </div>
            @endif
        </div>
        <div>
            {{-- fecha compra --}}
            <div class="colspan-3 sm:col-span-2">
                <x-label for="fechacompra" value="{{ __('Fecha Compra') }}"></x-label>
                {{-- Inicio datepicker --}}
                <x-input.date wire:model.defer="fechacompra" id="fechacompra"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                {{-- Fin datepicker --}}
                <x-input-error for="fechacompra" class="mt-2"></x-input-error>
            </div>
        </div>
        <div>
            {{-- comentarios --}}
            <div class="colspan-3 sm:col-span-4">
                <x-label for="comentarios" value="{{ __('Comentarios') }}"></x-label>
                <x-bladewind.textarea id="comentarios" wire:model.lazy="comentarios"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="comentarios" class="mt-2"></x-input-error>
            </div>
        </div>
        <div>
            {{-- estado --}}
            <div class="colspan-3 sm:col-span-4">
                <label>
                    <x-input class="text-sm text-gray-300 bg-gray-800" type="radio" wire:model="estado"
                        value="1" /> Activo
                </label>
                <label>
                    <x-input class="text-sm text-gray-300 bg-gray-800" type="radio" wire:model="estado"
                        value="2" /> No Activo
                </label>
                @if ($enableEdit)
                    <label>
                        <x-input class="text-sm text-gray-300 bg-gray-800" type="radio" wire:model="estado"
                            value="3" /> De Baja
                    </label>
                @endif
            </div>
        </div>
        <div>
            {{-- Departmento --}}
            <div class="colspan-3 sm:col-span-4">
                <x-label for="department" value="{{ __('Departamento') }}"></x-label>
                <select id="department_id" wire:model="department_id" class="form-control">
                    <option value="">Seleccione un Departamento</option>
                    @if ($departments->count())
                        @foreach ($departments as $depa)
                            <option value="{{ $depa->id }}">
                                {{ $depa->name }}
                            </option>
                        @endforeach
                    @else
                        No existen registros
                    @endif
                </select>
            </div>
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-800 footer">
            {{-- Boton guardar --}}
            <x-bladewind.button color="purple" has_spinner="true" name="save-devi" can_submit="true"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>
        </div>

        <div wire:loading>
            Guardando datos...
        </div>
    </form>
</div>
