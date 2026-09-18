<?php

namespace App\Filament\Resources\Rischios\Pages;

use App\Filament\Resources\Rischios\RischioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRischios extends ListRecords
{
    protected static string $resource = RischioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
