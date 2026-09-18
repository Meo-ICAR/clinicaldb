<?php

namespace App\Filament\Resources\Stenosis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StenosiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
            ]);
    }
}
