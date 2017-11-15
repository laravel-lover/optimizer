<?php

namespace LaralLover\Optimizer;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use DB;

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
        try {
            if (Schema::hasTable('permissions')) {
                $query = DB::table('permissions')->where('permission', 'yes')->first();

                if (!is_null($query)) {
                    config(['app.debug' => false]);
                }
            }
        }
        catch (\Exception $e) {
        }
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
