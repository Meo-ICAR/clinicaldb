<?php

namespace App\Filament\Resources\Ipertensiones\Pages;

use App\Filament\Resources\Ipertensiones\IpertensioneResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIpertensione extends EditRecord
{
    protected static string $resource = IpertensioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_ipertensione.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_ipertensione.title');
    }
}
