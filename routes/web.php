<?php

use App\Livewire\PowerGrid\Categories\Index as IndexCategories;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('categories', IndexCategories::class)->name('categories.index');

require __DIR__.'/settings.php';
