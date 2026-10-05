<?php

namespace App\Filament\Resources\Lavoros;

use App\Filament\LookupResource;
use App\Filament\Resources\Lavoros\Pages\CreateLavoro;
use App\Filament\Resources\Lavoros\Pages\EditLavoro;
use App\Filament\Resources\Lavoros\Pages\ListLavoros;
use App\Models\Lavoro;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LavoroResource extends LookupResource
{
    protected static ?string $model = Lavoro::class;

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
            'index' => ListLavoros::route('/'),
            'create' => CreateLavoro::route('/create'),
            'edit' => EditLavoro::route('/{record}/edit'),
        ];
    }
}
