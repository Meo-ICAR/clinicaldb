<?php

namespace App\Filament\Resources\ArtTerapias\Pages;

use App\Filament\Resources\ArtTerapias\ArtTerapiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArtTerapia extends EditRecord
{
    protected static string $resource = ArtTerapiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_art_terapia.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_art_terapia.title');
    }
}
