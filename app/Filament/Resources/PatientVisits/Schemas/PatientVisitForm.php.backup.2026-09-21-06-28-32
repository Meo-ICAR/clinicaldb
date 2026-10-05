<?php

namespace App\Filament\Resources\PatientVisits\Schemas;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\FieldReferenceRange;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class PatientVisitForm
{
    /**
     * Classificazione Gray-Weale dell'ecogenicità di placca. Etichette proposte, non
     * presenti a DB (la tabella ecogenicitas contiene solo ID numerici): da validare
     * con un clinico prima dell'uso in produzione.
     *
     * @var array<int, string>
     */
    private const ECOGENICITA_OPTIONS = [
        1 => '1 - Anecogena',
        2 => '2 - Ipoecogena',
        3 => '3 - Isoecogena',
        4 => '4 - Iperecogena',
        5 => '5 - Calcifica',
    ];

    /**
     * Grado di stenosi carotidea. Etichette proposte, non presenti a DB (la tabella
     * stenosis contiene solo ID numerici): da validare con un clinico.
     *
     * @var array<int, string>
     */
    private const STENOSI_OPTIONS = [
        1 => '1 - < 40%',
        2 => '2 - 40-49%',
        3 => '3 - 50-69%',
        4 => '4 - 70-89%',
        5 => '5 - 90-99%',
        6 => '6 - Occlusione (100%)',
    ];

    /**
     * Aspetto della superficie endoluminale di placca. Etichette proposte, non
     * presenti a DB (la tabella endolumiales contiene solo ID numerici): da validare
     * con un clinico.
     *
     * @var array<int, string>
     */
    private const SUPERFICIE_ENDOLUMINALE_OPTIONS = [
        1 => '1 - Liscia',
        2 => '2 - Irregolare',
        3 => '3 - Ulcerata',
    ];

