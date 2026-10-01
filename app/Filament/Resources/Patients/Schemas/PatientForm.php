<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as DatabaseSchema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identificazione e arruolamento')
                ->description('Dati identificativi pseudonimizzati e centro di riferimento.')
                ->columnSpanFull()
                ->columns(3)
                ->schema([
                    TextInput::make('pazientecode')->label(self::columnLabel('pazientecode'))->required()->maxLength(15)->unique(ignoreRecord: true),
                    TextInput::make('iniziali')->label(self::columnLabel('iniziali'))->maxLength(3)->required(),
                    Select::make('centrocode')
                        ->label(self::columnLabel('centrocode'))
                        ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                        ->searchable()
                        ->required()
                        ->live()
                        ->default(__('filament/admin/patient_resource.centrocode_default'))
                        ->afterStateUpdated(function (?string $state, Set $set): void {
                            $set('centro', DB::table('centers')->where('centercode', $state)->value('center'));
                        }),
                    Hidden::make('centro')
                        ->label(self::columnLabel('centro'))->default(fn (): ?string => auth()->user()?->center),
                    DatePicker::make('arruolato')->label(self::columnLabel('arruolato'))->required(),
                    Toggle::make('active')->label(self::columnLabel('active'))->default(true),
                ]),
            Section::make('Dati anagrafici')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    DatePicker::make('datanascita')->label(self::columnLabel('datanascita')),
                    DatePicker::make('annonascita')->label(self::columnLabel('annonascita')),
                    Select::make('lavoro_id')->label(self::columnLabel('lavoro_id'))->options(self::lookup('lavoros'))->searchable(),
                    Select::make('sesso')
                        ->label(self::columnLabel('sesso'))->options(['M' => __('filament/admin/patient_resource.sesso.m'), 'F' => __('filament/admin/patient_resource.sesso.f')])->default(__('filament/admin/patient_resource.sesso_default'))->live(),
                    Select::make('etnia_id')->label(self::columnLabel('etnia_id'))->options(self::lookup('etnias'))->searchable(),
                    Select::make('rischio_id')->label(self::columnLabel('rischio_id'))->options(self::lookup('rischios'))->searchable(),
                    TextInput::make('studioanni')->label(self::columnLabel('studioanni'))->numeric()->minValue(0)->maxValue(30),
                    Toggle::make('cammino')->label(self::columnLabel('cammino')),
                    Toggle::make('sport')->label(self::columnLabel('sport')),
                ]),
            Section::make('Anamnesi clinica')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    Select::make('infezionehiv_id')->label(self::columnLabel('infezionehiv_id'))->options(self::lookup('infezionehivs'))->searchable(),
                    Select::make('diabete_id')->label(self::columnLabel('diabete_id'))->options(self::lookup('diabetes'))->searchable(),
                    Select::make('cardiopatie_id')->label(self::columnLabel('cardiopatie_id'))->options(self::lookup('cardiopaties'))->searchable(),
                    Select::make('ipertensione_id')->label(self::columnLabel('ipertensione_id'))->options(self::lookup('ipertensiones'))->searchable(),
                    Select::make('ictus_id')->label(self::columnLabel('ictus_id'))->options(self::lookup('ictuss'))->searchable(),
                    Select::make('dislipidemie_id')->label(self::columnLabel('dislipidemie_id'))->options(self::lookup('dislipidemies'))->searchable(),
                    Select::make('epatite_id')->label(self::columnLabel('epatite_id'))->options(self::lookup('epatites'))->searchable(),
                    Select::make('cirrosi_id')->label(self::columnLabel('cirrosi_id'))->options(self::lookup('cirrosis'))->searchable(),
                    DatePicker::make('datahiv')->label(self::columnLabel('datahiv')),
                    DatePicker::make('positivodal')->label(self::columnLabel('positivodal')),
                    TextInput::make('stadiocdc')->label(self::columnLabel('stadiocdc')),
                    Select::make('lipodistrofia_id')->label(self::columnLabel('lipodistrofia_id'))->options(self::lookup('lipodistrofias'))->searchable(),
                    Select::make('neoplasie_id')->label(self::columnLabel('neoplasie_id'))->options(self::lookup('neoplasies'))->searchable(),
                    Select::make('osteoporosi_id')->label(self::columnLabel('osteoporosi_id'))->options(self::lookup('osteoporosis'))->searchable(),
                    Select::make('insuffrenale_id')->label(self::columnLabel('insuffrenale_id'))->options(self::lookup('insuffrenales'))->searchable(),
                    Select::make('infezioni_id')->label(self::columnLabel('infezioni_id'))->options(self::lookup('infezionis'))->searchable(),
                    Select::make('ormonali_id')->label(self::columnLabel('ormonali_id'))->options(self::lookup('ormonalis'))->searchable(),
                    Select::make('ipolipemizzanti_id')->label(self::columnLabel('ipolipemizzanti_id'))->options(self::lookup('ipolipemizzantis'))->searchable(),
                    TextInput::make('ipolipemizzantiquali')->label(self::columnLabel('ipolipemizzantiquali'))->maxLength(100),
                    Toggle::make('ipolipemizzantidamesi')->label(self::columnLabel('ipolipemizzantidamesi')),
                    Select::make('ipertensionefar_id')->label(self::columnLabel('ipertensionefar_id'))->options(self::lookup('ipertensiones'))->searchable(),
                    Select::make('antidiabetici_id')->label(self::columnLabel('antidiabetici_id'))->options(self::lookup('antidiabeticis'))->searchable(),
                    Select::make('farmaci_id')->label(self::columnLabel('farmaci_id'))->options(self::lookup('farmacis'))->searchable(),
                    Textarea::make('farmaciquali')->label(self::columnLabel('farmaciquali'))->columnSpan(2),
                    Select::make('alcool_id')->label(self::columnLabel('alcool_id'))->options(self::lookup('alcools'))->searchable(),
                    Select::make('alcool35_id')->label(self::columnLabel('alcool35_id'))->options(self::lookup('alcool35s'))->searchable(),
                    Select::make('droghe_id')->label(self::columnLabel('droghe_id'))->options(self::lookup('droghes'))->searchable(),
                    Textarea::make('droghequali')->label(self::columnLabel('droghequali'))->columnSpan(2),
                ]),
            Section::make('Terapia e valori basali')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    Select::make('naive_id')->label(self::columnLabel('naive_id'))->options(self::lookup('naives'))->searchable(),
                    Select::make('pi_id')->label(self::columnLabel('pi_id'))->options(self::lookup('pis'))->searchable(),
                    Select::make('nrti_id')->label(self::columnLabel('nrti_id'))->options(self::lookup('nrtis'))->searchable(),
                    Select::make('nnrti_id')->label(self::columnLabel('nnrti_id'))->options(self::lookup('nnrtis'))->searchable(),
                    Select::make('ini_id')->label(self::columnLabel('ini_id'))->options(self::lookup('inis'))->searchable(),
                    Select::make('artaltro_id')->label(self::columnLabel('artaltro_id'))->options(self::lookup('artaltros'))->searchable(),
                    Select::make('artterapie_id')->label(self::columnLabel('artterapie_id'))->options(self::lookup('artterapies'))->searchable(),
                    Toggle::make('haart')->label(self::columnLabel('haart')),
                    Textarea::make('ultimaterapia')->label(self::columnLabel('ultimaterapia'))->columnSpan(2),
                    DatePicker::make('trattamentodal')->label(self::columnLabel('trattamentodal')),
                    TextInput::make('cd4nadir')->label(self::columnLabel('cd4nadir'))->numeric()->minValue(0),
                    DatePicker::make('cd4data')->label(self::columnLabel('cd4data')),
                    TextInput::make('altezza')->label(self::columnLabel('altezza'))->numeric()->minValue(30)->maxValue(250),
                    Textarea::make('farmaciterapia')->label(self::columnLabel('farmaciterapia'))->columnSpan(2),
                    Textarea::make('commenti')->label(self::columnLabel('commenti'))->columnSpan(2),
                ]),
        ]);
    }

    /**
     * Etichetta del campo presa dal commento MySQL della colonna di patients,
     * con fallback sulla traduzione.
     */
    private static function columnLabel(string $column): string
    {
        static $comments = null;

        $comments ??= collect(DatabaseSchema::getColumns('patients'))->pluck('comment', 'name')->all();

        return filled($comments[$column] ?? null) ? $comments[$column] : __("filament/admin/patient_resource.{$column}");
    }

    /** @return array<string, string> */
    private static function lookup(string $table): array
    {
        return DB::table($table)->orderBy('id')->pluck('id', 'id')->all();
    }
}
