<?php

namespace App\Filament\Resources\Infeziones\Pages;

use App\Filament\Resources\Infeziones\InfezioneResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInfezione extends EditRecord
{
    protected static string $resource = InfezioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
