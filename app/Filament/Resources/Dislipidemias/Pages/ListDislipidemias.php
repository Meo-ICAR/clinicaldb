<?php

namespace App\Filament\Resources\Dislipidemias\Pages;

use App\Filament\Resources\Dislipidemias\DislipidemiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDislipidemias extends ListRecords
{
    protected static string $resource = DislipidemiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_dislipidemias.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_dislipidemias.title');
    }
}
