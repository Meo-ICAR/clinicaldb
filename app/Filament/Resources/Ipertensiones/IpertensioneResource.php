<?php

namespace App\Filament\Resources\Ipertensiones;

use App\Filament\LookupResource;
use App\Filament\Resources\Ipertensiones\Pages\CreateIpertensione;
use App\Filament\Resources\Ipertensiones\Pages\EditIpertensione;
use App\Filament\Resources\Ipertensiones\Pages\ListIpertensiones;
use App\Models\Ipertensione;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IpertensioneResource extends LookupResource
{
    protected static ?string $model = Ipertensione::class;

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
            'index' => ListIpertensiones::route('/'),
            'create' => CreateIpertensione::route('/create'),
            'edit' => EditIpertensione::route('/{record}/edit'),
        ];
    }
}
