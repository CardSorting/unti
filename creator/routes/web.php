<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use Illuminate\Http\JsonResponse;

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function() {
    return new JsonResponse([
        'token' => csrf_token()
    ]);
});

Route::resource('cards', CardController::class);
