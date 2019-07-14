<?php

namespace HaimDX\LaraSubDB;

use haimdx\larasubdb\Services\LaraSubDB;
//use HaimDX\LaraSubDB\Services\LaraSubDB;
use Illuminate\Support\ServiceProvider;

class LaraSubDBServiceProvider extends ServiceProvider
{
    /*
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/larasubdbconfig.php', 'larasubdb-main'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //register routes
        $this->loadRoutesFrom(__DIR__.'/routes/main.php');

        //publish config file
        $this->publishes([
            __DIR__ . '/config' =>  config_path('larasubdb'),
        ], 'config');

        //facade binding
        $this->app->singleton(LaraSubDB::class, function () {
            return new LaraSubDB();
        });

        $this->app->alias(LaraSubDB::class, 'larasubdb');
    }




}
