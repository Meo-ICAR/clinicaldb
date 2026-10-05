<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\PatientVisits\Schemas\PatientVisitForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = 'Visite del paziente';

    public function form(Schema $schema): Schema
    {
        return PatientVisitForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pazientecode')
            ->columns([
                TextColumn::make('visitadel')->label('Data visita')->date('d/m/Y')->sortable(),
                TextColumn::make('centrocode')->label('Centro')->searchable(),
                TextColumn::make('CD4')->label('CD4')->numeric()->sortable(),
                TextColumn::make('HIVRNA')->label('HIV RNA')->numeric()->sortable(),
                TextColumn::make('peso')->label('Peso')->numeric(),
                TextColumn::make('PAS')->label('PAS')->numeric(),
                TextColumn::make('PAD')->label('PAD')->numeric(),
                TextColumn::make('Trattamentonuovo')->label('Nuovo trattamento')->searchable(),
            ])
            ->headerActions([
                CreateAction::make(),
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
