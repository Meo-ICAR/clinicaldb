<?php

namespace App\Filament\Resources\Trattamentos;

use App\Filament\LookupResource;
use App\Filament\Resources\Trattamentos\Pages\CreateTrattamento;
use App\Filament\Resources\Trattamentos\Pages\EditTrattamento;
use App\Filament\Resources\Trattamentos\Pages\ListTrattamentos;
use App\Models\Trattamento;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrattamentoResource extends LookupResource
{
    protected static ?string $model = Trattamento::class;

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
            'index' => ListTrattamentos::route('/'),
            'create' => CreateTrattamento::route('/create'),
            'edit' => EditTrattamento::route('/{record}/edit'),
        ];
    }
}
