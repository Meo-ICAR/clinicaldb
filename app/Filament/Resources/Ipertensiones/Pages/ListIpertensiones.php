<?php

namespace App\Filament\Resources\Ipertensiones\Pages;

use App\Filament\Resources\Ipertensiones\IpertensioneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIpertensiones extends ListRecords
{
    protected static string $resource = IpertensioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_ipertensiones.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_ipertensiones.title');
    }
}
