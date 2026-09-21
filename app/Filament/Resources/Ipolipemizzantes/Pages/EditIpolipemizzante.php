<?php

namespace App\Filament\Resources\Ipolipemizzantes\Pages;

use App\Filament\Resources\Ipolipemizzantes\IpolipemizzanteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIpolipemizzante extends EditRecord
{
    protected static string $resource = IpolipemizzanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_ipolipemizzante.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_ipolipemizzante.title');
    }
}
