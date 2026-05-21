<div>
    @if (session()->has('error'))
        <div class="mb-4 rounded-xl bg-red-100 text-red-700 p-3">
            {{ session('error') }}
        </div>
    @endif
    
    {{-- Modal Confirmacion Eliminar --}}
    <flux:modal name="delete-transaction" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar Transacción?</flux:heading>

                <flux:text class="mt-2">
                    Está a punto de elimiar esta Transacción.<br>
                    Esta acción no se puede revertir.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" wire:click="confirmDestroy" variant="danger">Borrar Transacción</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Titulo y Boton Modal para agregar --}}
    <div class="flex justify-between py-4 bg-zinc-100 dark:bg-zinc-900 rounded-2xl">
        <div class="order-first">
            <div class="flex text-2xl">
                <div class="p-1">
                    <flux:icon name="banknotes" />
                </div>
                Transacciones
            </div>
        </div>
        {{-- Modal --}}
        <div class="order-last px-2">
            <flux:modal.trigger wire:click="open">
                <flux:button>
                    <flux:icon name="plus" />Transacción
                </flux:button>
            </flux:modal.trigger>

            <flux:modal name="create-transactions" class="w-full !max-w-xl" :dismissible="false">

                <form wire:submit.prevent="{{ $state === 'create' ? 'save' : 'update' }}">

                    <div class="space-y-6">

                        <div>
                            <flux:heading size="lg">
                                {{ $state === 'create' ? 'Agregar Transacción' : 'Editar Transacción' }}
                            </flux:heading>
                        </div>

                        <flux:separator />

                        <div class="grid grid-cols-2 gap-4">

                            <flux:select label="Categoría" wire:model.live="form.category_id" >

                                <flux:select.option value="">
                                    Seleccione Categoría
                                </flux:select.option>

                                @foreach ($categories as $id => $name)
                                    <flux:select.option value="{{ $id }}">
                                        {{ $name }}
                                    </flux:select.option>
                                @endforeach

                            </flux:select>

                            <flux:select label="Sobre" wire:model.live="form.envelope_id" :disabled="collect($envelopes)->isEmpty()">

                                <flux:select.option value="">
                                    Seleccione Sobre
                                </flux:select.option>

                                @foreach ($envelopes as $id => $name)
                                    <flux:select.option value="{{ $id }}">
                                        {{ $name }}
                                    </flux:select.option>
                                @endforeach

                            </flux:select>

                            <flux:input wire:model="form.amount" type="number" label="Monto" placeholder="Ingrese Monto"
                            :error="$errors->first('amount')" />

                            {{-- <flux:fieldset variant="inline">
                                <flux:legend>Tipo de Transacción</flux:legend>

                                <div class="flex gap-4 *:gap-x-2">
                                    <flux:checkbox wire:model="form.type" value="1" label="Marque si es Egreso" />
                                </div>
                            </flux:fieldset> --}}

                            <flux:radio.group wire:model="form.type" label="Tipo de Transacción" variant="segmented">

                                <flux:radio value="income" label="Ingreso" />

                                <flux:radio value="expense" label="Egreso" />

                            </flux:radio.group>

                            <div class="col-span-2">
                                <flux:textarea label="Descripción" wire:model="form.description" placeholder="Introduzca la descripción de la Transacción" />
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <flux:input  wire:model="form.years" label="Año" />

                                <flux:select label="Mes" wire:model.live="form.months" >
                                    <flux:select.option value="">
                                        Mes
                                    </flux:select.option>
                                    
                                    @for ($mes = 1; $mes <= 12; $mes++)
                                    <flux:select.option value="{{ $mes }}">
                                        {{ $mes }}
                                    </flux:select.option>
                                    @endfor
                                    
                                </flux:select>
                                <flux:select label="Día" wire:model.live="form.days" >
                                    <flux:select.option value="">
                                        Día
                                    </flux:select.option>

                                    @php
                                        $mesSeleccionado = $form->months;

                                        if (in_array($mesSeleccionado, [1, 3, 5, 7, 8, 10, 12])) {
                                            $diaTope = 31;
                                        } elseif (in_array($mesSeleccionado, [4, 6, 9, 11])) {
                                            $diaTope = 30;
                                        } else {
                                            $diaTope = 28;
                                        }
                                    @endphp

                                    @for ($dia = 1; $dia <= $diaTope; $dia++)
                                        <flux:select.option value="{{ $dia }}">
                                            {{ $dia }}
                                        </flux:select.option>
                                    @endfor

                                </flux:select>
                            </div>

                            <flux:fieldset variant="inline">
                                <flux:legend>Frecuencia</flux:legend>

                                <div class="flex gap-4 *:gap-x-2">
                                    <flux:checkbox wire:model="form.is_recurring" value="1" label="Marque si es Recurrente" />
                                </div>
                            </flux:fieldset>
                        </div>


                        <div class="flex">

                            <flux:spacer />

                            <div class="flex gap-4">
                                <flux:button type="button" wire:click="exit" variant="ghost">Cancelar</flux:button>

                                <flux:button type="submit" variant="primary">
                                    {{ $state === 'create' ? 'Crear' : 'Modificar' }}</flux:button>
                            </div>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    {{-- Tabla con PowerGrid --}}
    <div class="py-4">
        <livewire:pocket-wise.transactions.transactions-table />
    </div>
</div>
