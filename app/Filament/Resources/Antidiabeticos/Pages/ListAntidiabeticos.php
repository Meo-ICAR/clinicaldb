<?php

namespace App\Filament\Resources\Antidiabeticos\Pages;

use App\Filament\Resources\Antidiabeticos\AntidiabeticoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAntidiabeticos extends ListRecords
{
    protected static string $resource = AntidiabeticoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_antidiabeticos.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_antidiabeticos.title');
    }
}
