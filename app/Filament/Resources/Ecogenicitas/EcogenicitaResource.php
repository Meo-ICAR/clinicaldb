<?php

namespace App\Filament\Resources\Ecogenicitas;

use App\Filament\LookupResource;
use App\Filament\Resources\Ecogenicitas\Pages\CreateEcogenicita;
use App\Filament\Resources\Ecogenicitas\Pages\EditEcogenicita;
use App\Filament\Resources\Ecogenicitas\Pages\ListEcogenicitas;
use App\Models\Ecogenicita;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EcogenicitaResource extends LookupResource
{
    protected static ?string $model = Ecogenicita::class;

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
            'index' => ListEcogenicitas::route('/'),
            'create' => CreateEcogenicita::route('/create'),
            'edit' => EditEcogenicita::route('/{record}/edit'),
        ];
    }
}
