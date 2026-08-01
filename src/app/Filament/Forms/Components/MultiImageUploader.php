<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MultiImageUploader extends Field
{

    protected string $view = 'filament.forms.components.multi-image-uploader';

    protected string $disk = 'public';
    protected string $directory = 'gallery-items';
    protected int $maxFiles = 10;
    protected array $acceptedFileTypes = ['image/*'];
    protected int $maxSize = 10240; // 10MB in KB

    public function disk(string $disk): static
    {
        $this->disk = $disk;
        return $this;
    }

    public function directory(string $directory): static
    {
        $this->directory = $directory;
        return $this;
    }

    public function maxFiles(int $maxFiles): static
    {
        $this->maxFiles = $maxFiles;
        return $this;
    }

    public function acceptedFileTypes(array $types): static
    {
        $this->acceptedFileTypes = $types;
        return $this;
    }

    public function maxSize(int $maxSize): static
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getMaxFiles(): int
    {
        return $this->maxFiles;
    }

    public function getAcceptedFileTypes(): array
    {
        return $this->acceptedFileTypes;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    public function getLocales(): array
    {
        return collect(LaravelLocalization::getLocalesOrder())
            ->mapWithKeys(fn (array $properties, string $locale): array => [
                $locale => $properties['native'] ?? strtoupper($locale),
            ])
            ->all();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([]);
    }
}
