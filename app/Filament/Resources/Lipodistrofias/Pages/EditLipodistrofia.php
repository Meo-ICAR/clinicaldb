<?php

namespace App\Filament\Resources\Lipodistrofias\Pages;

use App\Filament\Resources\Lipodistrofias\LipodistrofiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLipodistrofia extends EditRecord
{
    protected static string $resource = LipodistrofiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
