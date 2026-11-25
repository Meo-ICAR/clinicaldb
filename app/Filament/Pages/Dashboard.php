<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return __('filament/admin/dashboard.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/dashboard.title');
    }
}
