<?php

namespace App\Filament\Resources\Infeziones;

use App\Filament\LookupResource;
use App\Filament\Resources\Infeziones\Pages\CreateInfezione;
use App\Filament\Resources\Infeziones\Pages\EditInfezione;
use App\Filament\Resources\Infeziones\Pages\ListInfeziones;
use App\Models\Infezione;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfezioneResource extends LookupResource
{
    protected static ?string $model = Infezione::class;

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
            'index' => ListInfeziones::route('/'),
            'create' => CreateInfezione::route('/create'),
            'edit' => EditInfezione::route('/{record}/edit'),
        ];
    }
}
