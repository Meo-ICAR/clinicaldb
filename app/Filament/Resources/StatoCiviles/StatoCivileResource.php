<?php

namespace App\Filament\Resources\StatoCiviles;

use App\Filament\LookupResource;
use App\Filament\Resources\StatoCiviles\Pages\CreateStatoCivile;
use App\Filament\Resources\StatoCiviles\Pages\EditStatoCivile;
use App\Filament\Resources\StatoCiviles\Pages\ListStatoCiviles;
use App\Models\StatoCivile;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StatoCivileResource extends LookupResource
{
    protected static ?string $model = StatoCivile::class;

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
            'index' => ListStatoCiviles::route('/'),
            'create' => CreateStatoCivile::route('/create'),
            'edit' => EditStatoCivile::route('/{record}/edit'),
        ];
    }
}
