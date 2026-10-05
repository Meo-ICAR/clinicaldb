<?php

namespace App\Filament\Resources\Ictuses;

use App\Filament\LookupResource;
use App\Filament\Resources\Ictuses\Pages\CreateIctus;
use App\Filament\Resources\Ictuses\Pages\EditIctus;
use App\Filament\Resources\Ictuses\Pages\ListIctuses;
use App\Models\Ictus;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IctusResource extends LookupResource
{
    protected static ?string $model = Ictus::class;

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
            'index' => ListIctuses::route('/'),
            'create' => CreateIctus::route('/create'),
            'edit' => EditIctus::route('/{record}/edit'),
        ];
    }
}
