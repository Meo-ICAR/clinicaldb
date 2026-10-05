<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('archiprevaleatDashboard')
                ->label('Dashboard ARCHIPREVALEAT')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->url('https://dashboard.archiprevaleat.com')
                ->openUrlInNewTab(),
        ];
    }
}
