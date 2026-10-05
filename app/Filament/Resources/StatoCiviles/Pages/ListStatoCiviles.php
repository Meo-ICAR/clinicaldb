<?php

namespace App\Filament\Resources\StatoCiviles\Pages;

use App\Filament\Resources\StatoCiviles\StatoCivileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatoCiviles extends ListRecords
{
    protected static string $resource = StatoCivileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_stato_civiles.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_stato_civiles.title');
    }
}
