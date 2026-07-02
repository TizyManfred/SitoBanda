<x-filament-panels::page>
    <x-filament-panels::form wire:submit="executeCommand">
        {{ $this->form }}

        <div class="flex items-center justify-end gap-4">
            <x-filament::button type="submit">
                {{ __('filament.artisan_commands.execute') }}
            </x-filament::button>
        </div>
    </x-filament-panels::form>

    @if($output)
        <x-filament::section class="mt-6">
            <h3 class="text-lg font-medium">{{ __('filament.artisan_commands.output') }}</h3>
            <div class="mt-2 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg font-mono text-sm whitespace-pre overflow-x-auto">
                {{ $output }}
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
