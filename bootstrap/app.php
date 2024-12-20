<?php

use App\Dto\ResponseApiDto;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                $response = new ResponseApiDto(false, 401, 'Unauthorized');
                return response()->json($response->toArray(), 401);
            } else {
                return redirect()->route('login');
            }
        });

        // $middleware->append(AdminMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                $response = new ResponseApiDto(false, 401, $e->getMessage());
                return response()->json($response->toArray(), 401);
            }
        });
    })->create();
