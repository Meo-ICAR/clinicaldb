<?php

namespace App\Filament\Resources\Infeziones\Pages;

use App\Filament\Resources\Infeziones\InfezioneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfeziones extends ListRecords
{
    protected static string $resource = InfezioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_infeziones.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_infeziones.title');
    }
}
