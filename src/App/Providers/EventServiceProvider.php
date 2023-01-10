<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Symfony\Component\Finder\Finder;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }

    public function discoverEventsWithin(): array
    {
        return collect(
            Finder::create()
                ->in($this->app->basePath('src/Domain'))
                ->directories()
                ->getIterator()
        )
            ->keys()
            ->toArray();
    }

    public function eventDiscoveryBasePath()
    {
        return $this->app->basePath('src');
    }
}
