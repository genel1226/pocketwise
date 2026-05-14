<flux:dropdown position="bottom" align="start">
    <flux:sidebar.profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
        icon:trailing="chevrons-up-down" data-test="sidebar-menu-button" />

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
        <flux:menu.separator />
        {{-- dark mode --}}
        <div
                class="group flex cursor-default items-center justify-between rounded-lg px-2 py-2 transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800">
                <div class="flex items-center gap-2">
                    <flux:icon name="moon"
                        class="size-4 text-zinc-500 transition-colors group-hover:text-zinc-700 dark:text-zinc-400 dark:group-hover:text-zinc-200" />

                    <span class="text-sm bold text-zinc-700 dark:text-zinc-200">
                        Dark mode
                    </span>
                </div>

                <div x-on:click.stop>
                    <flux:switch x-data x-model="$flux.dark" />
                </div>
            </div>
        {{-- end dark mode --}}
    </flux:menu>
</flux:dropdown>
