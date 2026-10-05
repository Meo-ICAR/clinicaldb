<?php

namespace App\Filament\Resources\FieldReferenceRanges\Tables;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use App\Models\FieldReferenceRange;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class FieldReferenceRangesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('table')->label('Tabella')->badge()->sortable(),
                TextColumn::make('field')->label('Colonna')->searchable()->sortable(),
                TextColumn::make('label')->label('Etichetta')->searchable(),
                TextColumn::make('unit')->label('Unità'),
                TextColumn::make('min_value')->label('Min')->numeric()
                    ->url(fn (FieldReferenceRange $record): ?string => self::anomalyUrl($record, 'min')),
                TextColumn::make('weighted_average')->label('Media')->numeric(2),
                TextColumn::make('max_value')->label('Max')->numeric()
                    ->url(fn (FieldReferenceRange $record): ?string => self::anomalyUrl($record, 'max')),
                TextColumn::make('normal_value')->label('Normale')->numeric()
                    ->url(fn (FieldReferenceRange $record): ?string => self::anomalyUrl($record, 'normal')),
                TextColumn::make('warning_value')->label('Warning')->numeric()
                    ->url(fn (FieldReferenceRange $record): ?string => self::anomalyUrl($record, 'warning')),
                TextColumn::make('alert_value')->label('Alert')->numeric()
                    ->url(fn (FieldReferenceRange $record): ?string => self::anomalyUrl($record, 'alert')),
                TextColumn::make('direction')
                    ->label('Direzione')
                    ->state(fn (FieldReferenceRange $record): ?string => $record->direction())
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'high' => 'Alto patologico',
                        'low' => 'Basso patologico',
                        default => '—',
                    })
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'high', 'low' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('table')
                    ->label('Tabella')
                    ->options([
                        'patients' => 'patients',
                        'patient_visits' => 'patient_visits',
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('recalculate')
                    ->label('Ricalcola min/max/media')
                    ->icon(Heroicon::OutlinedCalculator)
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalDescription('Ricalcola minimo, massimo e media dai dati attuali per tutti i campi numerici già presenti in questa tabella. Le soglie normale/warning/alert non vengono toccate.')
                    ->action(function (): void {
                        Artisan::call('patients:seed-field-reference-ranges');

                        Notification::make()
                            ->title('Valori ricalcolati')
                            ->body(trim(Artisan::output()))
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Costruisce il link verso l'elenco Visite pre-filtrato sul range corrispondente alla
     * colonna cliccata, per individuare e correggere i dati anomali. La direzione
     * (crescente/decrescente) viene dedotta da FieldReferenceRange::direction(), quindi
     * per i campi "basso patologico" (es. HDL) gli estremi vengono invertiti di conseguenza.
     */
    private static function anomalyUrl(FieldReferenceRange $record, string $tier): ?string
    {
        if ($record->table !== 'patient_visits') {
            return null;
        }

        $direction = $record->direction();

        [$min, $max] = match ($tier) {
            'min' => [$record->min_value, $record->min_value],
            'max' => [$record->max_value, $record->max_value],
            'normal' => $direction === 'low'
                ? [$record->warning_value, $record->normal_value]
                : [$record->normal_value, $record->warning_value],
            'warning' => $direction === 'low'
                ? [$record->alert_value, $record->warning_value]
                : [$record->warning_value, $record->alert_value],
            'alert' => $direction === 'low'
                ? [null, $record->alert_value]
                : [$record->alert_value, null],
            default => [null, null],
        };

        if ($min === null && $max === null) {
            return null;
        }

        return PatientVisitResource::getUrl('index', [
            'rr_field' => $record->field,
            'rr_min' => $min,
            'rr_max' => $max,
        ]);
    }
}
