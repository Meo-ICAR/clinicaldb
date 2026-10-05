<?php

namespace App\Filament\Resources\Antidiabeticos\Pages;

use App\Filament\Resources\Antidiabeticos\AntidiabeticoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAntidiabetico extends EditRecord
{
    protected static string $resource = AntidiabeticoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_antidiabetico.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_antidiabetico.title');
    }
}
