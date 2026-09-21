<?php

namespace App\Filament\Resources\Farmacos\Pages;

use App\Filament\Resources\Farmacos\FarmacoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmaco extends EditRecord
{
    protected static string $resource = FarmacoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_farmaco.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_farmaco.title');
    }
}
