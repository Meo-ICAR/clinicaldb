<?php

namespace App\Filament\Resources\ArtAltros;

use App\Filament\LookupResource;
use App\Filament\Resources\ArtAltros\Pages\CreateArtAltro;
use App\Filament\Resources\ArtAltros\Pages\EditArtAltro;
use App\Filament\Resources\ArtAltros\Pages\ListArtAltros;
use App\Models\ArtAltro;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArtAltroResource extends LookupResource
{
    protected static ?string $model = ArtAltro::class;

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
            'index' => ListArtAltros::route('/'),
            'create' => CreateArtAltro::route('/create'),
            'edit' => EditArtAltro::route('/{record}/edit'),
        ];
    }
}
