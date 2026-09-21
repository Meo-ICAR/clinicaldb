<?php

namespace App\Filament\Resources\Naives\Pages;

use App\Filament\Resources\Naives\NaiveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNaives extends ListRecords
{
    protected static string $resource = NaiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_naives.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_naives.title');
    }
}
