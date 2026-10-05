<?php

namespace App\Filament\Resources\Alcool35s\Pages;

use App\Filament\Resources\Alcool35s\Alcool35Resource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlcool35 extends EditRecord
{
    protected static string $resource = Alcool35Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_alcool35.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_alcool35.title');
    }
}
