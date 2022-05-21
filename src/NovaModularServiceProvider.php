<?php

namespace Badinansoft\NovaModular;

use Badinansoft\NovaModular\Console\ModuleCommand;
use Illuminate\Support\ServiceProvider;

class NovaModularServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nova-modular');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-modular');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/nova-modular'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/nova-modular'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-modular'),
            ], 'lang');*/

          //   Registering package commands.
             $this->commands([
                 ModuleCommand::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}
