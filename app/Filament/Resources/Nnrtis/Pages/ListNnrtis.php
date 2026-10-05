<?php

namespace App\Filament\Resources\Nnrtis\Pages;

use App\Filament\Resources\Nnrtis\NnrtiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNnrtis extends ListRecords
{
    protected static string $resource = NnrtiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_nnrtis.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_nnrtis.title');
    }
}
