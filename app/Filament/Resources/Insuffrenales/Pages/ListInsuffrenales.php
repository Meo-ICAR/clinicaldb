<?php

namespace App\Filament\Resources\Insuffrenales\Pages;

use App\Filament\Resources\Insuffrenales\InsuffrenaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInsuffrenales extends ListRecords
{
    protected static string $resource = InsuffrenaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_insuffrenales.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_insuffrenales.title');
    }
}
