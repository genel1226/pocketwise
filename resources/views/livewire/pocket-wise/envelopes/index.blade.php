<div>
    @if (session()->has('error'))
        <div class="mb-4 rounded-xl bg-red-100 text-red-700 p-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Modal Confirmacion Eliminar --}}
    <flux:modal name="delete-envelope" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar Sobre?</flux:heading>

                <flux:text class="mt-2">
                    Está a punto de elimiar este Sobre.<br>
                    Esta acción no se puede revertir.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" wire:click="confirmDestroy" variant="danger">Borrar Sobre</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Titulo y Boton Modal para agregar --}}
    <div class="flex justify-between py-4 bg-zinc-100 dark:bg-zinc-900 rounded-2xl">
        <div class="order-first">
            <div class="flex text-2xl">
                <div class="p-1">
                    <flux:icon name="envelope" />
                </div>
                Sobres
            </div>
        </div>
        {{-- Modal --}}
        <div class="order-last px-2">
            <flux:modal.trigger wire:click="open">
                <flux:button>
                    <flux:icon name="plus" />Sobre
                </flux:button>
            </flux:modal.trigger>

            <flux:modal name="create-envelopes" class="w-full !max-w-xl" :dismissible="false">

                <form wire:submit.prevent="{{ $state === 'create' ? 'save' : 'update' }}">

                    <div class="space-y-6">

                        <div>
                            <flux:heading size="lg">
                                {{ $state === 'create' ? 'Agregar Sobre' : 'Editar Sobre' }}
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

                            <flux:input wire:model="form.allocated_amount" label="Presupuesto" placeholder="Ingrese Presupuesto"
                                disabled />
                                
                            <flux:input wire:model="form.spent_amount" type="number" label="Gasto" disabled placeholder="Ingrese Monto Gastado"
                            :error="$errors->first('spent_amount')" />

                            <flux:input wire:model="form.month_year" label="Año - Mes" placeholder="Ej: 2026-01"
                            :error="$errors->first('month_year')" />
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
        <livewire:pocket-wise.envelopes.envelopes-table />
    </div>
</div>
