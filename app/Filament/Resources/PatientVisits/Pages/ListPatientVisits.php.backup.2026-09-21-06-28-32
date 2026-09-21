<?php

namespace App\Filament\Resources\PatientVisits\Pages;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\HtmlString;

class ListPatientVisits extends ListRecords
{
    protected static string $resource = PatientVisitResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (filled(request()->query('rr_field'))) {
            $actions[] = Action::make('clearAnomalyFilter')
                ->label('Rimuovi filtro valori anomali')
                ->color('gray')
                ->url(static::getResource()::getUrl('index'));
        }

        return $actions;
    }

    public function getSubheading(): ?Htmlable
    {
        $field = request()->query('rr_field');

        if (blank($field) || ! is_string($field) || ! Schema::hasColumn('patient_visits', $field)) {
            return null;
        }

        $min = request()->query('rr_min');
        $max = request()->query('rr_max');
        $min = is_numeric($min) ? (float) $min : null;
        $max = is_numeric($max) ? (float) $max : null;

        if ($min === null && $max === null) {
            return null;
        }

        $range = match (true) {
            $min !== null && $max !== null && $min == $max => '= '.$min,
            $min !== null && $max !== null => 'tra '.$min.' e '.$max,
            $min !== null => '>= '.$min,
            default => '<= '.$max,
        };

        return new HtmlString('Elenco filtrato: <strong>'.e($field).'</strong> '.e($range).'. Usato per individuare e correggere valori anomali.');
    }
}
