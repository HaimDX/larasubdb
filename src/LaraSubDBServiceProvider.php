<?php

namespace HaimDX\LaraSubDB;

use HaimDX\LaraSubDB\Services\LaraSubDB;
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
            __DIR__ . '/config/main.php' =>  config_path('main.php'),
        ], 'config');

        //facade binding
        $this->app->singleton(LaraSubDB::class, function () {
            return new LaraSubDB();
        });

        $this->app->alias(LaraSubDB::class, 'larasubdb');
    }




}
