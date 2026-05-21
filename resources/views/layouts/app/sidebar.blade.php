<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        {{-- Sidebar --}}
        <flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        Dashboard
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" :href="route('categorias.index')" :current="request()->routeIs('categorias.*')" wire:navigate>
                        Categorias
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="envelope" :href="route('sobres.index')" :current="request()->routeIs('sobres.*')" wire:navigate>
                        Sobres
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="banknotes" :href="route('transacciones.index')" :current="request()->routeIs('transacciones.*')" wire:navigate>
                        Transacciones
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />
        </flux:sidebar>

        {{-- Header --}}
        <flux:header  class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="hidden mr-2" icon="bars-2" inset="left" />
            @php
                $route = request()->route()->getName();

                $section = explode('.', $route)[0];
            @endphp

            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home" />

                <flux:breadcrumbs.item >
                    {{ ucfirst($section) }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>

            <flux:spacer />

            <x-desktop-user-menu />
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
        @livewireScripts
    </body>
</html>
