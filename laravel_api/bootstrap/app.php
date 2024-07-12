<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $exception){
            return response()->json([
                'status_code' => Response::HTTP_NOT_FOUND,
                'message' => $exception->getMessage()
            ]);
        });
        $exceptions->render(function(ValidationException $exception){
            return response()->json([
                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ]);
        });
        $exceptions->render(function (MethodNotAllowedHttpException $exception) {
            return response()->json([
                'status_code' => Response::HTTP_METHOD_NOT_ALLOWED,
                'message' => $exception->getMessage()
            ]);
        });
        $exceptions->render(function (BadRequestHttpException $exception) {
            return response()->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => $exception->getMessage()
            ]);
        });

    })->create();