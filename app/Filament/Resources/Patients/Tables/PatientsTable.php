<?php

namespace App\Filament\Resources\Patients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pazientecode')->label('Codice')->searchable()->sortable(),
                TextColumn::make('iniziali')->label('Iniziali')->searchable(),
                TextColumn::make('centrocode')->label('Centro')->searchable()->sortable(),
                TextColumn::make('arruolato')->label('Arruolato')->date('d/m/Y')->sortable(),
                TextColumn::make('sesso')->label('Sesso'),
                TextColumn::make('datanascita')->label('Nascita')->date('d/m/Y')->sortable(),
                IconColumn::make('active')->label('Attivo')->boolean(),
            ])
            ->headerActions([
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->defaultSort('arruolato', 'desc')
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
