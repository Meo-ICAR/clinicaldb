<x-filament-panels::page>
    <div class="flex justify-end">
        <x-filament::button
            color="gray"
            icon="heroicon-m-clipboard-document"
            x-on:click="navigator.clipboard.writeText(document.getElementById('vibe-prompt-content').value)"
        >
            Copia prompt
        </x-filament::button>
    </div>

    <textarea
        id="vibe-prompt-content"
        readonly
        rows="30"
        class="mt-4 w-full rounded-lg border border-gray-300 bg-gray-50 p-4 font-mono text-sm text-gray-800 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
        style="white-space: pre; resize: vertical;"
    >{{ $this->getPromptContent() }}</textarea>
</x-filament-panels::page>
