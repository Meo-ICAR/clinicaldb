<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Patient;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RecentlyModifiedPatients extends TableWidget
{
    protected static ?string $heading = 'Ultimi pazienti modificati';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Patient::query()
                ->where('modified_by', auth()->id())
                ->latest('modified')
                ->limit(3))
            ->paginated(false)
            ->columns([
                TextColumn::make('pazientecode')->label('Codice'),
                TextColumn::make('iniziali')->label('Iniziali'),
                TextColumn::make('centrocode')->label('Centro'),
                TextColumn::make('modified')->label('Modificato il')->dateTime('d/m/Y H:i'),
            ])
            ->recordUrl(fn (Model $record): string => PatientResource::getUrl('edit', ['record' => $record]));
    }
}
