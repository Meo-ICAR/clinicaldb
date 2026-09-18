<?php

namespace App\Filament\Resources\Fumos;

use App\Filament\LookupResource;
use App\Filament\Resources\Fumos\Pages\CreateFumo;
use App\Filament\Resources\Fumos\Pages\EditFumo;
use App\Filament\Resources\Fumos\Pages\ListFumos;
use App\Models\Fumo;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FumoResource extends LookupResource
{
    protected static ?string $model = Fumo::class;

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
            'index' => ListFumos::route('/'),
            'create' => CreateFumo::route('/create'),
            'edit' => EditFumo::route('/{record}/edit'),
        ];
    }
}
