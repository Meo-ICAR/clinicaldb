<?php

namespace App\Filament\Resources\Osteoporosis\Pages;

use App\Filament\Resources\Osteoporosis\OsteoporosiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOsteoporosi extends EditRecord
{
    protected static string $resource = OsteoporosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_osteoporosi.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_osteoporosi.title');
    }
}
