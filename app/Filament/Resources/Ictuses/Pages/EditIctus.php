<?php

namespace App\Filament\Resources\Ictuses\Pages;

use App\Filament\Resources\Ictuses\IctusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIctus extends EditRecord
{
    protected static string $resource = IctusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_ictus.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_ictus.title');
    }
}
