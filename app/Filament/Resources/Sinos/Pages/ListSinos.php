<?php

namespace App\Filament\Resources\Sinos\Pages;

use App\Filament\Resources\Sinos\SinoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSinos extends ListRecords
{
    protected static string $resource = SinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_sinos.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_sinos.title');
    }
}
