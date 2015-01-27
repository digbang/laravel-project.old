<?php namespace App\Contracts\Http;

use Illuminate\Routing\Router;

interface RouteBinder
{
    /**
     * Binds routes or filters to the router.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function bind(Router $router);
}
