<?php

namespace App\Filament\Resources\Neoplasias;

use App\Filament\LookupResource;
use App\Filament\Resources\Neoplasias\Pages\CreateNeoplasia;
use App\Filament\Resources\Neoplasias\Pages\EditNeoplasia;
use App\Filament\Resources\Neoplasias\Pages\ListNeoplasias;
use App\Models\Neoplasia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NeoplasiaResource extends LookupResource
{
    protected static ?string $model = Neoplasia::class;

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
            'index' => ListNeoplasias::route('/'),
            'create' => CreateNeoplasia::route('/create'),
            'edit' => EditNeoplasia::route('/{record}/edit'),
        ];
    }
}
