<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo dispositivo.') }}
    </x-slot>
    <x-slot name="content">
        <form id="saveDevi" wire:submit.prevent="submit">
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
            {{-- Boton guardar --}}
            <x-bladewind.button
                color="purple"
                name="save-devi"
                can_submit="true"
                class="px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>

            <div wire:loading>
                Validando datos...
            </div>
        </form>
    </x-slot>
    <script>
            var picker = new Pikaday(
                {
                    field: document.getElementById('fechacompra'),
                    onSelect: function() {
                        var data = this.getDate();
                        @this.set('fechacompra',data);
                    }
                }
            );
    </script>


</x-action-section>
