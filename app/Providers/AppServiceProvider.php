<?php

namespace App\Providers;

use App\Listeners\AssignDefaultRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        // Register event listener for assigning default role
        Event::listen(
            Registered::class,
            AssignDefaultRole::class,
        );
    }
}
