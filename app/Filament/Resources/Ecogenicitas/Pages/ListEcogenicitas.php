<?php

namespace App\Filament\Resources\Ecogenicitas\Pages;

use App\Filament\Resources\Ecogenicitas\EcogenicitaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEcogenicitas extends ListRecords
{
    protected static string $resource = EcogenicitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_ecogenicitas.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_ecogenicitas.title');
    }
}
