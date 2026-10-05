<?php

namespace App\Filament\Resources\Insuffrenales;

use App\Filament\LookupResource;
use App\Filament\Resources\Insuffrenales\Pages\CreateInsuffrenale;
use App\Filament\Resources\Insuffrenales\Pages\EditInsuffrenale;
use App\Filament\Resources\Insuffrenales\Pages\ListInsuffrenales;
use App\Models\Insuffrenale;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InsuffrenaleResource extends LookupResource
{
    protected static ?string $model = Insuffrenale::class;

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
            'index' => ListInsuffrenales::route('/'),
            'create' => CreateInsuffrenale::route('/create'),
            'edit' => EditInsuffrenale::route('/{record}/edit'),
        ];
    }
}
