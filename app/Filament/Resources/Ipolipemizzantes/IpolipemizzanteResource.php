<?php

namespace App\Filament\Resources\Ipolipemizzantes;

use App\Filament\LookupResource;
use App\Filament\Resources\Ipolipemizzantes\Pages\CreateIpolipemizzante;
use App\Filament\Resources\Ipolipemizzantes\Pages\EditIpolipemizzante;
use App\Filament\Resources\Ipolipemizzantes\Pages\ListIpolipemizzantes;
use App\Models\Ipolipemizzante;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IpolipemizzanteResource extends LookupResource
{
    protected static ?string $model = Ipolipemizzante::class;

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
            'index' => ListIpolipemizzantes::route('/'),
            'create' => CreateIpolipemizzante::route('/create'),
            'edit' => EditIpolipemizzante::route('/{record}/edit'),
        ];
    }
}
