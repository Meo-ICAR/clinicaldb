<?php

namespace App\Filament\Resources\Sinos;

use App\Filament\LookupResource;
use App\Filament\Resources\Sinos\Pages\CreateSino;
use App\Filament\Resources\Sinos\Pages\EditSino;
use App\Filament\Resources\Sinos\Pages\ListSinos;
use App\Models\Sino;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SinoResource extends LookupResource
{
    protected static ?string $model = Sino::class;

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
            'index' => ListSinos::route('/'),
            'create' => CreateSino::route('/create'),
            'edit' => EditSino::route('/{record}/edit'),
        ];
    }
}
