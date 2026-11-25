<?php

use App\Http\Controllers\GraficiRedirectController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs/manuale-utente', function () {
    return response()->file(resource_path('docs/manuale-utente.html'));
})->middleware('auth')->name('docs.manuale-utente');

Route::get('/grafici', GraficiRedirectController::class)
    ->middleware(Authenticate::class)
    ->name('grafici');
