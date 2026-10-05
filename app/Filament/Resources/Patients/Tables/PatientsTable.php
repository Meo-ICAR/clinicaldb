<?php

namespace App\Filament\Resources\Patients\Tables;

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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pazientecode')->label(__('filament/admin/patient_resource.pazientecode'))->searchable()->sortable(),
                TextColumn::make('iniziali')->label(__('filament/admin/patient_resource.iniziali'))->searchable(),
                TextColumn::make('centrocode')->label(__('filament/admin/patient_resource.centrocode'))->searchable()->sortable(),
                TextColumn::make('arruolato')->label(__('filament/admin/patient_resource.arruolato'))->date('d/m/Y')->sortable(),
                TextColumn::make('sesso')->label(__('filament/admin/patient_resource.sesso')),
                TextColumn::make('datanascita')->label(__('filament/admin/patient_resource.datanascita'))->date('d/m/Y')->sortable(),
                IconColumn::make('active')->label(__('filament/admin/patient_resource.active'))->boolean(),
            ])
            ->headerActions([
                ExportAction::make()->label(__('filament/admin/patient_resource.export')),
            ])
            ->defaultSort('arruolato', 'desc')
            ->recordActions([EditAction::make()
                ->label(__('filament/admin/patient_resource.edit'))])
            ->filters([
                SelectFilter::make('centrocode')
                    ->label(__('filament/admin/patient_resource.centrocode'))
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->default(fn (): ?string => auth()->user()?->centercode),
                ...self::queryBuilderFiltersByType(),
            ])
            ->filtersFormWidth(Width::TwoExtraLarge)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('filament/admin/patient_resource.delete_bulk')),
                ]),
            ]);
    }

    /**
     * Un QueryBuilder separato per ciascun tipo di dato (Booleano, Data, Numero, Testo),
     * invece di un unico selettore con tutti i ~180 campi mescolati: ogni "Aggiungi
     * regola" mostra così solo i campi del proprio tipo, ordinati alfabeticamente.
     *
     * @return array<int, QueryBuilder>
     */
    private static function queryBuilderFiltersByType(): array
    {
        return collect(Schema::getColumns('patients'))
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
