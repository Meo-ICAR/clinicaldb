<?php

namespace App\Filament\Resources\Cardiopatias\Pages;

use App\Filament\Resources\Cardiopatias\CardiopatiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCardiopatias extends ListRecords
{
    protected static string $resource = CardiopatiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_cardiopatias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_cardiopatias.title');
    }
}
