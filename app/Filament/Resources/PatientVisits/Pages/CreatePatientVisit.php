<?php

namespace App\Filament\Resources\PatientVisits\Pages;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatientVisit extends CreateRecord
{
    protected static string $resource = PatientVisitResource::class;
}
