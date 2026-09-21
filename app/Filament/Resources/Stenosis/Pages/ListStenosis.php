<?php

namespace App\Filament\Resources\Stenosis\Pages;

use App\Filament\Resources\Stenosis\StenosiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStenosis extends ListRecords
{
    protected static string $resource = StenosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_stenosis.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_stenosis.title');
    }
}
