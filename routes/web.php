<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs/manuale-utente', function () {
    return response()->file(resource_path('docs/manuale-utente.html'));
})->middleware('auth')->name('docs.manuale-utente');
