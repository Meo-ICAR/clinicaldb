<?php

namespace App\Filament\Resources\TrattamentoCausaAbbandonos;

use App\Filament\LookupResource;
use App\Filament\Resources\TrattamentoCausaAbbandonos\Pages\CreateTrattamentoCausaAbbandono;
use App\Filament\Resources\TrattamentoCausaAbbandonos\Pages\EditTrattamentoCausaAbbandono;
use App\Filament\Resources\TrattamentoCausaAbbandonos\Pages\ListTrattamentoCausaAbbandonos;
use App\Models\TrattamentoCausaAbbandono;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrattamentoCausaAbbandonoResource extends LookupResource
{
    protected static ?string $model = TrattamentoCausaAbbandono::class;

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
            'index' => ListTrattamentoCausaAbbandonos::route('/'),
            'create' => CreateTrattamentoCausaAbbandono::route('/create'),
            'edit' => EditTrattamentoCausaAbbandono::route('/{record}/edit'),
        ];
    }
}
