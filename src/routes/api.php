<?php

use Illuminate\Support\Facades\Route;

Route::get('/books/search', [\App\Http\Controllers\OpacController::class, 'search'])->name('api.books.search');
