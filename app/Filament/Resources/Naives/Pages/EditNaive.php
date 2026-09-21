<?php

namespace App\Filament\Resources\Naives\Pages;

use App\Filament\Resources\Naives\NaiveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNaive extends EditRecord
{
    protected static string $resource = NaiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_naive.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_naive.title');
    }
}
