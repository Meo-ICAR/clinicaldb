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
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TreatmentAnnotationsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = 'Trattamento e annotazioni';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('Trattamentonuovodal')->label('Nuovo trattamento dal'),
            TextInput::make('Trattamentonuovo')->label('Nuovo trattamento'),
            TextInput::make('Trattamentovecchio')->label('Trattamento precedente'),
            Textarea::make('annotazione')->label('Annotazione')->columnSpanFull(),
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
                TextColumn::make('Trattamentonuovo')->label('Nuovo trattamento')->searchable(),
                TextColumn::make('Trattamentonuovodal')->label('Dal')->date('d/m/Y')->sortable(),
                TextColumn::make('Trattamentovecchio')->label('Trattamento precedente')->searchable(),
                TextColumn::make('annotazione')->label('Annotazione')->limit(80)->wrap(),
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
