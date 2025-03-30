<?php

namespace Mydnic\VoletFeatureBoard;

use Illuminate\Support\ServiceProvider;

class FeatureBoardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/volet-feature-board.php' => config_path('volet-feature-board.php'),
            ], 'volet-feature-board-config');

            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js/vendor/volet-feature-board'),
            ], 'volet-feature-board-js');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/volet-feature-board.php',
            'volet-feature-board'
        );
    }
}
