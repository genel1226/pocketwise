<?php

use App\Livewire\PocketWise\Categories\Index as IndexCategories;
use App\Livewire\PocketWise\Envelopes\Index as IndexEnvelopes;
use App\Livewire\PocketWise\Transactions\Index as IndexTransactions;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('categories', IndexCategories::class)->name('categories.index');
Route::livewire('envelopes', IndexEnvelopes::class)->name('envelopes.index');
Route::livewire('transactions', IndexTransactions::class)->name('transactions.index');

require __DIR__.'/settings.php';
