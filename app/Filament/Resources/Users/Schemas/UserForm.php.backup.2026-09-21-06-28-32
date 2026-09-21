<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('password')
                    ->password()
                    ->default('demo1234')
                    ->required(),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                Select::make('centercode')
                    ->label('Centro')
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        $set('center', DB::table('centers')->where('centercode', $state)->value('center'));
                    }),
                Hidden::make('center'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('token'),
                DateTimePicker::make('token_expires'),
                DateTimePicker::make('activation_date'),
                TextInput::make('secret'),
                Toggle::make('secret_verified'),
                DateTimePicker::make('tos_date'),
                Toggle::make('active'),
                Toggle::make('is_superuser'),
                TextInput::make('role')
                    ->default('user'),
                DateTimePicker::make('created'),
                DateTimePicker::make('modified'),
                DateTimePicker::make('last_login'),
                Textarea::make('additional_data')
                    ->columnSpanFull(),
                TextInput::make('phonepriv')
                    ->tel(),
                TextInput::make('created_by'),
                TextInput::make('modified_by'),
                Toggle::make('isispector'),
            ]);
    }
}
