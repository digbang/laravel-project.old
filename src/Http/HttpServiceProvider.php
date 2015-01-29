<?php namespace App\Http;

use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogger();
        $this->registerMaintenanceMode();
        $this->registerErrorHandler();
    }

    public function boot()
    {
        $this->bootComposers();
    }

    private function registerLogger()
    {
        $this->app['log']->useDailyFiles(storage_path('logs') . '/laravel.log');
    }

    private function registerMaintenanceMode()
    {
        $this->app->down(function()
        {
            return \Response::make("Be right back!", 503);
        });
    }

    private function registerErrorHandler()
    {
        $this->app->error(function(\Exception $exception){
            $this->app['log']->error($exception);

            if (! $this->app['config']->get('app.debug'))
            {
                return \Response::view('templates.error');
            }
        });
    }

    public function bootComposers()
    {
        /** @type \Illuminate\View\Factory $viewFactory */
        $viewFactory = $this->app['view'];

        foreach ($this->getClassesIn(__DIR__.'/Composers') as $className)
        {
            $this->app->make($className)->bind($viewFactory);
        }
    }

    private function getClassesIn($directory)
    {
        $namespace = "App\\Http\\" . basename($directory) . "\\";

        $classes = [];
        foreach (new \DirectoryIterator($directory) as $fileInfo)
        {
            if (! $fileInfo->isDot() && $fileInfo->getExtension() == 'php')
            {
                $classes[] = $namespace . $fileInfo->getBasename('.php');
            }
        }

        return $classes;
    }
}
