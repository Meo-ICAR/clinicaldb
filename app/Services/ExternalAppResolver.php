<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Risolve l'URL base delle altre app esterne (oggi Dashboard) verso cui
 * ClinicalDB può proporre il passaggio con login automatico tramite
 * AppSwitcherWidget.
 */
class ExternalAppResolver
{
    public function urlFor(string $app): string
    {
        $url = config("services.apps.{$app}.url");

        if (! $url) {
            throw new InvalidArgumentException("Applicativo esterno sconosciuto: {$app}");
        }

        return rtrim($url, '/');
    }

    public function labelFor(string $app): string
    {
        return (string) (config("services.apps.{$app}.label") ?: $app);
    }

    /**
     * @return string[] Le chiavi di tutti gli applicativi esterni configurati.
     */
    public function allApps(): array
    {
        return array_keys((array) config('services.apps', []));
    }
}
