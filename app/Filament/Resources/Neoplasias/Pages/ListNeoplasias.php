<?php

namespace App\Filament\Resources\Neoplasias\Pages;

use App\Filament\Resources\Neoplasias\NeoplasiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNeoplasias extends ListRecords
{
    protected static string $resource = NeoplasiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_neoplasias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_neoplasias.title');
    }
}
