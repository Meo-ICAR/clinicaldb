<?php

namespace App\Filament\Resources\Nrtis;

use App\Filament\LookupResource;
use App\Filament\Resources\Nrtis\Pages\CreateNrti;
use App\Filament\Resources\Nrtis\Pages\EditNrti;
use App\Filament\Resources\Nrtis\Pages\ListNrtis;
use App\Models\Nrti;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NrtiResource extends LookupResource
{
    protected static ?string $model = Nrti::class;

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
            'index' => ListNrtis::route('/'),
            'create' => CreateNrti::route('/create'),
            'edit' => EditNrti::route('/{record}/edit'),
        ];
    }
}
