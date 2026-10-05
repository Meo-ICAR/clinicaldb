<?php

namespace App\Filament\Resources\ArtAltros\Pages;

use App\Filament\Resources\ArtAltros\ArtAltroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArtAltros extends ListRecords
{
    protected static string $resource = ArtAltroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_art_altros.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_art_altros.title');
    }
}
