<?php

namespace App\Filament\Resources\ArtTerapias\Pages;

use App\Filament\Resources\ArtTerapias\ArtTerapiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArtTerapias extends ListRecords
{
    protected static string $resource = ArtTerapiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_art_terapias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_art_terapias.title');
    }
}
