<?php

namespace App\Filament\Resources\Neoplasias\Pages;

use App\Filament\Resources\Neoplasias\NeoplasiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNeoplasia extends EditRecord
{
    protected static string $resource = NeoplasiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_neoplasia.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_neoplasia.title');
    }
}
