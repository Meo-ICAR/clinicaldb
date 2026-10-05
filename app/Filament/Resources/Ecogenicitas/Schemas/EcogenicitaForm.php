<?php

namespace App\Filament\Resources\Ecogenicitas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EcogenicitaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
            ]);
    }
}
