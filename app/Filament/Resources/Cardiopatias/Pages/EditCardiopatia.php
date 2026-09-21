<?php

namespace App\Filament\Resources\Cardiopatias\Pages;

use App\Filament\Resources\Cardiopatias\CardiopatiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCardiopatia extends EditRecord
{
    protected static string $resource = CardiopatiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_cardiopatia.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_cardiopatia.title');
    }
}
