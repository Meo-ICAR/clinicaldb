<?php

namespace App\Filament\Resources\Endolumiales\Pages;

use App\Filament\Resources\Endolumiales\EndolumialeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEndolumiale extends EditRecord
{
    protected static string $resource = EndolumialeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_endolumiale.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_endolumiale.title');
    }
}
