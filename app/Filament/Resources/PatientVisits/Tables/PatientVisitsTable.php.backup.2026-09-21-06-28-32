<?php

namespace App\Filament\Resources\PatientVisits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\Constraint;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
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
            ->modifyQueryUsing(fn (Builder $query): Builder => self::applyAnomalyFilter($query))
            ->filters([
                SelectFilter::make('centrocode')
                    ->label('Centro')
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->default(fn (): ?string => auth()->user()?->centercode),
                ...self::queryBuilderFiltersByType(),
            ])
            ->filtersFormWidth(Width::TwoExtraLarge)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Applica il filtro "?rr_field=&rr_min=&rr_max=" usato dai link della schermata
     * Range di riferimento per individuare le visite con valori anomali su un campo.
     */
    private static function applyAnomalyFilter(Builder $query): Builder
    {
        $field = request()->query('rr_field');

        if (blank($field) || ! is_string($field) || ! Schema::hasColumn('patient_visits', $field)) {
            return $query;
        }

        $min = request()->query('rr_min');
        $max = request()->query('rr_max');
        $min = is_numeric($min) ? (float) $min : null;
        $max = is_numeric($max) ? (float) $max : null;

        if ($min !== null && $max !== null) {
            return $query->whereBetween($field, [min($min, $max), max($min, $max)]);
        }

        if ($min !== null) {
            return $query->where($field, '>=', $min);
        }

        if ($max !== null) {
            return $query->where($field, '<=', $max);
        }

        return $query;
    }

    /**
     * Un QueryBuilder separato per ciascun tipo di dato (Booleano, Data, Numero, Testo),
     * invece di un unico selettore con tutti i ~200 campi mescolati: ogni "Aggiungi
     * regola" mostra così solo i campi del proprio tipo, ordinati alfabeticamente.
     *
     * @return array<int, QueryBuilder>
     */
    private static function queryBuilderFiltersByType(): array
    {
        return collect(Schema::getColumns('patient_visits'))
            ->map(fn (array $column): array => self::constraintDataForColumn($column))
            ->sortBy(['group', 'label'])
            ->groupBy('group')
            ->map(fn (Collection $constraints, string $group): QueryBuilder => QueryBuilder::make("query_builder_{$group}")
                ->label("Filtri: {$group}")
                ->constraints($constraints->pluck('constraint')->values()->all()))
            ->values()
            ->all();
    }

    /**
     * @param  array{name: string, type_name: string, type: string, comment: ?string}  $column
     * @return array{group: string, label: string, constraint: Constraint}
     */
    private static function constraintDataForColumn(array $column): array
    {
        $name = $column['name'];
        $label = filled($column['comment']) ? Str::before($column['comment'], '.') : Str::headline($name);

        if ($column['type_name'] === 'tinyint' && $column['type'] === 'tinyint(1)') {
            return ['group' => 'Booleano', 'label' => $label, 'constraint' => BooleanConstraint::make($name)->label($label)];
        }

        if (in_array($column['type_name'], ['bigint', 'int', 'smallint', 'tinyint', 'float', 'double', 'decimal'], true)) {
            return ['group' => 'Numero', 'label' => $label, 'constraint' => NumberConstraint::make($name)->label($label)];
        }

        if (in_array($column['type_name'], ['date', 'datetime', 'timestamp'], true)) {
            return ['group' => 'Data', 'label' => $label, 'constraint' => DateConstraint::make($name)->label($label)];
        }

        return ['group' => 'Testo', 'label' => $label, 'constraint' => TextConstraint::make($name)->label($label)];
    }
}
