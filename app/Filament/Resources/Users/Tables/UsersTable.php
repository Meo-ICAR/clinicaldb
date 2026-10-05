<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use App\Notifications\WelcomeNewVersion;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_name')
                    ->label(__('filament/admin/user_resource.last_name'))
                    ->formatStateUsing(fn (string $state, User $record): string => $record->getFilamentName())
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('center')
                    ->label(__('filament/admin/user_resource.center'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('centercode')
                    ->label(__('filament/admin/user_resource.centercode'))
                    ->sortable(),
                TextColumn::make('role')
                    ->label(__('filament/admin/user_resource.role'))
                    ->badge()
                    ->sortable(),
                IconColumn::make('active')
                    ->label(__('filament/admin/user_resource.active'))
                    ->boolean(),
                TextColumn::make('inserted_patients_count')
                    ->label(__('filament/admin/user_resource.inserted_patients_count'))
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('performed_visits_count')
                    ->label(__('filament/admin/user_resource.performed_visits_count'))
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('patients_modified_count')
                    ->label(__('filament/admin/user_resource.patients_modified_count'))
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('visits_modified_count')
                    ->label(__('filament/admin/user_resource.visits_modified_count'))
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('')),
                TextColumn::make('last_login')
                    ->label(__('filament/admin/user_resource.last_login'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                ExportAction::make()->label(__('filament/admin/user_resource.export')),
            ])
            ->filters([
                SelectFilter::make('centercode')
                    ->label(__('filament/admin/user_resource.centercode'))
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable(),
                SelectFilter::make('active')
                    ->label(__('filament/admin/user_resource.active'))
                    ->options([
                        1 => 'Solo attivi',
                        0 => 'Non attivi',
                    ])
                    ->default(1),
                SelectFilter::make('has_activity')
                    ->label(__('filament/admin/user_resource.has_activity'))
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
                    ->label(__('filament/admin/user_resource.activity_period'))
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
            ->groups([
                Group::make('centercode')
                    ->label('Centro')
                    ->getTitleFromRecordUsing(fn (User $record): string => $record->center ?: ($record->centercode ?: 'Senza centro')),
            ])
            ->defaultGroup('centercode')
            ->persistGroupInSession()
            ->defaultSort('center')
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('sendWelcomeEmail')
                        ->label('Invia welcome email')
                        ->icon(Heroicon::Envelope)
                        ->requiresConfirmation()
                        ->modalDescription('Verrà inviata una email di benvenuto e la password di ciascun utente selezionato sarà reimpostata a "demo1234".')
                        ->action(function (Collection $records): void {
                            $records->each(function (User $user): void {
                                $user->password = 'demo1234';
                                $user->save();

                                $user->notify(new WelcomeNewVersion('demo1234'));
                            });

                            Notification::make()
                                ->title('Welcome email inviate')
                                ->body($records->count().' utenti hanno ricevuto la email di benvenuto.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
