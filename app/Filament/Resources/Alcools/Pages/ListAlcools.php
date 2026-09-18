<?php

namespace App\Filament\Resources\Alcools\Pages;

use App\Filament\Resources\Alcools\AlcoolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlcools extends ListRecords
{
    protected static string $resource = AlcoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
