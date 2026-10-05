<?php

namespace App\Filament\Resources\Lipodistrofias;

use App\Filament\LookupResource;
use App\Filament\Resources\Lipodistrofias\Pages\CreateLipodistrofia;
use App\Filament\Resources\Lipodistrofias\Pages\EditLipodistrofia;
use App\Filament\Resources\Lipodistrofias\Pages\ListLipodistrofias;
use App\Models\Lipodistrofia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LipodistrofiaResource extends LookupResource
{
    protected static ?string $model = Lipodistrofia::class;

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
            'index' => ListLipodistrofias::route('/'),
            'create' => CreateLipodistrofia::route('/create'),
            'edit' => EditLipodistrofia::route('/{record}/edit'),
        ];
    }
}
