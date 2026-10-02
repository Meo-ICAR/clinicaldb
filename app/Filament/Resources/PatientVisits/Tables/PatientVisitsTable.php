<?php

namespace App\Filament\Resources\PatientVisits\Tables;

use App\Models\PatientVisit;
use Filament\Actions\Action;
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
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PatientVisitsTable
{
    /**
     * Ordine delle colonne dell'export completo: prima i campi di patients, poi quelli di
     * patient_visits. Le colonne di patient_visits non elencate vanno in coda.
     *
     * @var array<int, string>
     */
    private const EXPORT_PATIENT_COLUMNS = [
        'pazientecode',
        'arruolato',
        'datanascita',
        'sesso',
        'menopausa',
        'etnia_id',
        'rischio_id',
        'studioanni',
        'statocivile_id',
        'fumo_id',
        'fumodurata',
        'lavoro_id',
        'cammino',
        'sport',
        'ictus_id',
        'cardiopatie_id',
        'diabete_id',
        'dislipidemie_id',
        'lipodistrofia_id',
        'neoplasie_id',
        'osteoporosi_id',
        'insuffrenale_id',
        'ormonali_id',
        'ipolipemizzanti_id',
        'ipolipemizzantiquali',
        'ipolipemizzantidamesi',
        'ipertensione_id',
        'ipertensionefar_id',
        'antidiabetici_id',
        'farmaci_id',
        'farmaciquali',
        'alcool_id',
        'alcool35_id',
        'droghe_id',
        'droghequali',
        'cirrosi_id',
        'epatite_id',
        'infezionehiv_id',
        'stadiocdc',
        'datahiv',
        'positivodal',
        'naive_id',
        'pi_id',
        'nrti_id',
        'nnrti_id',
        'ini_id',
        'artaltro_id',
        'artterapie_id',
        'trattamentodal',
        'farmaciterapia',
        'ultimaterapia',
        'haart',
        'infezioni_id',
        'cd4',
        'cd4nadir',
        'cd4data',
        'altezza',
        'commenti',
    ];

    /** @var array<int, string> */
    private const EXPORT_VISIT_COLUMNS = [
        'visitadel',
        'CD4',
        'CD4CD8',
        'Trattamentovecchio',
        'trattamentocausaabbandono_id',
        'Trattamentonuovo',
        'Trattamentonuovodal',
        'peso',
        'circonferenza',
        'PAS',
        'Creatinina',
        'HIVRNA',
        'HIVRNAnorilevabile',
        'placcasxbordi',
        'placcadxbordi',
        'placcasxclivaggio',
        'placcadxclivaggio',
        'placcasxomogenea',
        'placcadxomogenea',
        'placcasxombra',
        'placcdsxombra',
        'menopausa',
        'PAD',
        'Colesterolo',
        'HDL',
        'LDL',
        'Trigliceridi',
        'Glicemia',
        'Insulina',
        'GPT',
        'GOT',
        'gamma_GT',
        'ProteurinaFlag',
        'Proteinuria',
        'centro',
        'centrocode',
        'pazientecode',
        'annotazione',
        'Bil_T',
        'Bil_D',
        'Bil_I',
        'Carotide_comune_sx',
        'Carotide_comune_dx',
        'Bulbo_sx',
        'Bulbo_dx',
        'Carotide_interna_sx',
        'Carotide_interna_dx',
        'placche_sx',
        'placche_dx',
        'Carotide_comune_sxc',
        'Carotide_comune_dxc',
        'Bulbo_sxc',
        'Bulbo_dxc',
        'Carotide_interna_sxc',
        'Carotide_interna_dxc',
        'placche_sxc',
        'placche_dxc',
        'statocivile_id',
        'statogen_id',
        'fumo_id',
        'fumodurata',
        'AGE_TSA',
        'D_HIV',
        'FDR',
        'INIZIO_ARV',
        'D_AIDS',
        'D_DIABETE',
        'D_DECESSO',
        'YEARS_HIV_TSA',
        'YEARS_ARV_TSA',
        'NADIR_CD4_TSA',
        'HCV_TSA',
        'HBV_TSA',
        'D_STATUS',
        'TIME_SOP_TSA',
        'VIREMIA_TSA',
        'CD4_TSA',
        'CD8_TSA',
        'Hb_TSA',
        'PLT_TSA',
        'AST_TSA',
        'ALT_TSA',
        'CD4_CD8_RAPP_TSA',
        'ALP_TSA',
        'BILTOT_TSA',
        'BILDIR_TSA',
        'CREA_TSA',
        'GLU_TSA',
        'TRIG_TSA',
        'COLEST_TSA',
        'COLHDL_TSA',
        'COLLDL_TSA',
        'BILIND_TSA',
        'CALCIO_TSA',
        'INSULINA_TSA',
        'FOSFORO_TSA',
        'HOMA_TSA',
        'FIB_TSA',
        'EGFR_TSA',
        'NAIVE_TSA',
        'TC_TSA',
        'ABC_TSA',
        'TPV_TSA',
        'ATV_TSA',
        'AZT_TSA',
        'DT_TSA',
        'DDI_TSA',
        'IDV_TSA',
        'DRV_TSA',
        'DVG_TSA',
        'EFV_TSA',
        'ETV_TSA',
        'FPV_TSA',
        'FTC_TSA',
        'LPV_TSA',
        'MRV_TSA',
        'NFV_TSA',
        'NVP_TSA',
        'RAL_TSA',
        'EVG_TSA',
        'RPV_TSA',
        'RTV_TSA',
        'SQV_TSA',
        'T_TSA',
        'TDF_TSA',
        'COBI_TSA',
        'SPE_TSA',
        'NRTI_TSA',
        'NNRTI_TSA',
        'PI_TSA',
        'II_TSA',
        'FI_TSA',
        'STATIN_ON',
        'STATIN_EVER',
        'FIBRATO_ON',
        'FIBRATO_EVER',
        'IPER_ON',
        'IPER_EVER',
        'FUMO',
        'PESO_TSA',
        'PD_TSA',
        'PS_TSA',
        'data_TSA',
        'MIT_DX',
        'MIT_SX',
        'LESIONE_BIF',
        'lesione_DX',
        'lesione_SX',
        'LESIONE_BIL',
        'lesione_f',
        'lesione_c',
        'lesione_fc',
        'PLACCA',
        'placca_dx',
        'placca_sx',
        'placca_bil',
        'placca_f',
        'placca_c',
        'placca_fc',
        'STENOsi',
        'F23',
        'F24',
        'bmi_tsa',
        'CVD_risk',
        'Framingham_score',
        'DAD_score',
        'D_CARDIO1',
        'CARDIO1',
        'D_CARDIO2',
        'CARDIO2',
        'placcasxecogen_id',
        'placcasxstratosup',
        'placcadxstratosup',
        'placcasxstratopar',
        'placcadxstratopar',
        'placcasxsupendo_id',
        'placcadxsupendo_id',
        'placcasxclivaggio2',
        'placcadxclivaggio2',
        'capqi',
        'placcasxsten',
        'placcadxsten',
        'bictegravir',
        'imtsx',
        'imtdx',
        'imtci',
        'imtcc',
        'placcasx',
        'placcadx',
        'placcaci',
        'placcacc',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.pazientecode')->label(__('filament/admin/patient_visit_resource.patient.pazientecode'))->searchable()->sortable(),
                TextColumn::make('visitadel')->label(__('filament/admin/patient_visit_resource.visitadel'))->date('d/m/Y')->sortable(),
                TextColumn::make('centrocode')->label(__('filament/admin/patient_visit_resource.centrocode'))->searchable(),
                TextColumn::make('CD4')->label(__('filament/admin/patient_visit_resource.c_d4'))->numeric()->sortable(),
                TextColumn::make('HIVRNA')->label(__('filament/admin/patient_visit_resource.h_i_v_r_n_a'))->numeric()->sortable(),
                TextColumn::make('peso')->label(__('filament/admin/patient_visit_resource.peso'))->numeric(),
                IconColumn::make('HIVRNAnorilevabile')->label(__('filament/admin/patient_visit_resource.h_i_v_r_n_anorilevabile'))->boolean(),
                IconColumn::make('active')->label(__('filament/admin/patient_visit_resource.active'))->boolean(),
            ])
            ->headerActions([
                ExportAction::make()->label(__('filament/admin/patient_visit_resource.export')),
                self::fullExportAction(),
            ])
            ->defaultSort('visitadel', 'desc')
            ->recordActions([EditAction::make()
                ->label(__('filament/admin/patient_visit_resource.edit'))])
            ->modifyQueryUsing(fn (Builder $query): Builder => self::applyAnomalyFilter($query))
            ->filters([
                SelectFilter::make('centrocode')
                    ->label(__('filament/admin/patient_visit_resource.centrocode'))
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->default(fn (): ?string => auth()->user()?->centercode),
                ...self::queryBuilderFiltersByType(),
            ])
            ->filtersFormWidth(Width::TwoExtraLarge)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('filament/admin/patient_visit_resource.delete_bulk')),
                ]),
            ]);
    }

    /**
     * Export denormalizzato visite + paziente: rispetta i filtri attivi della tabella.
     * Scrive l'xlsx in streaming con OpenSpout: pxlrbt/PhpSpreadsheet con ~260 colonne
     * per riga è troppo lento e pesante sull'intero archivio.
     */
    private static function fullExportAction(): Action
    {
        return Action::make('export_full')
            ->label(__('filament/admin/patient_visit_resource.export_full'))
            ->icon('heroicon-o-arrow-down-tray')
            ->action(function (HasTable $livewire): BinaryFileResponse {
                $visitColumns = Schema::getColumnListing('patient_visits');
                $patientColumns = Schema::getColumnListing('patients');
                $visitComments = self::columnComments('patient_visits');
                $patientComments = self::columnComments('patients');

                $matchExisting = fn (array $wanted, array $existing): array => collect($wanted)
                    ->map(fn (string $name): ?string => collect($existing)->first(fn (string $column): bool => strcasecmp($column, $name) === 0))
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                $orderedPatient = $matchExisting(self::EXPORT_PATIENT_COLUMNS, $patientColumns);
                $orderedVisit = $matchExisting(self::EXPORT_VISIT_COLUMNS, $visitColumns);
                $tailVisit = array_values(array_diff($visitColumns, $orderedVisit));

                $spec = [
                    ...array_map(fn (string $column): array => ['alias' => "patient__{$column}", 'select' => "p.{$column}", 'heading' => $patientComments[$column] ?? $column], $orderedPatient),
                    ...array_map(fn (string $column): array => ['alias' => $column, 'select' => "patient_visits.{$column}", 'heading' => $visitComments[$column] ?? $column], [...$orderedVisit, ...$tailVisit]),
                ];

                $query = PatientVisit::query()
                    ->join('patients as p', 'patient_visits.patient_id', '=', 'p.id')
                    ->select(array_map(fn (array $column): Expression => DB::raw("{$column['select']} as `{$column['alias']}`"), $spec))
                    ->whereIn('patient_visits.id', $livewire->getFilteredTableQuery()->reorder()->select('patient_visits.id'))
                    ->orderBy('patient_visits.id');

                $path = tempnam(sys_get_temp_dir(), 'export_full_').'.xlsx';

                $writer = new XlsxWriter;
                $writer->openToFile($path);
                $writer->addRow(Row::fromValues(array_column($spec, 'heading')));

                foreach ($query->toBase()->cursor() as $record) {
                    $writer->addRow(Row::fromValues(array_map(fn (array $column): mixed => $record->{$column['alias']} ?? null, $spec)));
                }

                $writer->close();

                return response()->download($path, 'visite_pazienti_'.now()->format('Ymd_His').'.xlsx')->deleteFileAfterSend();
            });
    }

    /**
     * @return array<string, string>
     */
    private static function columnComments(string $table): array
    {
        return collect(Schema::getColumns($table))
            ->filter(fn (array $column): bool => filled($column['comment']))
            ->pluck('comment', 'name')
            ->all();
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
