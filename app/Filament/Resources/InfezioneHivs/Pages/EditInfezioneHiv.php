<?php

namespace App\Filament\Resources\InfezioneHivs\Pages;

use App\Filament\Resources\InfezioneHivs\InfezioneHivResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInfezioneHiv extends EditRecord
{
    protected static string $resource = InfezioneHivResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_infezione_hiv.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_infezione_hiv.title');
    }
}
