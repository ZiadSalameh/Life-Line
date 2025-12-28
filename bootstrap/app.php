<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
// use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => IsUserAuth::class,
            'admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Validation errors (422)
        $exceptions->renderable(function (ValidationException $e, $request) {
            if (! $request->is('api/*')) return null;

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Validation Error',
                    'message' => 'The given data was invalid.',
                    'details' => $e->errors(),
                ],
            ], 422);
        });

        // Authentication (401)
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            if (! $request->is('api/*')) return null;

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Unauthorized',
                    'message' => 'Authentication required.',
                ],
            ], 401);
        });

        // Model not found (404)
        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            if (! $request->is('api/*')) return null;

            $model = class_basename($e->getModel());

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Not Found',
                    'message' => "{$model} not found.",
                ],
            ], 404);
        });

        // Route not found (404)
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if (! $request->is('api/*')) return null;

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Not Found',
                    'message' => 'Resource not found.',
                ],
            ], 404);
        });

        // Method not allowed (405)
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if (! $request->is('api/*')) return null;

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Method Not Allowed',
                    'message' => 'HTTP method not allowed.',
                ],
            ], 405);
        });

        // Fallback (500)
        $exceptions->renderable(function (Throwable $e, $request) {
            if (! $request->is('api/*')) return null;

            return response()->json([
                'success' => false,
                'error' => [
                    'title' => 'Server Error',
                    'message' => 'Unexpected server error.',
                ],
            ], 500);
        });
    })
    ->create();

// use App\Http\Middleware\IsAdmin;
// use App\Http\Middleware\IsUserAuth;
// use Illuminate\Foundation\Application;
// use Illuminate\Foundation\Configuration\Exceptions;
// use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__ . '/../routes/web.php',
//         api: __DIR__ . '/../routes/api.php',
//         commands: __DIR__ . '/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         $middleware->alias([
//             'auth' => IsUserAuth::class,
//             'admin' => IsAdmin::class
//         ]);
//     })
//     ->withExceptions(function (Exceptions $exceptions) {

//         $exceptions->renderable(function (ModelNotFoundException $e) {
//             $model = class_basename($e->getModel());

//             return response()->json([
//                 'success' => false,
//                 'message' => "{$model} not found",
//                 'data' => null
//             ], 404);
//         });

//         $exceptions->renderable(function (NotFoundHttpException $e) {

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Resource not found',
//                 'data' => null
//             ], 404);
//         });
//     })->create();
