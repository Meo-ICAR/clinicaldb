<?php

namespace App\Filament\Resources\FieldReferenceRanges;

use App\Filament\Resources\FieldReferenceRanges\Pages\CreateFieldReferenceRange;
use App\Filament\Resources\FieldReferenceRanges\Pages\EditFieldReferenceRange;
use App\Filament\Resources\FieldReferenceRanges\Pages\ListFieldReferenceRanges;
use App\Filament\Resources\FieldReferenceRanges\Schemas\FieldReferenceRangeForm;
use App\Filament\Resources\FieldReferenceRanges\Tables\FieldReferenceRangesTable;
use App\Models\FieldReferenceRange;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FieldReferenceRangeResource extends Resource
{
    protected static ?string $model = FieldReferenceRange::class;

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    protected static string|UnitEnum|null $navigationGroup = 'Amministrazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FieldReferenceRangeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldReferenceRangesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFieldReferenceRanges::route('/'),
            'create' => CreateFieldReferenceRange::route('/create'),
            'edit' => EditFieldReferenceRange::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/field_reference_range_resource.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament/admin/field_reference_range_resource.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament/admin/field_reference_range_resource.plural_model_label');
    }
}
