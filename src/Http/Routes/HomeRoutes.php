<?php namespace App\Http\Routes;

use Illuminate\Routing\Router;
use GuiWoda\RouteBinder\RouteBinder;
use App\Http\Controllers\HomeController;

final class HomeRoutes implements RouteBinder
{
    /**
     * Route name to the home page.
     */
    const HOME = 'home';

    /**
     * @param Router $router
     */
    public function bind(Router $router)
    {
        $router->get('/', ['as' => self::HOME, 'uses' => HomeController::class . '@showWelcome']);
    }
}
