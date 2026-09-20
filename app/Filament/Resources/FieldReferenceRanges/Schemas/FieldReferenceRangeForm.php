<?php

namespace App\Filament\Resources\FieldReferenceRanges\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FieldReferenceRangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campo')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('table')
                            ->label('Tabella')
                            ->options([
                                'patients' => 'patients',
                                'patient_visits' => 'patient_visits',
                            ])
                            ->required(),
                        TextInput::make('field')
                            ->label('Colonna')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('label')
                            ->label('Etichetta')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('unit')
                            ->label('Unità di misura'),
                    ]),
                Section::make('Statistiche calcolate dai dati')
                    ->description('Calcolate automaticamente dal comando di ricalcolo: non modificabili qui.')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('min_value')->label('Minimo osservato')->numeric()->disabled()->dehydrated(false),
                        TextInput::make('max_value')->label('Massimo osservato')->numeric()->disabled()->dehydrated(false),
                        TextInput::make('weighted_average')->label('Media')->numeric()->disabled()->dehydrated(false),
                    ]),
                Section::make('Soglie cliniche')
                    ->description('La direzione (valori alti o bassi patologici) è dedotta automaticamente confrontando la soglia normale con quella di warning.')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('normal_value')->label('Valore normale')->numeric(),
                        TextInput::make('warning_value')->label('Valore warning')->numeric(),
                        TextInput::make('alert_value')->label('Valore alert')->numeric(),
                    ]),
            ]);
    }
}
