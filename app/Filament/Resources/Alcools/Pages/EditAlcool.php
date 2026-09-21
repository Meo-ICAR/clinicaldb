<?php

namespace App\Filament\Resources\Alcools\Pages;

use App\Filament\Resources\Alcools\AlcoolResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlcool extends EditRecord
{
    protected static string $resource = AlcoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_alcool.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_alcool.title');
    }
}
