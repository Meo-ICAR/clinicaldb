<?php

namespace App\Filament\Resources\Trattamentos\Pages;

use App\Filament\Resources\Trattamentos\TrattamentoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrattamento extends EditRecord
{
    protected static string $resource = TrattamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_trattamento.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_trattamento.title');
    }
}
