<?php

namespace App\Filament\Resources\Dislipidemias\Pages;

use App\Filament\Resources\Dislipidemias\DislipidemiaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDislipidemia extends EditRecord
{
    protected static string $resource = DislipidemiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_dislipidemia.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_dislipidemia.title');
    }
}
