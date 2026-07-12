<?php

namespace App\Filament\Pages;

use BladeUI\Icons\Console\CacheCommand as IconsCacheCommand;
use BladeUI\Icons\Console\ClearCommand as IconsClearCommand;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ArtisanCommands extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-command-line';
    protected static string $view = 'filament.pages.artisan-commands';
    
    public ?string $selectedCommand = '';
    public ?string $output = '';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('selectedCommand')
                            ->label(__('filament.artisan_commands.select_command'))
                            ->options(static::allowedCommands())
                            ->required()
                            ->searchable(),
                    ])
            ]);
    }
    
    public function executeCommand()
    {
        $command = $this->selectedCommand;

        if (! array_key_exists($command, static::allowedCommands())) {
            Notification::make()
                ->title(__('filament.artisan_commands.invalid_command'))
                ->danger()
                ->send();

            return;
        }
        
        try {
            if (in_array($command, ['filament:optimize', 'filament:optimize-clear'], true)) {
                Artisan::resolveCommands([
                    IconsCacheCommand::class,
                    IconsClearCommand::class,
                ]);
            }

            Artisan::call($command);
            $output = Artisan::output();
            
            Notification::make()
                ->title(__('filament.artisan_commands.executed'))
                ->success()
                ->send();
                
            $this->output = $output ?: __('filament.artisan_commands.empty_output');
            
        } catch (\Exception $e) {
            Notification::make()
                ->title(__('filament.artisan_commands.error'))
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            $this->output = 'Error: ' . $e->getMessage();
        }
    }
    
    public static function canAccess(): bool
    {
        if (app()->isLocal()) {
            return true;
        }

        if (! (bool) config('services.artisan_commands.enabled', false)) {
            return false;
        }

        $allowedEmails = array_filter(array_map(
            'trim',
            explode(',', (string) config('services.artisan_commands.allowed_emails', ''))
        ));

        if ($allowedEmails === []) {
            return false;
        }

        return in_array((string) Auth::user()?->email, $allowedEmails, true);
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.artisan_commands.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.system');
    }

    protected static function allowedCommands(): array
    {
        return [
            'storage:link' => __('filament.artisan_commands.commands.storage_link'),
            'migrate' => __('filament.artisan_commands.commands.migrate'),
            'migrate --force' => __('filament.artisan_commands.commands.migrate_force'),
            'optimize:clear' => __('filament.artisan_commands.commands.optimize_clear'),
            'package:discover' => __('filament.artisan_commands.commands.package_discover'),
            'view:clear' => __('filament.artisan_commands.commands.view_clear'),
            'config:clear' => __('filament.artisan_commands.commands.config_clear'),
            'route:clear' => __('filament.artisan_commands.commands.route_clear'),
            'cache:clear' => __('filament.artisan_commands.commands.cache_clear'),
            'lang:publish' => __('filament.artisan_commands.commands.lang_publish'),
            'filament:assets' => __('filament.artisan_commands.commands.filament_assets'),
            'filament:upgrade' => __('filament.artisan_commands.commands.filament_upgrade'),
            'filament:optimize-clear' => __('filament.artisan_commands.commands.filament_optimize_clear'),
            'filament:optimize' => __('filament.artisan_commands.commands.filament_optimize'),
        ];
    }
}
