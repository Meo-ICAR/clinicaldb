<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PatientVisits\PatientVisitResource;
use App\Models\PatientVisit;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RecentlyModifiedVisits extends TableWidget
{
    protected static ?string $heading = 'Ultime visite modificate';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => PatientVisit::query()
                ->where('modified_by', auth()->id())
                ->latest('modified')
                ->limit(3))
            ->paginated(false)
            ->columns([
                TextColumn::make('patient.pazientecode')->label('Paziente'),
                TextColumn::make('visitadel')->label('Data visita')->date('d/m/Y'),
                TextColumn::make('centrocode')->label('Centro'),
                TextColumn::make('modified')->label('Modificata il')->dateTime('d/m/Y H:i'),
            ])
            ->recordUrl(fn (Model $record): string => PatientVisitResource::getUrl('edit', ['record' => $record]));
    }
}
