<?php

namespace App\Filament\Resources\PatientVisits\Schemas;

use App\Models\FieldReferenceRange;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
                ->columns(4)
                ->schema([
                    Select::make('patient_id')
                        ->label('Paziente')
                        ->options(fn (): array => Patient::query()->orderBy('pazientecode')->pluck('pazientecode', 'id')->all())
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (?int $state, Set $set): void {
                            $patient = $state ? Patient::query()->find($state) : null;

                            $set('centro', $patient?->centro);
                            $set('centrocode', $patient?->centrocode);
                            $set('pazientecode', $patient?->pazientecode);
                        }),
                    DatePicker::make('visitadel')->label('Data visita')->required(),
                    Select::make('statogen_id')->label('Stato generale')->options(self::lookup('statogens'))->searchable(),
                    TextInput::make('DOPPLERID')->label('ID Doppler')->numeric(),
                    Hidden::make('centro'),
                    Hidden::make('centrocode'),
                    Hidden::make('pazientecode'),
                    Toggle::make('active')->label('Visita attiva')->default(true),
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
                    Tab::make('Terapie')
                        ->schema([
                            Toggle::make('TC_TSA')->label('Lamivudina (3TC)'),
                            Toggle::make('ABC_TSA')->label('Abacavir'),
                            Toggle::make('TPV_TSA')->label('Tipranavir'),
                            Toggle::make('ATV_TSA')->label('Atazanavir'),
                            Toggle::make('AZT_TSA')->label('Zidovudina'),
                            Toggle::make('DT_TSA')->label('Stavudina (d4T)'),
                            Toggle::make('DDI_TSA')->label('Didanosina'),
                            Toggle::make('IDV_TSA')->label('Indinavir'),
                            Toggle::make('DRV_TSA')->label('Darunavir'),
                            Toggle::make('DVG_TSA')->label('Dolutegravir'),
                            Toggle::make('EFV_TSA')->label('Efavirenz'),
                            Toggle::make('ETV_TSA')->label('Etravirina'),
                            Toggle::make('FPV_TSA')->label('Fosamprenavir'),
                            Toggle::make('FTC_TSA')->label('Emtricitabina'),
                            Toggle::make('LPV_TSA')->label('Lopinavir'),
                            Toggle::make('MRV_TSA')->label('Maraviroc'),
                            Toggle::make('NFV_TSA')->label('Nelfinavir'),
                            Toggle::make('NVP_TSA')->label('Nevirapina'),
                            Toggle::make('RAL_TSA')->label('Raltegravir'),
                            Toggle::make('EVG_TSA')->label('Elvitegravir'),
                            Toggle::make('RPV_TSA')->label('Rilpivirina'),
                            Toggle::make('RTV_TSA')->label('Ritonavir'),
                            Toggle::make('SQV_TSA')->label('Saquinavir'),
                            Toggle::make('FI_TSA')->label('Enfuvirtide / inibitori della fusione'),
                            Toggle::make('TDF_TSA')->label('Tenofovir disoproxil (TDF)'),
                            Toggle::make('COBI_TSA')->label('Cobicistat'),
                            Toggle::make('bictegravir')->label('Bictegravir'),
                            Toggle::make('SPE_TSA')->label('Farmaci sperimentali'),
                            Toggle::make('NRTI_TSA')->label('NRTI aggregati'),
                            Toggle::make('NNRTI_TSA')->label('NNRTI aggregati'),
                            Toggle::make('PI_TSA')->label('PI aggregati'),
                            Toggle::make('II_TSA')->label('InSTI aggregati'),
                            Toggle::make('T_TSA')->label('Tenofovir (TDF o TAF) aggregato'),
                            Toggle::make('STATIN_ON')->label('Statina al momento'),
                            Toggle::make('STATIN_EVER')->label('Ha mai fatto statina'),
                            Toggle::make('FIBRATO_ON')->label('Fibrato'),
                            Toggle::make('FIBRATO_EVER')->label('Ha mai fatto fibrato'),
                            Toggle::make('IPER_ON')->label('Ipertensivi'),
                            Toggle::make('IPER_EVER')->label('Ha mai fatto farmaci ipertensivi'),
                        ])
                        ->columns(3),
                ])
                ->columnSpanFull(),
            Textarea::make('annotazione')->label('Altre annotazioni')->columnSpanFull(),
        ]);
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
