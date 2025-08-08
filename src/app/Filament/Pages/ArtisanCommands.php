<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class ArtisanCommands extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-command-line';
    protected static ?string $navigationLabel = 'Artisan Commands';
    protected static ?string $navigationGroup = 'Sistema';
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
                            ->label('Select Command')
                            ->options([
                                'storage:link' => 'Create Storage Link',
                                'migrate' => 'Run Migrations',
                                'migrate:fresh --seed' => 'Fresh Migrate + Seed',
                                'optimize:clear' => 'Clear Cache',
                                'view:clear' => 'Clear View Cache',
                                'config:clear' => 'Clear Config Cache',
                                'route:clear' => 'Clear Route Cache',
                                'cache:clear' => 'Clear Application Cache',
                                'lang:publish' => 'Publish languages',
                                'filament:assets' => 'Publish Filament assets',
                            ])
                            ->required()
                            ->searchable(),
                    ])
            ]);
    }
    
    public function executeCommand()
    {
        $command = $this->selectedCommand;
        
        try {
            Artisan::call($command);
            $output = Artisan::output();
            
            Notification::make()
                ->title('Command executed successfully!')
                ->success()
                ->send();
                
            $this->output = $output ?: 'Command executed successfully with no output';
            
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error executing command')
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            $this->output = 'Error: ' . $e->getMessage();
        }
    }
    
    public static function canAccess(): bool
    {
        // Allow all authenticated users to access this page
        return true;
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
