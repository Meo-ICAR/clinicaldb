<?php

namespace App\Filament\Resources\PatientVisits;

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

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

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
            'edit' => EditPatientVisit::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/patient_visit_resource.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament/admin/patient_visit_resource.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament/admin/patient_visit_resource.plural_model_label');
    }
}
