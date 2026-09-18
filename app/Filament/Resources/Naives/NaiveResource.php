<?php

namespace App\Filament\Resources\Naives;

use App\Filament\LookupResource;
use App\Filament\Resources\Naives\Pages\CreateNaive;
use App\Filament\Resources\Naives\Pages\EditNaive;
use App\Filament\Resources\Naives\Pages\ListNaives;
use App\Models\Naive;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NaiveResource extends LookupResource
{
    protected static ?string $model = Naive::class;

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
            'index' => ListNaives::route('/'),
            'create' => CreateNaive::route('/create'),
            'edit' => EditNaive::route('/{record}/edit'),
        ];
    }
}
