<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->stopIgnoring(HttpException::class);

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Heyy! It is Not Found.',
                ], 404);
            }

            
            //return response()->view('errors.invalid-order', [], 500);
        });

        
    
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof RouteNotFoundException) {
            // Handle the RouteNotFoundException
            return response()->json(['error' => 'Unauthorized Access'], 403);
        }

        return parent::render($request, $exception);
    }



}
