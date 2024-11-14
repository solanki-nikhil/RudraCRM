<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for your application.
     *
     * @return void
     */
    public function register()
    {
        // Here you can register your own exception handling logic
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Custom handling for specific exceptions
        if ($this->isHttpException($exception)) {
            // If it's a 404 error, we can customize the 404 page
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.404', [], 404);
            }
        }

        // Default exception handling for other types of exceptions
        return parent::render($request, $exception);
    }
}
