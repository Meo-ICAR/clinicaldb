<?php

namespace App\Filament\Resources\Etnias\Pages;

use App\Filament\Resources\Etnias\EtniaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEtnias extends ListRecords
{
    protected static string $resource = EtniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_etnias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_etnias.title');
    }
}
