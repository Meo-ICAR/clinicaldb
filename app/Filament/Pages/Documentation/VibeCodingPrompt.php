<?php

namespace App\Filament\Pages\Documentation;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class VibeCodingPrompt extends Page
{
    protected string $view = 'filament.pages.documentation.vibe-coding-prompt';

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = null;

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public function getPromptContent(): string
    {
        return file_get_contents(resource_path('docs/prompt-vibe-coding.md'));
    }

    public function getTitle(): string
    {
        return __('filament/admin/vibe_coding_prompt.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament/admin/vibe_coding_prompt.navigation_label');
    }
}
