<?php

namespace App\Filament\Resources\FieldReferenceRanges\Pages;

use App\Filament\Resources\FieldReferenceRanges\FieldReferenceRangeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFieldReferenceRanges extends ListRecords
{
    protected static string $resource = FieldReferenceRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('filament/admin/list_field_reference_ranges.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/list_field_reference_ranges.title');
    }
}
