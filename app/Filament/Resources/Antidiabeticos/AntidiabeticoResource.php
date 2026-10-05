<?php

namespace App\Filament\Resources\Antidiabeticos;

use App\Filament\LookupResource;
use App\Filament\Resources\Antidiabeticos\Pages\CreateAntidiabetico;
use App\Filament\Resources\Antidiabeticos\Pages\EditAntidiabetico;
use App\Filament\Resources\Antidiabeticos\Pages\ListAntidiabeticos;
use App\Models\Antidiabetico;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AntidiabeticoResource extends LookupResource
{
    protected static ?string $model = Antidiabetico::class;

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
            'index' => ListAntidiabeticos::route('/'),
            'create' => CreateAntidiabetico::route('/create'),
            'edit' => EditAntidiabetico::route('/{record}/edit'),
        ];
    }
}
