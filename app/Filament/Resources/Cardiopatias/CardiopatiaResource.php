<?php

namespace App\Filament\Resources\Cardiopatias;

use App\Filament\LookupResource;
use App\Filament\Resources\Cardiopatias\Pages\CreateCardiopatia;
use App\Filament\Resources\Cardiopatias\Pages\EditCardiopatia;
use App\Filament\Resources\Cardiopatias\Pages\ListCardiopatias;
use App\Models\Cardiopatia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CardiopatiaResource extends LookupResource
{
    protected static ?string $model = Cardiopatia::class;

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
            'index' => ListCardiopatias::route('/'),
            'create' => CreateCardiopatia::route('/create'),
            'edit' => EditCardiopatia::route('/{record}/edit'),
        ];
    }
}
