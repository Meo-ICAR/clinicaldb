<?php

namespace App\Filament\Pages\Documentation;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class VibeCodingPrompt extends Page
{
    protected string $view = 'filament.pages.documentation.vibe-coding-prompt';

    protected static ?string $navigationLabel = 'Prompt vibe coding';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Prompt per vibe coding';

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public function getPromptContent(): string
    {
        return file_get_contents(resource_path('docs/prompt-vibe-coding.md'));
    }
}
