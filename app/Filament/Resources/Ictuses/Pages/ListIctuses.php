<?php

namespace App\Filament\Resources\Ictuses\Pages;

use App\Filament\Resources\Ictuses\IctusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIctuses extends ListRecords
{
    protected static string $resource = IctusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_ictuses.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_ictuses.title');
    }
}
