<?php
namespace App\Providers;

use App\Infrastructure\Seeders\DevDatabaseSeeder;
use App\Infrastructure\Seeders\LiveDatabaseSeeder;
use Illuminate\Support\ServiceProvider;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DatabaseSeeder', function(){
            return $this->app['config']->get('app.debug')
	            ? new DevDatabaseSeeder
	            : new LiveDatabaseSeeder;
        });
    }
}
