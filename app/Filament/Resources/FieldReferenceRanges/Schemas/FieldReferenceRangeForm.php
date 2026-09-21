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
                            ->label(__('filament/admin/field_reference_range_resource.table'))
                            ->options(['patients' => __('filament/admin/field_reference_range_resource.table.patients'), 'patient_visits' => __('filament/admin/field_reference_range_resource.table.patient_visits')])
                            ->required(),
                        TextInput::make('field')
                            ->label(__('filament/admin/field_reference_range_resource.field'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('label')
                            ->label(__('filament/admin/field_reference_range_resource.label'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('unit')
                            ->label(__('filament/admin/field_reference_range_resource.unit')),
                    ]),
                Section::make('Statistiche calcolate dai dati')
                    ->description('Calcolate automaticamente dal comando di ricalcolo: non modificabili qui.')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('min_value')->label(__('filament/admin/field_reference_range_resource.min_value'))->numeric()->disabled()->dehydrated(false),
                        TextInput::make('max_value')->label(__('filament/admin/field_reference_range_resource.max_value'))->numeric()->disabled()->dehydrated(false),
                        TextInput::make('weighted_average')->label(__('filament/admin/field_reference_range_resource.weighted_average'))->numeric()->disabled()->dehydrated(false),
                    ]),
                Section::make('Soglie cliniche')
                    ->description('La direzione (valori alti o bassi patologici) è dedotta automaticamente confrontando la soglia normale con quella di warning.')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('normal_value')->label(__('filament/admin/field_reference_range_resource.normal_value'))->numeric(),
                        TextInput::make('warning_value')->label(__('filament/admin/field_reference_range_resource.warning_value'))->numeric(),
                        TextInput::make('alert_value')->label(__('filament/admin/field_reference_range_resource.alert_value'))->numeric(),
                    ]),
            ]);
    }
}
