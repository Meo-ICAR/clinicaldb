<?php

namespace App\Filament\Resources\Centers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('center'),
                TextInput::make('centercode')
                    ->required(),
            ]);
    }
}
