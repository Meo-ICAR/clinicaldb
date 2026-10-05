<?php

namespace App\Filament\Resources\Rischios;

use App\Filament\LookupResource;
use App\Filament\Resources\Rischios\Pages\CreateRischio;
use App\Filament\Resources\Rischios\Pages\EditRischio;
use App\Filament\Resources\Rischios\Pages\ListRischios;
use App\Models\Rischio;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RischioResource extends LookupResource
{
    protected static ?string $model = Rischio::class;

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
            'index' => ListRischios::route('/'),
            'create' => CreateRischio::route('/create'),
            'edit' => EditRischio::route('/{record}/edit'),
        ];
    }
}
