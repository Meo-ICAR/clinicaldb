<?php

namespace App\Filament\Resources\Farmacos;

use App\Filament\LookupResource;
use App\Filament\Resources\Farmacos\Pages\CreateFarmaco;
use App\Filament\Resources\Farmacos\Pages\EditFarmaco;
use App\Filament\Resources\Farmacos\Pages\ListFarmacos;
use App\Models\Farmaco;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FarmacoResource extends LookupResource
{
    protected static ?string $model = Farmaco::class;

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
            'index' => ListFarmacos::route('/'),
            'create' => CreateFarmaco::route('/create'),
            'edit' => EditFarmaco::route('/{record}/edit'),
        ];
    }
}
