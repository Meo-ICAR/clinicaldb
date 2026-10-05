<?php

namespace App\Filament\Resources\InfezioneHivs;

use App\Filament\LookupResource;
use App\Filament\Resources\InfezioneHivs\Pages\CreateInfezioneHiv;
use App\Filament\Resources\InfezioneHivs\Pages\EditInfezioneHiv;
use App\Filament\Resources\InfezioneHivs\Pages\ListInfezioneHivs;
use App\Models\InfezioneHiv;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfezioneHivResource extends LookupResource
{
    protected static ?string $model = InfezioneHiv::class;

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
            'index' => ListInfezioneHivs::route('/'),
            'create' => CreateInfezioneHiv::route('/create'),
            'edit' => EditInfezioneHiv::route('/{record}/edit'),
        ];
    }
}
