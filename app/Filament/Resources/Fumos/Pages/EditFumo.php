<?php

namespace App\Filament\Resources\Fumos\Pages;

use App\Filament\Resources\Fumos\FumoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFumo extends EditRecord
{
    protected static string $resource = FumoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
