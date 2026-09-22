<?php

use App\Http\Controllers\Api\SsoTokenApiController;
use Illuminate\Support\Facades\Route;

// Consumato dal BpmBridgeController di Dashboard per validare i token SSO
// emessi da ClinicalDB tramite AppSwitcherWidget.
Route::post('/verify-token', [SsoTokenApiController::class, 'verify'])
    ->name('api.verify-token');
