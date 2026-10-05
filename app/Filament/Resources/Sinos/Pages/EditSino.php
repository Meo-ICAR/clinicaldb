<?php

namespace App\Filament\Resources\Sinos\Pages;

use App\Filament\Resources\Sinos\SinoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSino extends EditRecord
{
    protected static string $resource = SinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_sino.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_sino.title');
    }
}
