<?php namespace App\DataSources;

use Illuminate\Support\ServiceProvider;

class DataSourcesServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Event Listeners
	}

	public function register()
	{
		$this->registerSeeder();

		// Repository implementations

		// Facade accessor
	}

	private function registerSeeder()
	{
		$this->app->bind('DatabaseSeeder', function (){
			if ($this->app->environment() == 'production')
			{
				return $this->app->make(Seeders\ProductionDatabaseSeeder::class);
			}

			return $this->app->make(Seeders\DevelopmentDatabaseSeeder::class);
		});
	}
}