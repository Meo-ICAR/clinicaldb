<?php

namespace App\Filament\Resources\Epatites\Pages;

use App\Filament\Resources\Epatites\EpatiteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEpatite extends EditRecord
{
    protected static string $resource = EpatiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
