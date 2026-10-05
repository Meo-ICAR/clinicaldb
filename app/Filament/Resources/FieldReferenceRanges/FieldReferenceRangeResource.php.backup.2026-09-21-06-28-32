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

    protected static ?string $navigationLabel = 'Range di riferimento';

    protected static ?string $modelLabel = 'range di riferimento';

    protected static ?string $pluralModelLabel = 'range di riferimento';

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
}
