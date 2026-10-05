<?php

namespace App\Filament\Resources\Nrtis\Pages;

use App\Filament\Resources\Nrtis\NrtiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNrti extends EditRecord
{
    protected static string $resource = NrtiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_nrti.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_nrti.title');
    }
}
