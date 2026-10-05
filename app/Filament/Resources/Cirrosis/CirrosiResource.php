<?php

namespace App\Filament\Resources\Cirrosis;

use App\Filament\LookupResource;
use App\Filament\Resources\Cirrosis\Pages\CreateCirrosi;
use App\Filament\Resources\Cirrosis\Pages\EditCirrosi;
use App\Filament\Resources\Cirrosis\Pages\ListCirrosis;
use App\Models\Cirrosi;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CirrosiResource extends LookupResource
{
    protected static ?string $model = Cirrosi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return parent::form($schema);
    }

    public static function table(Table $table): Table
    {
        return parent::table($table);
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
            'index' => ListCirrosis::route('/'),
            'create' => CreateCirrosi::route('/create'),
            'edit' => EditCirrosi::route('/{record}/edit'),
        ];
    }
}
