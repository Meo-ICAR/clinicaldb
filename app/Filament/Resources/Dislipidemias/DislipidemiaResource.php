<?php

namespace App\Filament\Resources\Dislipidemias;

use App\Filament\LookupResource;
use App\Filament\Resources\Dislipidemias\Pages\CreateDislipidemia;
use App\Filament\Resources\Dislipidemias\Pages\EditDislipidemia;
use App\Filament\Resources\Dislipidemias\Pages\ListDislipidemias;
use App\Models\Dislipidemia;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DislipidemiaResource extends LookupResource
{
    protected static ?string $model = Dislipidemia::class;

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
            'index' => ListDislipidemias::route('/'),
            'create' => CreateDislipidemia::route('/create'),
            'edit' => EditDislipidemia::route('/{record}/edit'),
        ];
    }
}
