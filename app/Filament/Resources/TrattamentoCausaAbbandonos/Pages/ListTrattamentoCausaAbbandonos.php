<?php

namespace App\Filament\Resources\TrattamentoCausaAbbandonos\Pages;

use App\Filament\Resources\TrattamentoCausaAbbandonos\TrattamentoCausaAbbandonoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrattamentoCausaAbbandonos extends ListRecords
{
    protected static string $resource = TrattamentoCausaAbbandonoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_trattamento_causa_abbandonos.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_trattamento_causa_abbandonos.title');
    }
}
