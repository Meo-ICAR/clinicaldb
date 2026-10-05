<?php

namespace App\Filament\Resources\Inis\Pages;

use App\Filament\Resources\Inis\IniResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIni extends EditRecord
{
    protected static string $resource = IniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_ini.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_ini.title');
    }
}
