<?php

namespace App\Filament\Pages\Documentation;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class UserManual extends Page
{
    protected string $view = 'filament.pages.documentation.user-manual';

    protected static ?string $navigationLabel = null;

    protected static ?string $title = null;

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    public function getTitle(): string
    {
        return __('filament/admin/user_manual.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/user_manual.navigation_label');
    }
}
