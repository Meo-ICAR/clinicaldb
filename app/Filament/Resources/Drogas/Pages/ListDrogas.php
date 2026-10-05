<?php

namespace App\Filament\Resources\Drogas\Pages;

use App\Filament\Resources\Drogas\DrogaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDrogas extends ListRecords
{
    protected static string $resource = DrogaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_drogas.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_drogas.title');
    }
}
