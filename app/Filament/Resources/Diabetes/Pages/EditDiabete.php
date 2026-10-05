<?php

namespace App\Filament\Resources\Diabetes\Pages;

use App\Filament\Resources\Diabetes\DiabeteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDiabete extends EditRecord
{
    protected static string $resource = DiabeteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_diabete.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_diabete.title');
    }
}
