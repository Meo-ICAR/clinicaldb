<?php

namespace App\Filament\Resources\Statogens\Pages;

use App\Filament\Resources\Statogens\StatogenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatogen extends EditRecord
{
    protected static string $resource = StatogenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_statogen.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_statogen.title');
    }
}
