<?php

namespace App\Filament\Resources\InfezioneHivs\Pages;

use App\Filament\Resources\InfezioneHivs\InfezioneHivResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfezioneHivs extends ListRecords
{
    protected static string $resource = InfezioneHivResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_infezione_hivs.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_infezione_hivs.title');
    }
}
