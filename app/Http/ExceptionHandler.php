<?php
namespace App\Http;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $e
     * @return mixed
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug')) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

            return response()->make(
                $whoops->handleException($e),
                method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                method_exists($e, 'getHeaders') ? $e->getHeaders() : []
            );
        }

        return parent::convertExceptionToResponse($e);
    }
}
