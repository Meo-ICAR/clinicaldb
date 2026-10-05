<?php

namespace App\Filament\Resources\Lavoros\Pages;

use App\Filament\Resources\Lavoros\LavoroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLavoros extends ListRecords
{
    protected static string $resource = LavoroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_lavoros.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_lavoros.title');
    }
}
