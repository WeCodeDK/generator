<?php

namespace Wecode\Pattern;

use Illuminate\Support\ServiceProvider;

use Wecode\Pattern\Commands\Resources;

class PatternServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([Resources::class]);
    }
}
