<?php namespace App\ServiceProviders;

use App\Http\Controllers;
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

    private function registerErrorHandler()
    {
        $this->app->error(function(\Exception $exception){
            if (! $this->app['config']->get('app.debug'))
            {
                return \Response::view('templates.error');
            }
        });
    }

    public function boot()
    {
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        /** @type \Illuminate\Routing\Router $router */
        $router = $this->app['router'];

        $routeClasses = [
            'ProjectRoutes',
            'EnvironmentRoutes',
        ];

        foreach ($routeClasses as $routeClass)
        {
            $this->app->make($routeClass)->addRoutes($router);
        }

        $router->get('/', $this->asUses('home', Controllers\HomeController::class . '@showWelcome'));
    }

    private function asUses($routeName, $controllerNamedMethod)
    {
        return [
            'as' => $routeName,
            'uses' => $controllerNamedMethod
        ];
    }
}
