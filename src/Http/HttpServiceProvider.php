<?php namespace App\Http;

use Illuminate\Log\Writer;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMaintenanceMode();
        $this->registerErrorHandler();
    }

	/**
	 * Boot the application layer
	 */
    public function boot()
    {
        $this->bootLogger($this->app['log']);
        $this->bootComposers($this->app['view']);
    }

	/**
	 * Register maintenance mode response
	 */
	private function registerMaintenanceMode()
    {
        $this->app->down(function()
        {
            return Response::make("Be right back!", 503);
        });
    }

	/**
	 * Register the basic error handlers
	 */
	private function registerErrorHandler()
    {
        $this->app->error(function(\Exception $exception){
            $this->app['log']->error($exception);

            if (! $this->app['config']->get('app.debug'))
            {
                return Response::view('templates.error', [], 500);
            }
        });

        $this->app->error(function(NotFoundHttpException $exception){
            $this->app['log']->error($exception);

            if (! $this->app['config']->get('app.debug'))
            {
                return Response::view('templates.not-found', [], 404);
            }
        });
    }

	/**
	 * Boot the logger
	 *
	 * @param Writer $logger
	 */
	private function bootLogger(Writer $logger)
	{
		$logger->useDailyFiles(storage_path('logs') . '/laravel.log');
	}

	/**
	 * Boot the view composer files
	 *
	 * @param Factory $viewFactory
	 */
	public function bootComposers(Factory $viewFactory)
    {
        foreach ($this->getClassesIn(__DIR__.'/Composers') as $className)
        {
            $this->app->make($className)->bind($viewFactory);
        }
    }

	/**
	 * Generator for easy directory iteration
	 * @param $directory
	 * @return \Generator
	 */
    private function getClassesIn($directory)
    {
        $namespace = "App\\Http\\" . basename($directory) . "\\";

        foreach (new \DirectoryIterator($directory) as $fileInfo)
        {
            if ($fileInfo->getExtension() == 'php')
            {
                yield $namespace . $fileInfo->getBasename('.php');
            }
        }
    }
}
