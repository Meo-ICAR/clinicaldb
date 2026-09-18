<?php

namespace App\Filament\Resources\PatientVisits\Pages;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPatientVisit extends EditRecord
{
    protected static string $resource = PatientVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
