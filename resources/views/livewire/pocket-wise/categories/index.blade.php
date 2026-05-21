<div>
    {{-- Modal Confirmacion Eliminar --}}
    <flux:modal name="delete-category" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar Categoría?</flux:heading>

                <flux:text class="mt-2">
                    Está a punto de elimiar esta Categoría.<br>
                    Esta acción no se puede revertir.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" wire:click="confirmDestroy" variant="danger">Borrar Categoría</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Titulo y Boton Modal para agregar --}}
    <div class="flex justify-between py-4 bg-zinc-100 dark:bg-zinc-900 rounded-2xl">
        <div class="order-first">
            <div class="flex text-2xl">
                <div class="p-1">
                    <flux:icon name="tag" />
                </div>
                Categorías
            </div>
        </div>
        {{-- Modal --}}
        <div class="order-last px-2">
            <flux:modal.trigger wire:click="open">
                <flux:button>
                    <flux:icon name="plus" />Categoría
                </flux:button>
            </flux:modal.trigger>

            <flux:modal name="create-categories" class="w-full !max-w-xl" :dismissible="false">

                <form wire:submit.prevent="{{ $state === 'create' ? 'save' : 'update' }}">

                    <div class="space-y-6">

                        <div>
                            <flux:heading size="lg">
                                {{ $state === 'create' ? 'Agregar Categoría' : 'Editar Categoría' }}
                            </flux:heading>
                        </div>

                        <flux:separator />

                        <div class="grid grid-cols-2 gap-4">

                            <flux:input wire:model="form.name" label="Nombre" placeholder="Nombre Categoría"
                                :error="$errors->first('name')" />

                            <flux:select label="Tipo" wire:model="form.type" :error="$errors->first('type')">
                                <flux:select.option value="">Seleccione Tipo</flux:select.option>
                                <flux:select.option value="need">Necesidad</flux:select.option>
                                <flux:select.option value="want">Deseo</flux:select.option>
                                <flux:select.option value="savings">Ahorro</flux:select.option>
                            </flux:select>

                            <flux:fieldset variant="inline">
                                <flux:legend>Tipo de Gasto</flux:legend>

                                <div class="flex gap-4 *:gap-x-2">
                                    <flux:checkbox wire:model="form.is_fixed" value="1" label="Marque si el gasto es fijo" />
                                </div>
                            </flux:fieldset>

                            <flux:input type="number" wire:model="form.monthly_budget" label="Presupuesto" placeholder="Ingrese Presupuesto" :error="$errors->first('monthly_budget')" />

                            <flux:select label="Icono" wire:model="form.icon">
                                <flux:select.option value="">Seleccione Icono</flux:select.option>

                                <flux:select.option>💰</flux:select.option>
                                <flux:select.option>🏠</flux:select.option>
                                <flux:select.option>🚗</flux:select.option>
                                <flux:select.option>🍔</flux:select.option>
                                <flux:select.option>🎮</flux:select.option>
                                <flux:select.option>📚</flux:select.option>
                                <flux:select.option>💊</flux:select.option>
                                <flux:select.option>🎓</flux:select.option>
                                <flux:select.option>✈️</flux:select.option>
                                <flux:select.option>👕</flux:select.option>
                            </flux:select>

                            <div class="space-y-2">
                                <label class="text-sm font-medium">Color</label>

                                <br>

                                <input type="color" wire:model.live="form.color" class="h-10 w-20 p-1 rounded cursor-pointer border">
                            </div>

                        </div>

                        <div class="flex">

                            <flux:spacer />

                            <div class="flex gap-4">
                                <flux:button type="button" wire:click="exit" variant="ghost">Cancelar</flux:button>

                                <flux:button type="submit" variant="primary">{{ $state === 'create' ? 'Crear' : 'Modificar' }}</flux:button>
                            </div>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    {{-- Tabla con PowerGrid --}}
    <div class="py-4">
        <livewire:pocket-wise.categories.categories-table />
    </div>
</div>
