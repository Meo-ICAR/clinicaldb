<?php

namespace App\Filament\Resources\Nnrtis;

use App\Filament\LookupResource;
use App\Filament\Resources\Nnrtis\Pages\CreateNnrti;
use App\Filament\Resources\Nnrtis\Pages\EditNnrti;
use App\Filament\Resources\Nnrtis\Pages\ListNnrtis;
use App\Models\Nnrti;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NnrtiResource extends LookupResource
{
    protected static ?string $model = Nnrti::class;

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
            'index' => ListNnrtis::route('/'),
            'create' => CreateNnrti::route('/create'),
            'edit' => EditNnrti::route('/{record}/edit'),
        ];
    }
}
