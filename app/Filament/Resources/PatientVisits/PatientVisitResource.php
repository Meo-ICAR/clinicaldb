<?php

namespace App\Filament\Resources\PatientVisits;

use App\Filament\Resources\PatientVisits\Pages\CreatePatientVisit;
use App\Filament\Resources\PatientVisits\Pages\EditPatientVisit;
use App\Filament\Resources\PatientVisits\Pages\ListPatientVisits;
use App\Filament\Resources\PatientVisits\Schemas\PatientVisitForm;
use App\Filament\Resources\PatientVisits\Tables\PatientVisitsTable;
use App\Models\PatientVisit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PatientVisitResource extends Resource
{
    protected static ?string $model = PatientVisit::class;

    protected static ?string $navigationLabel = 'Visite';

    protected static ?string $modelLabel = 'visita';

    protected static ?string $pluralModelLabel = 'visite';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return PatientVisitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientVisitsTable::configure($table);
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
            'index' => ListPatientVisits::route('/'),
            'create' => CreatePatientVisit::route('/create'),
            'edit' => EditPatientVisit::route('/{record}/edit'),
        ];
    }
}
