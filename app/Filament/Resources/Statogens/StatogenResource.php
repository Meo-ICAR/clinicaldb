<?php

namespace App\Filament\Resources\Statogens;

use App\Filament\LookupResource;
use App\Filament\Resources\Statogens\Pages\CreateStatogen;
use App\Filament\Resources\Statogens\Pages\EditStatogen;
use App\Filament\Resources\Statogens\Pages\ListStatogens;
use App\Models\Statogen;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StatogenResource extends LookupResource
{
    protected static ?string $model = Statogen::class;

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
            'index' => ListStatogens::route('/'),
            'create' => CreateStatogen::route('/create'),
            'edit' => EditStatogen::route('/{record}/edit'),
        ];
    }
}