    public static function configure(Schema $schema): Schema
    {
        $ranges = FieldReferenceRange::query()->where('table', 'patient_visits')->get()->keyBy('field');

        return $schema->components([
            Section::make('Visita')
                ->columnSpanFull()
                ->columns(5)
                ->schema([
                    Placeholder::make('pazientecode_display')
                        ->label('Codice paziente')
                        ->content(function (Get $get): HtmlString {
                            $patient = ($patientId = $get('patient_id')) ? Patient::query()->find($patientId) : null;

                            if (! $patient) {
                                return new HtmlString('—');
                            }

                            $url = PatientResource::getUrl('edit', ['record' => $patient]);

                            return new HtmlString('<a href="'.e($url).'" target="_blank" class="underline text-primary-600 dark:text-primary-400 font-medium">'.e($patient->pazientecode).'</a>');
                        }),
                    Hidden::make('patient_id')
                        ->default(fn (mixed $livewire): ?int => method_exists($livewire, 'getOwnerRecord') ? $livewire->getOwnerRecord()->getKey() : null)
                        ->required(),
                    DatePicker::make('visitadel')->label('Data visita')->required(),
                    Select::make('statogen_id')->label('Stato generale')->options(self::lookup('statogens'))->searchable(),
                    TextInput::make('DOPPLERID')->label('ID Doppler')->numeric(),
                    Hidden::make('centro')
                        ->default(fn (mixed $livewire): ?string => method_exists($livewire, 'getOwnerRecord') ? $livewire->getOwnerRecord()->centro : null),
                    Hidden::make('centrocode')
                        ->default(fn (mixed $livewire): ?string => method_exists($livewire, 'getOwnerRecord') ? $livewire->getOwnerRecord()->centrocode : null),
                    Hidden::make('pazientecode')
                        ->default(fn (mixed $livewire): ?string => method_exists($livewire, 'getOwnerRecord') ? $livewire->getOwnerRecord()->pazientecode : null),
                    Toggle::make('active')->label('Visita approvata')->default(true),
                ]),
            Tabs::make('Dettagli visita')
                ->tabs([
                    Tab::make('Anagrafica')
                        ->schema([
                            Select::make('statocivile_id')->label('Stato civile')->options(self::lookup('statociviles'))->searchable(),
                            Select::make('fumo_id')->label('Fumatore')->options(self::lookup('fumos'))->searchable(),
                            TextInput::make('fumodurata')->label('Fumo da (anni)')->numeric()->minValue(0),
                            Toggle::make('menopausa')->label('Menopausa'),
                            self::numericField('peso', 'Peso', 'kg', $ranges),
                            self::numericField('circonferenza', 'Circonferenza', 'cm', $ranges),
                            self::numericField('capqi', 'CAP/QI', null, $ranges),
                            TextInput::make('Trattamentonuovo')->label('Trattamento ARV attuale'),
                            DatePicker::make('Trattamentonuovodal')->label('Data di inizio'),
                            TextInput::make('Trattamentovecchio')->label('Trattamento ARV precedente'),
                            Select::make('trattamentocausaabbandono_id')->label('Causa modifica ARV')->options(self::lookup('trattamentocausaabbandonos'))->searchable(),
                        ])
                        ->columns(3),
                    Tab::make('Esami')
                        ->schema([
                            self::numericField('CD4', 'CD4', 'cell/µL', $ranges),
                            self::numericField('CD4CD8', 'CD4/CD8', null, $ranges),
                            self::numericField('HIVRNA', 'HIV RNA', 'copie/mL', $ranges),
                            Toggle::make('HIVRNAnorilevabile')->label('HIV RNA non rilevabile'),
                            self::numericField('Creatinina', 'Creatinina', 'mg/dL', $ranges),
                            self::numericField('PAS', 'Pressione sistolica', 'mmHg', $ranges),
                            self::numericField('PAD', 'Pressione diastolica', 'mmHg', $ranges),
                            self::numericField('Colesterolo', 'Colesterolo totale', 'mg/dL', $ranges),
                            self::numericField('HDL', 'HDL', 'mg/dL', $ranges),
                            self::numericField('LDL', 'LDL', 'mg/dL', $ranges),
                            self::numericField('Trigliceridi', 'Trigliceridi', 'mg/dL', $ranges),
                            self::numericField('Glicemia', 'Glicemia', 'mg/dL', $ranges),
                            self::numericField('Insulina', 'Insulina', 'µU/mL', $ranges),
                            self::numericField('Proteinuria', 'Proteinuria', 'mg/dL', $ranges),
                            Toggle::make('ProteurinaFlag')->label('Proteinuria presente'),
                            self::numericField('GPT', 'GPT (ALT)', 'U/L', $ranges),
                            self::numericField('GOT', 'GOT (AST)', 'U/L', $ranges),
                            self::numericField('gamma_GT', 'Gamma GT', 'U/L', $ranges),
                            self::numericField('Bil_T', 'Bilirubina totale', 'mg/dL', $ranges),
                            self::numericField('Bil_D', 'Bilirubina diretta', 'mg/dL', $ranges),
                            self::numericField('Bil_I', 'Bilirubina indiretta', 'mg/dL', $ranges),
                        ])
                        ->columns(4),
                    Tab::make('Terapie')
                        ->schema([
                            Section::make()
                                ->columnSpanFull()
                                ->columns(3)
                                ->schema(self::terapieToggles()),
                        ]),
                    Tab::make('Doppler')
                        ->schema([
                            Section::make('Spessore Intima-Media (IMT)')
                                ->description('Cutoff IMT a placche oltre 1,2 mm.')
                                ->columns(4)
                                ->schema([
                                    self::numericField('Carotide_comune_sx', 'Carotide comune sx', 'mm', $ranges),
                                    self::numericField('Carotide_comune_dx', 'Carotide comune dx', 'mm', $ranges),
                                    self::numericField('Carotide_comune_sxc', 'Carotide comune sx (follow-up)', 'mm', $ranges),
                                    self::numericField('Carotide_comune_dxc', 'Carotide comune dx (follow-up)', 'mm', $ranges),
                                    self::numericField('Bulbo_sx', 'Bulbo sx', 'mm', $ranges),
                                    self::numericField('Bulbo_dx', 'Bulbo dx', 'mm', $ranges),
                                    self::numericField('Bulbo_sxc', 'Bulbo sx (follow-up)', 'mm', $ranges),
                                    self::numericField('Bulbo_dxc', 'Bulbo dx (follow-up)', 'mm', $ranges),
                                    self::numericField('Carotide_interna_sx', 'Carotide interna sx', 'mm', $ranges),
                                    self::numericField('Carotide_interna_dx', 'Carotide interna dx', 'mm', $ranges),
                                    self::numericField('Carotide_interna_sxc', 'Carotide interna sx (follow-up)', 'mm', $ranges),
                                    self::numericField('Carotide_interna_dxc', 'Carotide interna dx (follow-up)', 'mm', $ranges),
                                    self::numericField('imtsx', 'IMT sx', 'mm', $ranges),
                                    self::numericField('imtdx', 'IMT dx', 'mm', $ranges),
                                    self::numericField('imtcc', 'IMT segmento carotide comune', 'mm', $ranges),
                                    self::numericField('imtci', 'IMT segmento carotide interna', 'mm', $ranges),
                                ]),
                            Section::make('Placche - caratteristiche')
                                ->columns(2)
                                ->schema([
                                    Select::make('placcasxecogen_id')->label('Ecogenicità sx')->options(self::ECOGENICITA_OPTIONS),
                                    Select::make('placcadxecogen_id')->label('Ecogenicità dx')->options(self::ECOGENICITA_OPTIONS),
                                    Toggle::make('placcasxstratosup')->label('Strato superficiale disomogeneo sx'),
                                    Toggle::make('placcadxstratosup')->label('Strato superficiale disomogeneo dx'),
                                    Toggle::make('placcasxstratopar')->label('Strato parietale disomogeneo sx'),
                                    Toggle::make('placcadxstratopar')->label('Strato parietale disomogeneo dx'),
                                    Select::make('placcasxsupendo_id')->label('Superficie endoluminale sx')->options(self::SUPERFICIE_ENDOLUMINALE_OPTIONS),
                                    Select::make('placcadxsupendo_id')->label('Superficie endoluminale dx')->options(self::SUPERFICIE_ENDOLUMINALE_OPTIONS),
                                    Toggle::make('placcasxclivaggio')->label('Piano di clivaggio identificabile sx'),
                                    Toggle::make('placcadxclivaggio')->label('Piano di clivaggio identificabile dx'),
                                    Toggle::make('placcasxclivaggio2')->label('Clivaggio sx (seconda valutazione)'),
                                    Toggle::make('placcadxclivaggio2')->label('Clivaggio dx (seconda valutazione)'),
                                    Toggle::make('placcasxbordi')->label('Placca sx bordi'),
                                    Toggle::make('placcadxbordi')->label('Placca dx bordi'),
                                    Toggle::make('placcasxomogenea')->label('Placca sx omogenea'),
                                    Toggle::make('placcadxomogenea')->label('Placca dx omogenea'),
                                    Toggle::make('placcasxombra')->label('Placca sx ombra'),
                                    Toggle::make('placcdsxombra')->label('Placca dx ombra'),
                                ]),
                            Section::make('Placche - grading e note')
                                ->columns(2)
                                ->schema([
                                    Select::make('placcasxsteno_id')->label('Stenosi sx')->options(self::STENOSI_OPTIONS),
                                    Select::make('placcadxsteno_id')->label('Stenosi dx')->options(self::STENOSI_OPTIONS),
                                    self::numericField('placcasxsten', 'Stenosi entità sx', '%', $ranges),
                                    self::numericField('placcadxsten', 'Stenosi entità dx', '%', $ranges),
                                    self::numericField('placcasx', 'Placca sx', 'mm', $ranges),
                                    self::numericField('placcadx', 'Placca dx', 'mm', $ranges),
                                    self::numericField('placcacc', 'Placca segmento carotide comune', 'mm', $ranges),
                                    self::numericField('placcaci', 'Placca segmento carotide interna', 'mm', $ranges),
                                    Textarea::make('placche_sx')->label('Note placca sx'),
                                    Textarea::make('placche_dx')->label('Note placca dx'),
                                    Textarea::make('placche_sxc')->label('Note placca sx (follow-up)'),
                                    Textarea::make('placche_dxc')->label('Note placca dx (follow-up)'),
                                    Textarea::make('placcamorfo')->label('Maggiori caratteristiche morfostrutturali placca')->columnSpanFull(),
                                ]),
                        ]),

                ])
                ->columnSpanFull(),
            Textarea::make('annotazione')->label('Altre annotazioni')->columnSpanFull(),
        ]);
    }

