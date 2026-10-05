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
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = null;

    public function form(Schema $schema): Schema
    {
        return PatientVisitForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pazientecode')
            ->columns([
                TextColumn::make('visitadel')->label(__('filament/admin/visits_relation_manager.visitadel'))->date('d/m/Y')->sortable(),
                TextColumn::make('centrocode')->label(__('filament/admin/visits_relation_manager.centrocode'))->searchable(),
                TextColumn::make('CD4')->label(__('filament/admin/visits_relation_manager.c_d4'))->numeric()->sortable(),
                TextColumn::make('HIVRNA')->label(__('filament/admin/visits_relation_manager.h_i_v_r_n_a'))->numeric()->sortable(),
                TextColumn::make('peso')->label(__('filament/admin/visits_relation_manager.peso'))->numeric(),
                TextColumn::make('PAS')->label(__('filament/admin/visits_relation_manager.p_a_s'))->numeric(),
                TextColumn::make('PAD')->label(__('filament/admin/visits_relation_manager.p_a_d'))->numeric(),
                TextColumn::make('Trattamentonuovo')->label(__('filament/admin/visits_relation_manager.trattamentonuovo'))->searchable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('filament/admin/visits_relation_manager.create')),
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('filament/admin/visits_relation_manager.edit')),
                DeleteAction::make()
                    ->label(__('filament/admin/visits_relation_manager.delete')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament/admin/visits_relation_manager.title');
    }
}
