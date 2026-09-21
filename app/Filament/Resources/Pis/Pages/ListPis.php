<?php

namespace App\Filament\Resources\Pis\Pages;

use App\Filament\Resources\Pis\PiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPis extends ListRecords
{
    protected static string $resource = PiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_pis.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_pis.title');
    }
}
