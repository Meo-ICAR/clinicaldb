<?php

namespace App\Filament\Resources\Cirrosis\Pages;

use App\Filament\Resources\Cirrosis\CirrosiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCirrosis extends ListRecords
{
    protected static string $resource = CirrosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
