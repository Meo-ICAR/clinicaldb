<?php

namespace App\Filament\Resources\Etnias;

use App\Filament\LookupResource;
use App\Filament\Resources\Etnias\Pages\CreateEtnia;
use App\Filament\Resources\Etnias\Pages\EditEtnia;
use App\Filament\Resources\Etnias\Pages\ListEtnias;
use App\Models\Etnia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EtniaResource extends LookupResource
{
    protected static ?string $model = Etnia::class;

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
            'index' => ListEtnias::route('/'),
            'create' => CreateEtnia::route('/create'),
            'edit' => EditEtnia::route('/{record}/edit'),
        ];
    }
}
