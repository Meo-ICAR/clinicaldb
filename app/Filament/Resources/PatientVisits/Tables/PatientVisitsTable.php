<?php

namespace App\Filament\Resources\PatientVisits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class PatientVisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.pazientecode')->label('Paziente')->searchable()->sortable(),
                TextColumn::make('visitadel')->label('Data visita')->date('d/m/Y')->sortable(),
                TextColumn::make('centrocode')->label('Centro')->searchable(),
                TextColumn::make('CD4')->label('CD4')->numeric()->sortable(),
                TextColumn::make('HIVRNA')->label('HIV RNA')->numeric()->sortable(),
                TextColumn::make('peso')->label('Peso')->numeric(),
                IconColumn::make('HIVRNAnorilevabile')->label('RNA non rilevabile')->boolean(),
                IconColumn::make('active')->label('Attiva')->boolean(),
            ])
            ->headerActions([
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->defaultSort('visitadel', 'desc')
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
