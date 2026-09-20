<?php

namespace App\Filament\Pages\Documentation;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class UserManual extends Page
{
    protected string $view = 'filament.pages.documentation.user-manual';

    protected static ?string $navigationLabel = 'Manuale utente';

    protected static ?string $title = 'Manuale utente';

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
}
