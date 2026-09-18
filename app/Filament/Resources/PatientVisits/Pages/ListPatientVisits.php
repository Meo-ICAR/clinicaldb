<?php

namespace App\Filament\Resources\PatientVisits\Pages;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatientVisits extends ListRecords
{
    protected static string $resource = PatientVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
