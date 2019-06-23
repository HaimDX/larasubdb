<?php

namespace HaimDX\LaraSubDB;

use haimdx\larasubdb\Services\LaraSubDB;
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
        //register larasubdb controller
        $this->app->make('haimdx\larasubdb\LaraSubDBController');


        //register facades
        $this->app->bind('larasubdb',function(){
            return new LaraSubDB();
        });


        //load helpers
        //$this->loadHelpers();
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
    }

    /*
     * Function to load all the helpers php classes from the helper folder
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename)
        {
            require_once $filename;
        }
    }


}
