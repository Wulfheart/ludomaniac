<?php

namespace RyanChandler\FilamentSimpleRepeater;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentSimpleRepeaterServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-simple-repeater';

    protected array $styles = [
        'simple-repeater-field' => __DIR__ . '/../resources/dist/plugin.css',
    ];

    public function packageConfigured(Package $package): void
    {
        $package->hasAssets();
    }
}
