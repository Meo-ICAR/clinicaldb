<?php

namespace App\Filament\Resources\Insuffrenales\Pages;

use App\Filament\Resources\Insuffrenales\InsuffrenaleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInsuffrenale extends EditRecord
{
    protected static string $resource = InsuffrenaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_insuffrenale.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_insuffrenale.title');
    }
}
