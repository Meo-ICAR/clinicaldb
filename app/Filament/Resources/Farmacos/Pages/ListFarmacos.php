<?php

namespace App\Filament\Resources\Farmacos\Pages;

use App\Filament\Resources\Farmacos\FarmacoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmacos extends ListRecords
{
    protected static string $resource = FarmacoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_farmacos.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_farmacos.title');
    }
}
