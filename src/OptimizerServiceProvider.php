<?php

namespace LaralLover\Optimizer;

use Illuminate\Support\ServiceProvider;

class OptimizerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('optimizer', function ($app) {
            return new Optimizer($app);
        });
    }
}
