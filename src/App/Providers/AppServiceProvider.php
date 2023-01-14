<?php

namespace App\Providers;

use DB;
use Domain\Core\Models\Player;
use Domain\Core\Observers\PlayerObserver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\'.class_basename($modelName).'Factory';
        });

        // TODO: Open an issue at filament to allow this
        // Model::shouldBeStrict(config('app.env') !== 'production');
    }
}
