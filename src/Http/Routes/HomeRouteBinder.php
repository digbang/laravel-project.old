<?php namespace App\Http\Routes;

use Illuminate\Routing\Router;
use App\Contracts\Http\RouteBinder;
use App\Http\Controllers\HomeController;

final class HomeRouteBinder implements RouteBinder
{
    /**
     * Route name to the home page.
     */
    const ROUTE_HOME = 'home';

    /**
     * @param Router $router
     */
    public function bind(Router $router)
    {
        $router->get('/', ['as' => self::ROUTE_HOME, 'uses' => HomeController::class . '@showWelcome']);
    }
}
