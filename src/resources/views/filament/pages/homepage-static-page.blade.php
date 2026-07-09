<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="flex items-center justify-end gap-4">
            <x-filament::button type="submit">
                {{ __('filament.homepage_static.save') }}
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
