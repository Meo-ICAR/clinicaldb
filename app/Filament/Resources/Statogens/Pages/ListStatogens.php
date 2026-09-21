<?php

namespace App\Filament\Resources\Statogens\Pages;

use App\Filament\Resources\Statogens\StatogenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatogens extends ListRecords
{
    protected static string $resource = StatogenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_statogens.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_statogens.title');
    }
}
