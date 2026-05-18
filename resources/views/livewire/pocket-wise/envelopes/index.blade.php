<div>
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

                            <flux:select label="Categoría" wire:model.live="category_id" >

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

                        </div>

                        <flux:input wire:model="form.spent_amount" type="number" label="Gasto" placeholder="Ingrese Monto Gastado"
                            :error="$errors->first('spent_amount')" />

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
