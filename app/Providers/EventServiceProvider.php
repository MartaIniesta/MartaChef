<?php

namespace App\Providers;

use App\Events\PostCreatedEvent;
use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use App\Listeners\SendFollowNotificationListener;
use App\Listeners\SendPostNotificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PostCreatedEvent::class => [
            SendPostNotificationListener::class,
        ],
        UserFollowedEvent::class => [
            SendFollowNotificationListener::class,
        ],
        UserUnfollowedEvent::class => [
            SendFollowNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
