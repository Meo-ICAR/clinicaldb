<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TreatmentAnnotationsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = null;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('Trattamentonuovodal')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentonuovodal')),
            TextInput::make('Trattamentonuovo')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentonuovo')),
            TextInput::make('Trattamentovecchio')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentovecchio')),
            Textarea::make('annotazione')->label(__('filament/admin/treatment_annotations_relation_manager.annotazione'))->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->where(function (Builder $query): void {
                $query
                    ->whereNotNull('Trattamentonuovo')
                    ->where('Trattamentonuovo', '<>', '')
                    ->orWhereNotNull('Trattamentonuovodal')
                    ->orWhere(function (Builder $query): void {
                        $query->whereNotNull('Trattamentovecchio')->where('Trattamentovecchio', '<>', '');
                    })
                    ->orWhere(function (Builder $query): void {
                        $query->whereNotNull('annotazione')->where('annotazione', '<>', '');
                    });
            }))
            ->columns([
                TextColumn::make('Trattamentonuovo')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentonuovo'))->searchable(),
                TextColumn::make('Trattamentonuovodal')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentonuovodal'))->date('d/m/Y')->sortable(),
                TextColumn::make('Trattamentovecchio')->label(__('filament/admin/treatment_annotations_relation_manager.trattamentovecchio'))->searchable(),
                TextColumn::make('annotazione')->label(__('filament/admin/treatment_annotations_relation_manager.annotazione'))->limit(80)->wrap(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('filament/admin/treatment_annotations_relation_manager.create')),
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('filament/admin/treatment_annotations_relation_manager.edit')),
                DeleteAction::make()
                    ->label(__('filament/admin/treatment_annotations_relation_manager.delete')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament/admin/treatment_annotations_relation_manager.title');
    }
}
