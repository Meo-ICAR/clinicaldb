<?php

namespace App\Filament\Resources\ArtTerapias;

use App\Filament\LookupResource;
use App\Filament\Resources\ArtTerapias\Pages\CreateArtTerapia;
use App\Filament\Resources\ArtTerapias\Pages\EditArtTerapia;
use App\Filament\Resources\ArtTerapias\Pages\ListArtTerapias;
use App\Models\ArtTerapia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArtTerapiaResource extends LookupResource
{
    protected static ?string $model = ArtTerapia::class;

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
            'index' => ListArtTerapias::route('/'),
            'create' => CreateArtTerapia::route('/create'),
            'edit' => EditArtTerapia::route('/{record}/edit'),
        ];
    }
}
