<?php

namespace App\Filament\Resources\Cirrosis\Pages;

use App\Filament\Resources\Cirrosis\CirrosiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCirrosi extends EditRecord
{
    protected static string $resource = CirrosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_cirrosi.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_cirrosi.title');
    }
}
