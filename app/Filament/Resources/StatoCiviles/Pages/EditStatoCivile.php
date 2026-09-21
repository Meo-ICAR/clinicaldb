<?php

namespace App\Filament\Resources\StatoCiviles\Pages;

use App\Filament\Resources\StatoCiviles\StatoCivileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatoCivile extends EditRecord
{
    protected static string $resource = StatoCivileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_stato_civile.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_stato_civile.title');
    }
}
