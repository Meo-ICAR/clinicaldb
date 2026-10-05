<?php

namespace App\Filament\Resources\Drogas;

use App\Filament\LookupResource;
use App\Filament\Resources\Drogas\Pages\CreateDroga;
use App\Filament\Resources\Drogas\Pages\EditDroga;
use App\Filament\Resources\Drogas\Pages\ListDrogas;
use App\Models\Droga;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DrogaResource extends LookupResource
{
    protected static ?string $model = Droga::class;

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
            'index' => ListDrogas::route('/'),
            'create' => CreateDroga::route('/create'),
            'edit' => EditDroga::route('/{record}/edit'),
        ];
    }
}
