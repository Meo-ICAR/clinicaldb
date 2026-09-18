<?php

namespace App\Filament\Resources\PatientVisits\Schemas;

use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PatientVisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Visita')
                ->columns(3)
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
                    TextInput::make('DOPPLERID')->label('ID Doppler')->numeric(),
                    Hidden::make('centro'),
                    Hidden::make('centrocode'),
                    Hidden::make('pazientecode'),
                    Toggle::make('active')->label('Visita attiva')->default(true),
                ]),
            Section::make('Trattamento e annotazioni')
                ->columns(3)
                ->schema([
                    TextInput::make('Trattamentonuovo')->label('Nuovo trattamento'),
                    DatePicker::make('Trattamentonuovodal')->label('Nuovo trattamento dal'),
                    TextInput::make('Trattamentovecchio')->label('Trattamento precedente'),
                    Textarea::make('annotazione')->label('Annotazione')->columnSpanFull(),
                ]),
            Section::make('Parametri clinici')
                ->columns(4)
                ->schema([
                    TextInput::make('peso')->label('Peso (kg)')->numeric()->minValue(0),
                    TextInput::make('circonferenza')->label('Circonferenza (cm)')->numeric()->minValue(0),
                    TextInput::make('PAS')->label('Pressione sistolica')->numeric()->minValue(0),
                    TextInput::make('PAD')->label('Pressione diastolica')->numeric()->minValue(0),
                    TextInput::make('CD4')->numeric()->minValue(0),
                    TextInput::make('CD4CD8')->label('Rapporto CD4/CD8')->numeric()->minValue(0),
                    TextInput::make('HIVRNA')->label('HIV RNA')->numeric()->minValue(0),
                    Toggle::make('HIVRNAnorilevabile')->label('HIV RNA non rilevabile'),
                    TextInput::make('Creatinina')->numeric()->minValue(0),
                    TextInput::make('Glicemia')->numeric()->minValue(0),
                    TextInput::make('Colesterolo')->numeric()->minValue(0),
                    TextInput::make('Trigliceridi')->numeric()->minValue(0),
                    TextInput::make('GPT')->numeric()->minValue(0),
                    TextInput::make('GOT')->numeric()->minValue(0),
                    TextInput::make('gamma_GT')->numeric()->minValue(0),
                    Toggle::make('ProteurinaFlag')->label('Proteinuria presente'),
                    TextInput::make('Proteinuria')->numeric()->minValue(0),
                    Toggle::make('menopausa')->label('Menopausa'),
                ]),
            Section::make('Ecografia carotidea')
                ->columns(4)
                ->schema([
                    TextInput::make('Carotide_comune_sx')->label('Carotide comune sx')->numeric(),
                    TextInput::make('Carotide_comune_dx')->label('Carotide comune dx')->numeric(),
                    TextInput::make('Bulbo_sx')->label('Bulbo sx')->numeric(),
                    TextInput::make('Bulbo_dx')->label('Bulbo dx')->numeric(),
                    TextInput::make('Carotide_interna_sx')->label('Carotide interna sx')->numeric(),
                    TextInput::make('Carotide_interna_dx')->label('Carotide interna dx')->numeric(),
                    Toggle::make('placcasxbordi')->label('Placca sx bordi'),
                    Toggle::make('placcadxbordi')->label('Placca dx bordi'),
                    Toggle::make('placcasxclivaggio')->label('Clivaggio sx'),
                    Toggle::make('placcadxclivaggio')->label('Clivaggio dx'),
                    Toggle::make('placcasxomogenea')->label('Placca sx omogenea'),
                    Toggle::make('placcadxomogenea')->label('Placca dx omogenea'),
                    Textarea::make('placche_sx')->label('Note placca sx')->columnSpan(2),
                    Textarea::make('placche_dx')->label('Note placca dx')->columnSpan(2),
                ]),
        ]);
    }
}
