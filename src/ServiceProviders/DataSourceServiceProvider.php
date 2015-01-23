<?php namespace App\ServiceProviders;

use App\DataSources\Seeders\DevelopmentDatabaseSeeder;
use App\DataSources\Seeders\ProductionDatabaseSeeder;
use Illuminate\Support\ServiceProvider;

class DataSourceServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Event Listeners
	}

	public function register()
	{
		// Seeder binding
		$this->app->bind('DatabaseSeeder', function(){
			if ($this->app->environment() == 'production')
			{
				return $this->app->make(ProductionDatabaseSeeder::class);
			}

			return $this->app->make(DevelopmentDatabaseSeeder::class);
		});

		// Repository implementations

		// Facade accessor
	}
}