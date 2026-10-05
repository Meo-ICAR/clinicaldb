<?php

namespace App\Filament\Resources\Pis;

use App\Filament\LookupResource;
use App\Filament\Resources\Pis\Pages\CreatePi;
use App\Filament\Resources\Pis\Pages\EditPi;
use App\Filament\Resources\Pis\Pages\ListPis;
use App\Models\Pi;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PiResource extends LookupResource
{
    protected static ?string $model = Pi::class;

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
            'index' => ListPis::route('/'),
            'create' => CreatePi::route('/create'),
            'edit' => EditPi::route('/{record}/edit'),
        ];
    }
}
