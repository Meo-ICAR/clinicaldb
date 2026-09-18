<?php

namespace App\Filament\Resources\Stenosis;

use App\Filament\LookupResource;
use App\Filament\Resources\Stenosis\Pages\CreateStenosi;
use App\Filament\Resources\Stenosis\Pages\EditStenosi;
use App\Filament\Resources\Stenosis\Pages\ListStenosis;
use App\Models\Stenosi;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StenosiResource extends LookupResource
{
    protected static ?string $model = Stenosi::class;

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
            'index' => ListStenosis::route('/'),
            'create' => CreateStenosi::route('/create'),
            'edit' => EditStenosi::route('/{record}/edit'),
        ];
    }
}
