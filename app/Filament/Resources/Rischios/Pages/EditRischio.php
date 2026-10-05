<?php

namespace App\Filament\Resources\Rischios\Pages;

use App\Filament\Resources\Rischios\RischioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRischio extends EditRecord
{
    protected static string $resource = RischioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_rischio.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_rischio.title');
    }
}
