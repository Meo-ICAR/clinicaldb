<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_name')
                    ->label('Specialista')
                    ->formatStateUsing(fn (string $state, User $record): string => $record->getFilamentName())
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('center')
                    ->label('Centro')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('centercode')
                    ->label('Codice centro')
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Ruolo')
                    ->badge()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Afferenza attiva')
                    ->boolean(),
                TextColumn::make('inserted_patients_count')
                    ->label('Pazienti inseriti')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('performed_visits_count')
                    ->label('Visite effettuate')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('patients_modified_count')
                    ->label('Pazienti modificati')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('visits_modified_count')
                    ->label('Visite modificate')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('last_login')
                    ->label('Ultimo accesso')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                ExportAction::make()->label('Esporta Excel'),
            ])
            ->filters([
                SelectFilter::make('centercode')
                    ->label('Centro')
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable(),
                SelectFilter::make('active')
                    ->label('Afferenza')
                    ->options([
                        1 => 'Solo attivi',
                        0 => 'Non attivi',
                    ])
                    ->default(1),
                SelectFilter::make('has_activity')
                    ->label('Attività presente')
                    ->options([
                        1 => 'Solo con pazienti o visite',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ((int) ($data['value'] ?? 0) !== 1) {
                            return $query;
                        }

                        return $query->where(function (Builder $query): void {
                            $query
                                ->whereHas('insertedPatients')
                                ->orWhereHas('performedVisits');
                        });
                    }),
                SelectFilter::make('activity_period')
                    ->label('Attività modificata')
                    ->options([
                        6 => 'Ultimi 6 mesi',
                        12 => 'Ultimi 12 mesi',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $months = (int) ($data['value'] ?? 0);

                        if ($months === 0) {
                            return $query;
                        }

                        $since = now()->subMonths($months);

                        return $query
                            ->select($query->getModel()->getTable().'.*')
                            ->withActivityCounts($since)
                            ->where(function (Builder $query) use ($since): void {
                                $query
                                    ->whereHas('modifiedPatients', fn (Builder $query): Builder => $query->where('modified', '>=', $since))
                                    ->orWhereHas('modifiedVisits', fn (Builder $query): Builder => $query->where('modified', '>=', $since));
                            });
                    }),
            ])
            ->defaultGroup(
                Group::make('centercode')
                    ->label('Centro')
                    ->getTitleFromRecordUsing(fn (User $record): string => $record->center ?: ($record->centercode ?: 'Senza centro')),
            )
            ->persistGroupInSession()
            ->defaultSort('center')
            ->recordActions([]);
    }
}
