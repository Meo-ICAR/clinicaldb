<?php

namespace App\Filament\Resources\Lipodistrofias\Pages;

use App\Filament\Resources\Lipodistrofias\LipodistrofiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLipodistrofias extends ListRecords
{
    protected static string $resource = LipodistrofiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_lipodistrofias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_lipodistrofias.title');
    }
}
