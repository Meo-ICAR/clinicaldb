<?php

namespace App\Filament\Resources\Nnrtis\Pages;

use App\Filament\Resources\Nnrtis\NnrtiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNnrti extends EditRecord
{
    protected static string $resource = NnrtiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_nnrti.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_nnrti.title');
    }
}
