<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('katalog')->name('opac.')->group(function () {
    Route::get('/', [\App\Http\Controllers\OpacController::class, 'index'])->name('index');
    Route::get('/buku/{book}', [\App\Http\Controllers\OpacController::class, 'show'])->name('show');
    Route::get('/search', [\App\Http\Controllers\OpacController::class, 'search'])->name('search');
});
