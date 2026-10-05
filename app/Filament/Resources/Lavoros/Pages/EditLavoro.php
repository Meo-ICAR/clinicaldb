<?php

namespace App\Filament\Resources\Lavoros\Pages;

use App\Filament\Resources\Lavoros\LavoroResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLavoro extends EditRecord
{
    protected static string $resource = LavoroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_lavoro.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_lavoro.title');
    }
}
