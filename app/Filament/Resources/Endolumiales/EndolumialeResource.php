<?php

namespace App\Filament\Resources\Endolumiales;

use App\Filament\LookupResource;
use App\Filament\Resources\Endolumiales\Pages\CreateEndolumiale;
use App\Filament\Resources\Endolumiales\Pages\EditEndolumiale;
use App\Filament\Resources\Endolumiales\Pages\ListEndolumiales;
use App\Models\Endolumiale;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EndolumialeResource extends LookupResource
{
    protected static ?string $model = Endolumiale::class;

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
            'index' => ListEndolumiales::route('/'),
            'create' => CreateEndolumiale::route('/create'),
            'edit' => EditEndolumiale::route('/{record}/edit'),
        ];
    }
}
