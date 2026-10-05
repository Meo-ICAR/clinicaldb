<?php

namespace App\Filament\Resources\Drogas\Pages;

use App\Filament\Resources\Drogas\DrogaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDroga extends EditRecord
{
    protected static string $resource = DrogaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_droga.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_droga.title');
    }
}
