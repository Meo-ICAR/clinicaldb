<?php

namespace App\Filament\Resources\Stenosis\Pages;

use App\Filament\Resources\Stenosis\StenosiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStenosi extends EditRecord
{
    protected static string $resource = StenosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_stenosi.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_stenosi.title');
    }
}
