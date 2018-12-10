<?php

namespace Wecode\Generator;

use Illuminate\Support\ServiceProvider;

use Wecode\Generator\Commands\Resources;

class GeneratorServiceProvider extends ServiceProvider
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
