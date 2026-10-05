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
                    ->label(__('filament/admin/user_resource.username'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('filament/admin/user_resource.email'))
                    ->email(),
                TextInput::make('password')
                    ->label(__('filament/admin/user_resource.password'))
                    ->password()
                    ->default('demo1234')
                    ->required(),
                TextInput::make('first_name')
                    ->label(__('filament/admin/user_resource.first_name')),
                TextInput::make('last_name')
                    ->label(__('filament/admin/user_resource.last_name')),
                Select::make('centercode')
                    ->label(__('filament/admin/user_resource.centercode'))
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        $set('center', DB::table('centers')->where('centercode', $state)->value('center'));
                    }),
                Hidden::make('center')
                    ->label(__('filament/admin/user_resource.center')),
                TextInput::make('phone')
                    ->label(__('filament/admin/user_resource.phone'))
                    ->tel(),
                TextInput::make('token')
                    ->label(__('filament/admin/user_resource.token')),
                DateTimePicker::make('token_expires')
                    ->label(__('filament/admin/user_resource.token_expires')),
                DateTimePicker::make('activation_date')
                    ->label(__('filament/admin/user_resource.activation_date')),
                TextInput::make('secret')
                    ->label(__('filament/admin/user_resource.secret')),
                Toggle::make('secret_verified')
                    ->label(__('filament/admin/user_resource.secret_verified')),
                DateTimePicker::make('tos_date')
                    ->label(__('filament/admin/user_resource.tos_date')),
                Toggle::make('active')
                    ->label(__('filament/admin/user_resource.active')),
                Toggle::make('is_superuser')
                    ->label(__('filament/admin/user_resource.is_superuser')),
                TextInput::make('role')
                    ->label(__('filament/admin/user_resource.role'))
                    ->default('user'),
                DateTimePicker::make('created')
                    ->label(__('filament/admin/user_resource.created')),
                DateTimePicker::make('modified')
                    ->label(__('filament/admin/user_resource.modified')),
                DateTimePicker::make('last_login')
                    ->label(__('filament/admin/user_resource.last_login')),
                Textarea::make('additional_data')
                    ->label(__('filament/admin/user_resource.additional_data'))
                    ->columnSpanFull(),
                TextInput::make('phonepriv')
                    ->label(__('filament/admin/user_resource.phonepriv'))
                    ->tel(),
                TextInput::make('created_by')
                    ->label(__('filament/admin/user_resource.created_by')),
                TextInput::make('modified_by')
                    ->label(__('filament/admin/user_resource.modified_by')),
                Toggle::make('isispector')
                    ->label(__('filament/admin/user_resource.isispector')),
            ]);
    }
}
