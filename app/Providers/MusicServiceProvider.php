<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MusicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(
            'MusicService',
            'App\Http\Components\MusicService'
        );
    }
}
