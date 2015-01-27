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
        $this->registerErrorHandler();
    }

    public function boot()
    {
        $this->bootRoutes();
        $this->bootFilters();
        $this->bootComposers();
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

    private function bootRoutes()
    {
        /** @type \Illuminate\Routing\Router $router */
        $router = $this->app['router'];

        foreach ($this->getClassesIn(__DIR__.'/Routes') as $className)
        {
            $this->app->make($className)->bind($router);
        }
    }

    private function bootFilters()
    {
        /** @type \Illuminate\Routing\Router $router */
        $router = $this->app['router'];

        foreach ($this->getClassesIn(__DIR__.'/Filters') as $className)
        {
            $this->app->make($className)->bind($router);
        }
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
