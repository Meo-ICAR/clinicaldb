<?php

namespace App\Filament\Resources\Inis;

use App\Filament\LookupResource;
use App\Filament\Resources\Inis\Pages\CreateIni;
use App\Filament\Resources\Inis\Pages\EditIni;
use App\Filament\Resources\Inis\Pages\ListInis;
use App\Models\Ini;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IniResource extends LookupResource
{
    protected static ?string $model = Ini::class;

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
            'index' => ListInis::route('/'),
            'create' => CreateIni::route('/create'),
            'edit' => EditIni::route('/{record}/edit'),
        ];
    }
}
