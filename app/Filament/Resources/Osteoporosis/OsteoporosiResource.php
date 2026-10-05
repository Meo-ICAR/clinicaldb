<?php

namespace App\Filament\Resources\Osteoporosis;

use App\Filament\LookupResource;
use App\Filament\Resources\Osteoporosis\Pages\CreateOsteoporosi;
use App\Filament\Resources\Osteoporosis\Pages\EditOsteoporosi;
use App\Filament\Resources\Osteoporosis\Pages\ListOsteoporosis;
use App\Models\Osteoporosi;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OsteoporosiResource extends LookupResource
{
    protected static ?string $model = Osteoporosi::class;

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
            'index' => ListOsteoporosis::route('/'),
            'create' => CreateOsteoporosi::route('/create'),
            'edit' => EditOsteoporosi::route('/{record}/edit'),
        ];
    }
}
