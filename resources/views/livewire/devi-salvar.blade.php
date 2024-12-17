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
                        class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus:b" />
                    <x-input-error for="numserie" class="mt-2"></x-input-error>
                </div>
            @else
                <div class="colspan-6 sm:col-span-4">
                    <x-label for="numserie" value="{{ __('N° Serie') }}"></x-label>
                    <x-input id="numserie"
                        class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus:b"
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
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus:b" />
                {{-- Fin datepicker --}}
                <x-input-error for="fechacompra" class="mt-2"></x-input-error>
            </div>
        </div>
        <div>
            {{-- comentarios --}}
            <div class="colspan-3 sm:col-span-4">
                <x-label for="comentarios" value="{{ __('Comentarios') }}"></x-label>
                <x-bladewind.textarea id="comentarios" wire:model.lazy="comentarios"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus:b" />
                <x-input-error for="comentarios" class="mt-2"></x-input-error>
            </div>
        </div>
        <div>
            {{-- estado --}}
            <div class="flex flex-col w-full max-w-sm bg-gray-700 shadow relativa rounded-xl">
                <nav class="flex min-w-[240px] flex-row gap-1 p-2">
                    <div role="button"
                        class="flex w-full items-center rounded-lg p-0 transition-all hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-500">
                        <label for="activo-horizontal" class="flex w-full cursor-pointer items-center px-3 py-2">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer" for="activo-horizontal">
                                    <input name="estado" type="radio" wire:model="estado" value="1"
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all"
                                        id="activo-horizontal" checked />
                                    <span
                                        class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
                                </label>
                                <label class="ml-2 text-gray-100 cursor-pointer text-sm" for="react-horizontal">
                                    Activo
                                </label>
                            </div>
                        </label>
                    </div>
                    <div role="button"
                        class="flex w-full items-center rounded-lg p-0 transition-all hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-500">
                        <label for="noactivo-horizontal" class="flex w-full cursor-pointer items-center px-3 py-2">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer" for="noactivo-horizontal">
                                    <input name="estado" type="radio" wire:model="estado" value="2"
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all"
                                        id="noactivo-horizontal" />
                                    <span
                                        class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
                                </label>
                                <label class="ml-2 text-gray-100 cursor-pointer text-sm" for="noactivo-horizontal">
                                    No activo
                                </label>
                            </div>
                        </label>
                    </div>
                    @if ($enableEdit)
                        <div role="button" class="flex w-full items-center rounded-lg p-0 transition-all hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-500">
                            <label for="baja-horizontal" class="flex w-full cursor-pointer items-center px-3 py-2">
                                <div class="inline-flex items-center">
                                    <label class="relative flex items-center cursor-pointer" for="baja-horizontal">
                                        <input name="estado" type="radio" wire:model="estado" value="3" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" id="baja-horizontal"/>
                                        <span
                                            class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
                                    </label>
                                    <label class="ml-2 text-gray-100 cursor-pointer text-sm" for="baja-horizontal">
                                        De baja
                                    </label>
                                </div>
                            </label>
                        </div>
                    @endif
                </nav>
            </div>
            
        </div>
        <div>
            {{-- Departmento --}}
            <div class="colspan-3 sm:col-span-4">
                <x-label for="department" value="{{ __('Departamento') }}"></x-label>
                <select id="department_id" wire:model="department_id"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm form-control focus">
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
