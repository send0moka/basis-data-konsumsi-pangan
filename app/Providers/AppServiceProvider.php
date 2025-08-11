<?php

namespace App\Providers;

use App\Listeners\AssignDefaultRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
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
        // Set timezone for database connections
        if (config('database.default') === 'sqlite') {
            // For SQLite, we need to handle timezone conversion in the application layer
            // SQLite doesn't have built-in timezone support
        } elseif (config('database.default') === 'mysql') {
            // For MySQL, set the timezone
            DB::statement("SET time_zone = '+07:00'");
        }

        // Register event listener for assigning default role
        Event::listen(
            Registered::class,
            AssignDefaultRole::class,
        );
    }
}
