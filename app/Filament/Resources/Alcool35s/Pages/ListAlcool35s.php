<?php

namespace App\Filament\Resources\Alcool35s\Pages;

use App\Filament\Resources\Alcool35s\Alcool35Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlcool35s extends ListRecords
{
    protected static string $resource = Alcool35Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
