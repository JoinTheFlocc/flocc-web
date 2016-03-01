<?php

namespace Flocc\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Flocc\Events\SomeEvent' => [
            'Flocc\Listeners\EventListener',
        ],
        SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Google\GoogleExtendSocialite@handle',
            'SocialiteProviders\Live\LiveExtendSocialite@handle',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
