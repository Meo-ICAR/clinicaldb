<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

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
                    TextInput::make('pazientecode')->label(__('filament/admin/patient_resource.pazientecode'))->required()->maxLength(15)->unique(ignoreRecord: true),
                    TextInput::make('iniziali')->label(__('filament/admin/patient_resource.iniziali'))->maxLength(3)->required(),
                    Select::make('centrocode')
                        ->label(__('filament/admin/patient_resource.centrocode'))
                        ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                        ->searchable()
                        ->required()
                        ->live()
                        ->default(__('filament/admin/patient_resource.centrocode_default'))
                        ->afterStateUpdated(function (?string $state, Set $set): void {
                            $set('centro', DB::table('centers')->where('centercode', $state)->value('center'));
                        }),
                    Hidden::make('centro')
                        ->label(__('filament/admin/patient_resource.centro'))->default(fn (): ?string => auth()->user()?->center),
                    DatePicker::make('arruolato')->label(__('filament/admin/patient_resource.arruolato'))->required(),
                    Toggle::make('active')->label(__('filament/admin/patient_resource.active'))->default(true),
                ]),
            Section::make('Dati anagrafici')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    DatePicker::make('datanascita')->label(__('filament/admin/patient_resource.datanascita')),
                    Select::make('sesso')
                        ->label(__('filament/admin/patient_resource.sesso'))->options(['M' => __('filament/admin/patient_resource.sesso.m'), 'F' => __('filament/admin/patient_resource.sesso.f')])->default(__('filament/admin/patient_resource.sesso_default'))->live(),
                    Select::make('etnia_id')->label(__('filament/admin/patient_resource.etnia_id'))->options(self::lookup('etnias'))->searchable(),
                    Select::make('rischio_id')->label(__('filament/admin/patient_resource.rischio_id'))->options(self::lookup('rischios'))->searchable(),
                    Select::make('statocivile_id')->label(__('filament/admin/patient_resource.statocivile_id'))->options(self::lookup('statociviles'))->searchable(),
                    TextInput::make('studioanni')->label(__('filament/admin/patient_resource.studioanni'))->numeric()->minValue(0)->maxValue(30),
                    Select::make('fumo_id')->label(__('filament/admin/patient_resource.fumo_id'))->options(self::lookup('fumos'))->searchable(),
                    TextInput::make('fumodurata')->label(__('filament/admin/patient_resource.fumodurata'))->numeric()->minValue(0),
                    Toggle::make('cammino')->label(__('filament/admin/patient_resource.cammino')),
                    Toggle::make('sport')->label(__('filament/admin/patient_resource.sport')),
                ]),
            Section::make('Anamnesi clinica')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    Select::make('infezionehiv_id')->label(__('filament/admin/patient_resource.infezionehiv_id'))->options(self::lookup('infezionehivs'))->searchable(),
                    Select::make('diabete_id')->label(__('filament/admin/patient_resource.diabete_id'))->options(self::lookup('diabetes'))->searchable(),
                    Select::make('cardiopatie_id')->label(__('filament/admin/patient_resource.cardiopatie_id'))->options(self::lookup('cardiopaties'))->searchable(),
                    Select::make('ipertensione_id')->label(__('filament/admin/patient_resource.ipertensione_id'))->options(self::lookup('ipertensiones'))->searchable(),
                    Select::make('ictus_id')->label(__('filament/admin/patient_resource.ictus_id'))->options(self::lookup('ictuss'))->searchable(),
                    Select::make('dislipidemie_id')->label(__('filament/admin/patient_resource.dislipidemie_id'))->options(self::lookup('dislipidemies'))->searchable(),
                    Select::make('epatite_id')->label(__('filament/admin/patient_resource.epatite_id'))->options(self::lookup('epatites'))->searchable(),
                    Select::make('cirrosi_id')->label(__('filament/admin/patient_resource.cirrosi_id'))->options(self::lookup('cirrosis'))->searchable(),
                    DatePicker::make('datahiv')->label(__('filament/admin/patient_resource.datahiv')),
                    DatePicker::make('positivodal')->label(__('filament/admin/patient_resource.positivodal')),
                    TextInput::make('stadiocdc')->label(__('filament/admin/patient_resource.stadiocdc')),
                    Toggle::make('menopausa')->label(__('filament/admin/patient_resource.menopausa'))
                        ->disabled(fn (Get $get): bool => $get('sesso') === 'M'),
                ]),
            Section::make('Terapia e valori basali')
                ->columnSpanFull()
                ->columns(4)
                ->schema([
                    Select::make('naive_id')->label(__('filament/admin/patient_resource.naive_id'))->options(self::lookup('naives'))->searchable(),
                    Select::make('pi_id')->label(__('filament/admin/patient_resource.pi_id'))->options(self::lookup('pis'))->searchable(),
                    Select::make('nrti_id')->label(__('filament/admin/patient_resource.nrti_id'))->options(self::lookup('nrtis'))->searchable(),
                    Select::make('nnrti_id')->label(__('filament/admin/patient_resource.nnrti_id'))->options(self::lookup('nnrtis'))->searchable(),
                    Select::make('ini_id')->label(__('filament/admin/patient_resource.ini_id'))->options(self::lookup('inis'))->searchable(),
                    DatePicker::make('trattamentodal')->label(__('filament/admin/patient_resource.trattamentodal')),
                    TextInput::make('cd4')->label(__('filament/admin/patient_resource.cd4'))->numeric()->minValue(0),
                    TextInput::make('cd4nadir')->label(__('filament/admin/patient_resource.cd4nadir'))->numeric()->minValue(0),
                    DatePicker::make('cd4data')->label(__('filament/admin/patient_resource.cd4data')),
                    TextInput::make('altezza')->label(__('filament/admin/patient_resource.altezza'))->numeric()->minValue(30)->maxValue(250),
                    Textarea::make('farmaciterapia')->label(__('filament/admin/patient_resource.farmaciterapia'))->columnSpan(2),
                    Textarea::make('commenti')->label(__('filament/admin/patient_resource.commenti'))->columnSpan(2),
                ]),
        ]);
    }

    /** @return array<string, string> */
    private static function lookup(string $table): array
    {
        return DB::table($table)->orderBy('id')->pluck('id', 'id')->all();
    }
}
