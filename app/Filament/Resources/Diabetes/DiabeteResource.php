<?php

namespace App\Filament\Resources\Diabetes;

use App\Filament\LookupResource;
use App\Filament\Resources\Diabetes\Pages\CreateDiabete;
use App\Filament\Resources\Diabetes\Pages\EditDiabete;
use App\Filament\Resources\Diabetes\Pages\ListDiabetes;
use App\Models\Diabete;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DiabeteResource extends LookupResource
{
    protected static ?string $model = Diabete::class;

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
            'index' => ListDiabetes::route('/'),
            'create' => CreateDiabete::route('/create'),
            'edit' => EditDiabete::route('/{record}/edit'),
        ];
    }
}
