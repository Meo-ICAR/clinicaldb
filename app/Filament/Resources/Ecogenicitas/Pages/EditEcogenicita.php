<?php

namespace App\Filament\Resources\Ecogenicitas\Pages;

use App\Filament\Resources\Ecogenicitas\EcogenicitaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEcogenicita extends EditRecord
{
    protected static string $resource = EcogenicitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