    /** @return array<int, Toggle> */
    private static function terapieToggles(): array
    {
        $fields = [
            'TC_TSA' => 'Lamivudina (3TC)',
            'ABC_TSA' => 'Abacavir',
            'TPV_TSA' => 'Tipranavir',
            'ATV_TSA' => 'Atazanavir',
            'AZT_TSA' => 'Zidovudina',
            'DT_TSA' => 'Stavudina (d4T)',
            'DDI_TSA' => 'Didanosina',
            'IDV_TSA' => 'Indinavir',
            'DRV_TSA' => 'Darunavir',
            'DVG_TSA' => 'Dolutegravir',
            'EFV_TSA' => 'Efavirenz',
            'ETV_TSA' => 'Etravirina',
            'FPV_TSA' => 'Fosamprenavir',
            'FTC_TSA' => 'Emtricitabina',
            'LPV_TSA' => 'Lopinavir',
            'MRV_TSA' => 'Maraviroc',
            'NFV_TSA' => 'Nelfinavir',
            'NVP_TSA' => 'Nevirapina',
            'RAL_TSA' => 'Raltegravir',
            'EVG_TSA' => 'Elvitegravir',
            'RPV_TSA' => 'Rilpivirina',
            'RTV_TSA' => 'Ritonavir',
            'SQV_TSA' => 'Saquinavir',
            'FI_TSA' => 'Enfuvirtide / inibitori della fusione',
            'TDF_TSA' => 'Tenofovir disoproxil (TDF)',
            'COBI_TSA' => 'Cobicistat',
            'bictegravir' => 'Bictegravir',
            'SPE_TSA' => 'Farmaci sperimentali',
            'NRTI_TSA' => 'NRTI aggregati',
            'NNRTI_TSA' => 'NNRTI aggregati',
            'PI_TSA' => 'PI aggregati',
            'II_TSA' => 'InSTI aggregati',
            'T_TSA' => 'Tenofovir (TDF o TAF) aggregato',
            'STATIN_ON' => 'Statina al momento',
            'STATIN_EVER' => 'Ha fatto statina',
            'FIBRATO_ON' => 'Fibrato',
            'FIBRATO_EVER' => 'Ha fatto fibrato',
            'IPER_ON' => 'Ipertensivi',
            'IPER_EVER' => 'Ha fatto farmaci ipertensivi',
        ];

        asort($fields, SORT_STRING | SORT_FLAG_CASE);

        return collect($fields)
            ->map(fn (string $label, string $name): Toggle => Toggle::make($name)->label($label))
            ->values()
            ->all();
    }

    private static function numericField(string $name, string $label, ?string $unit, Collection $ranges): TextInput
    {
        $field = TextInput::make($name)
            ->label($unit ? "{$label} ({$unit})" : $label)
            ->numeric()
            ->minValue(0)
            ->live(onBlur: true);

        $range = $ranges->get($name);

        if (! $range) {
            return $field;
        }

        return $field->extraInputAttributes(function (mixed $state) use ($range): array {
            if (blank($state) || ! is_numeric($state)) {
                return [];
            }

            return match ($range->severityFor((float) $state)) {
                'alert' => ['style' => 'background-color:#fee2e2;border-color:#f87171;'],
                'warning' => ['style' => 'background-color:#fef9c3;border-color:#facc15;'],
                default => [],
            };
        });
    }

    /** @return array<string, string> */
    private static function lookup(string $table): array
    {
        return DB::table($table)->orderBy('id')->pluck('id', 'id')->all();
    }
}
