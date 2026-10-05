<?php

namespace App\Filament\Resources\FieldReferenceRanges\Pages;

use App\Filament\Resources\FieldReferenceRanges\FieldReferenceRangeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFieldReferenceRange extends EditRecord
{
    protected static string $resource = FieldReferenceRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/edit_field_reference_range.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/edit_field_reference_range.title');
    }
}
