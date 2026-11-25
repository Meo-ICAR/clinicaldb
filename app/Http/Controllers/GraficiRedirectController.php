<?php

namespace App\Http\Controllers;

use App\Services\SsoTokenBroker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Porta l'utente già autenticato su Grafici (Daishboard) con login
 * automatico: il token one-time viene emesso al click e consumato dal
 * bridge SSO (/bpm-landing) già in produzione.
 */
class GraficiRedirectController extends Controller
{
    public function __invoke(Request $request, SsoTokenBroker $broker): RedirectResponse
    {
        $email = $request->user()->email;

        $url = rtrim((string) config('services.grafici.url'), '/').'/bpm-landing/dashboard?'.http_build_query([
            'token' => $broker->issueToken($email),
            'user_email' => $email,
            'source' => 'clinicaldb',
        ]);

        return redirect()->away($url);
    }
}
