<?php

namespace App\Filament\Resources\TrattamentoCausaAbbandonos\Pages;

use App\Filament\Resources\TrattamentoCausaAbbandonos\TrattamentoCausaAbbandonoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrattamentoCausaAbbandono extends EditRecord
{
    protected static string $resource = TrattamentoCausaAbbandonoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
