<?php

namespace App\Filament\Resources\Alcool35s;

use App\Filament\LookupResource;
use App\Filament\Resources\Alcool35s\Pages\CreateAlcool35;
use App\Filament\Resources\Alcool35s\Pages\EditAlcool35;
use App\Filament\Resources\Alcool35s\Pages\ListAlcool35s;
use App\Models\Alcool35;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class Alcool35Resource extends LookupResource
{
    protected static ?string $model = Alcool35::class;

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
            'index' => ListAlcool35s::route('/'),
            'create' => CreateAlcool35::route('/create'),
            'edit' => EditAlcool35::route('/{record}/edit'),
        ];
    }
}
