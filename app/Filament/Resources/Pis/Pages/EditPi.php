<?php

namespace App\Filament\Resources\Pis\Pages;

use App\Filament\Resources\Pis\PiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPi extends EditRecord
{
    protected static string $resource = PiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_pi.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_pi.title');
    }
}
