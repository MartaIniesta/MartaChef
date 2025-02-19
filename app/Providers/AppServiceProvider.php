<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Listeners\SendPostNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
