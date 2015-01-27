<?php namespace App\Http\Filters;

use App\Contracts\Http\RouteBinder;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Session\Store;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class AuthFilters implements RouteBinder
{
    /**
     * Default authentication. Uses Auth::guest and redirects
     * to the login route if not an AJAX request.
     */
    const AUTH_DEFAULT = 'auth';

    /**
     * Basic HTTP authentication.
     */
    const AUTH_BASIC = 'auth.basic';

    /**
     * Use this to only allow access to unlogged users.
     */
    const AUTH_GUEST = 'guest';

    /**
     * CSRF protection for forms.
     */
    const AUTH_CSRF  = 'csrf';

    /**
     * @type \Illuminate\Auth\AuthManager
     */
    private $authManager;

    /**
     * @type \Illuminate\Http\Request
     */
    private $request;

    /**
     * @type \Illuminate\Routing\Redirector
     */
    private $redirector;

    /**
     * @type \Illuminate\Session\Store
     */
    private $session;

    /**
     * @param \Illuminate\Auth\AuthManager   $authManager
     * @param \Illuminate\Http\Request       $request
     * @param \Illuminate\Routing\Redirector $redirector
     * @param \Illuminate\Session\Store      $session
     */
    public function __construct(AuthManager $authManager, Request $request, Redirector $redirector, Store $session)
    {
        $this->authManager = $authManager;
        $this->request     = $request;
        $this->redirector  = $redirector;
        $this->session     = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function bind(Router $router)
    {
        /** @type \Illuminate\Auth\Guard $guard */
        $guard = $this->authManager->driver();

        $router->filter(self::AUTH_DEFAULT, function() use ($guard)
        {
            if (! $guard->guest())
            {
                return null;
            }

            if ($this->request->ajax())
            {
                throw new UnauthorizedHttpException(
                    sprintf('Basic realm="%s"', array_get($_ENV, 'DOMAIN', 'project-name'))
                );
            }

            return $this->redirector->guest(route('login'));
        });


        $router->filter(self::AUTH_BASIC, function() use ($guard)
        {
            return $guard->basic();
        });

        $router->filter(self::AUTH_GUEST, function() use ($guard)
        {
            if ($guard->check())
            {
                return $this->redirector->to('/');
            }
        });

        $router->filter(self::AUTH_CSRF, function()
        {
            if ($this->session->token() !== $this->request->get('_token'))
            {
                throw new TokenMismatchException;
            }
        });
    }
}
