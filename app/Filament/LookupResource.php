<?php

namespace App\Filament;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as DatabaseSchema;
use Illuminate\Support\Str;
use UnitEnum;

abstract class LookupResource extends Resource
{
    protected static UnitEnum|string|null $navigationGroup = 'Tabelle di lookup';

    public static function getNavigationLabel(): string
    {
        $model = static::getModel();
        $table = (new $model)->getTable();
        $comment = DB::table('information_schema.tables')
            ->where('table_schema', DB::connection()->getDatabaseName())
            ->where('table_name', $table)
            ->value('table_comment');

        if (blank($comment)) {
            return Str::headline(Str::singular((new $model)->getTable()));
        }

        $label = Str::before($comment, '. ');
        $label = Str::replaceFirst('Dizionario per ', '', $label);
        $label = Str::replaceFirst('Anagrafica dei ', '', $label);
        $label = Str::before($label, ',');

        return Str::ucfirst($label);
    }

    public static function form(Schema $schema): Schema
    {
        $model = static::getModel();
        $table = (new $model)->getTable();
        $columns = DatabaseSchema::getColumnListing($table);

        return $schema->components(array_map(
            fn (string $column) => self::formComponent($column),
            $columns,
        ));
    }

    public static function table(Table $table): Table
    {
        $model = static::getModel();
        $modelInstance = new $model;
        $columns = DatabaseSchema::getColumnListing($modelInstance->getTable());
        $key = $modelInstance->getKeyName();

        return $table
            ->columns(array_map(
                fn (string $column) => TextInputColumn::make($column)
                    ->label(Str::headline($column))
                    ->searchable()
                    ->sortable(),
                $columns,
            ))
            ->defaultSort($key)
            ->recordUrl(fn (Model $record): ?string => filled($record->getKey())
                ? static::getUrl('edit', ['record' => $record])
                : null)
            ->recordActions([
                EditAction::make()->hidden(fn (Model $record): bool => blank($record->getKey())),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function formComponent(string $column): TextInput|Textarea
    {
        $component = in_array($column, ['testo', 'description', 'commenti'], true)
            ? Textarea::make($column)
            : TextInput::make($column);

        return $component
            ->label(Str::headline($column))
            ->required($column === (new (static::getModel))->getKeyName())
            ->maxLength(255);
    }
}
