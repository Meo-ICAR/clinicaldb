<?php

namespace App\Filament\Resources\Endolumiales\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EndolumialeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
            ]);
    }
}
