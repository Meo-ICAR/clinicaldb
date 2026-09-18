<?php

namespace App\Filament\Resources\Endolumiales\Pages;

use App\Filament\Resources\Endolumiales\EndolumialeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEndolumiales extends ListRecords
{
    protected static string $resource = EndolumialeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
