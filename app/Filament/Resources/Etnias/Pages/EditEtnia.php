<?php

namespace App\Filament\Resources\Etnias\Pages;

use App\Filament\Resources\Etnias\EtniaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEtnia extends EditRecord
{
    protected static string $resource = EtniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_etnia.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_etnia.title');
    }
}
