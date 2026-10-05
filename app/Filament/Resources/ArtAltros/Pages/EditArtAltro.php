<?php

namespace App\Filament\Resources\ArtAltros\Pages;

use App\Filament\Resources\ArtAltros\ArtAltroResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArtAltro extends EditRecord
{
    protected static string $resource = ArtAltroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_art_altro.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_art_altro.title');
    }
}
