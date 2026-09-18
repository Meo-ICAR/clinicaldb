<?php

namespace App\Filament\Resources\Epatites;

use App\Filament\LookupResource;
use App\Filament\Resources\Epatites\Pages\CreateEpatite;
use App\Filament\Resources\Epatites\Pages\EditEpatite;
use App\Filament\Resources\Epatites\Pages\ListEpatites;
use App\Models\Epatite;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EpatiteResource extends LookupResource
{
    protected static ?string $model = Epatite::class;

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
            'index' => ListEpatites::route('/'),
            'create' => CreateEpatite::route('/create'),
            'edit' => EditEpatite::route('/{record}/edit'),
        ];
    }
}
