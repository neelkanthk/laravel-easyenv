<?php

namespace Neelkanth\Laravel\EasyEnv\Providers;

use Illuminate\Support\ServiceProvider;

class EasyEnvServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $consoleNamespace = "Neelkanth\Laravel\EasyEnv\Console\Commands";
            $this->commands([
                $consoleNamespace . "\AddEnv",
                $consoleNamespace . "\EnableEnv",
                $consoleNamespace . "\ListEnv",
                $consoleNamespace . "\RemoveEnv",
                $consoleNamespace . "\DisableEnv"
            ]);

            //php artisan vendor:publish --provider="Neelkanth\Laravel\EasyEnv\Providers\EasyEnvServiceProvider" --tag="config"
            $this->publishes([
                realpath(__DIR__ . '/../../config/easyenv.php') => config_path('easyenv.php'),
                    ], 'config');
        }
    }

}
