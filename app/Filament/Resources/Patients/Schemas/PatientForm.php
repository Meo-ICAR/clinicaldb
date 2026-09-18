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
                ->columns(3)
                ->schema([
                    TextInput::make('pazientecode')->label('Codice paziente')->required()->maxLength(15)->unique(ignoreRecord: true),
                    TextInput::make('iniziali')->label('Iniziali')->maxLength(3)->required(),
                    Select::make('centrocode')
                        ->label('Centro')
                        ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (?string $state, Set $set): void {
                            $set('centro', DB::table('centers')->where('centercode', $state)->value('center'));
                        }),
                    Hidden::make('centro'),
                    DatePicker::make('arruolato')->label('Data arruolamento')->required(),
                    Toggle::make('active')->label('Scheda attiva')->default(true),
                ]),
            Section::make('Dati anagrafici')
                ->columns(4)
                ->schema([
                    DatePicker::make('datanascita')->label('Data di nascita'),
                    Select::make('sesso')->options(['M' => 'Maschio', 'F' => 'Femmina'])->default('M')->live(),
                    Select::make('etnia_id')->label('Etnia')->options(self::lookup('etnias'))->searchable(),
                    Select::make('rischio_id')->label('Fattore di rischio')->options(self::lookup('rischios'))->searchable(),
                    Select::make('statocivile_id')->label('Stato civile')->options(self::lookup('statociviles'))->searchable(),
                    TextInput::make('studioanni')->label('Anni di studio')->numeric()->minValue(0)->maxValue(30),
                    Select::make('fumo_id')->label('Fumo')->options(self::lookup('fumos'))->searchable(),
                    TextInput::make('fumodurata')->label('Durata fumo (anni)')->numeric()->minValue(0),
                    Toggle::make('cammino')->label('Cammino regolare'),
                    Toggle::make('sport')->label('Attività sportiva'),
                ]),
            Section::make('Anamnesi clinica')
                ->columns(4)
                ->schema([
                    Select::make('infezionehiv_id')->label('Infezione HIV')->options(self::lookup('infezionehivs'))->searchable(),
                    Select::make('diabete_id')->label('Diabete')->options(self::lookup('diabetes'))->searchable(),
                    Select::make('cardiopatie_id')->label('Cardiopatie')->options(self::lookup('cardiopaties'))->searchable(),
                    Select::make('ipertensione_id')->label('Ipertensione')->options(self::lookup('ipertensiones'))->searchable(),
                    Select::make('ictus_id')->label('Ictus')->options(self::lookup('ictuss'))->searchable(),
                    Select::make('dislipidemie_id')->label('Dislipidemie')->options(self::lookup('dislipidemies'))->searchable(),
                    Select::make('epatite_id')->label('Epatite')->options(self::lookup('epatites'))->searchable(),
                    Select::make('cirrosi_id')->label('Cirrosi')->options(self::lookup('cirrosis'))->searchable(),
                    DatePicker::make('datahiv')->label('Data diagnosi HIV'),
                    DatePicker::make('positivodal')->label('HIV positivo dal'),
                    TextInput::make('stadiocdc')->label('Stadio CDC'),
                    Toggle::make('menopausa')->label('Menopausa')
                        ->disabled(fn (Get $get): bool => $get('sesso') === 'M'),
                ]),
            Section::make('Terapia e valori basali')
                ->columns(4)
                ->schema([
                    Select::make('naive_id')->label('Naive')->options(self::lookup('naives'))->searchable(),
                    Select::make('pi_id')->label('PI')->options(self::lookup('pis'))->searchable(),
                    Select::make('nrti_id')->label('NRTI')->options(self::lookup('nrtis'))->searchable(),
                    Select::make('nnrti_id')->label('NNRTI')->options(self::lookup('nnrtis'))->searchable(),
                    Select::make('ini_id')->label('INI')->options(self::lookup('inis'))->searchable(),
                    DatePicker::make('trattamentodal')->label('Terapia dal'),
                    TextInput::make('cd4')->label('CD4')->numeric()->minValue(0),
                    TextInput::make('cd4nadir')->label('CD4 nadir')->numeric()->minValue(0),
                    DatePicker::make('cd4data')->label('Data CD4'),
                    TextInput::make('altezza')->label('Altezza (cm)')->numeric()->minValue(30)->maxValue(250),
                    Textarea::make('farmaciterapia')->label('Terapia corrente')->columnSpan(2),
                    Textarea::make('commenti')->label('Note cliniche')->columnSpan(2),
                ]),
        ]);
    }

    /** @return array<string, string> */
    private static function lookup(string $table): array
    {
        return DB::table($table)->orderBy('id')->pluck('id', 'id')->all();
    }
}
