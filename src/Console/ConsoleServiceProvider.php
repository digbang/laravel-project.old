<?php namespace App\Console;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    // Nothing here...
    }

	public function boot()
	{
        $this->commands([
            // Add Commands\Objects::class here
        ]);
    }
}
