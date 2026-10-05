<?php

namespace App\Filament\Resources\Ipolipemizzantes\Pages;

use App\Filament\Resources\Ipolipemizzantes\IpolipemizzanteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIpolipemizzantes extends ListRecords
{
    protected static string $resource = IpolipemizzanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_ipolipemizzantes.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_ipolipemizzantes.title');
    }
}
