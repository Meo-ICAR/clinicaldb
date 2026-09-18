<?php

namespace App\Filament\Resources\Alcools;

use App\Filament\LookupResource;
use App\Filament\Resources\Alcools\Pages\CreateAlcool;
use App\Filament\Resources\Alcools\Pages\EditAlcool;
use App\Filament\Resources\Alcools\Pages\ListAlcools;
use App\Models\Alcool;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlcoolResource extends LookupResource
{
    protected static ?string $model = Alcool::class;

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
            'index' => ListAlcools::route('/'),
            'create' => CreateAlcool::route('/create'),
            'edit' => EditAlcool::route('/{record}/edit'),
        ];
    }
}
