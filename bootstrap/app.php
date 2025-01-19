<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


# <?php

# use Illuminate\Foundation\Application;
# use Illuminate\Foundation\Configuration\Exceptions;
# use Illuminate\Foundation\Configuration\Middleware;

# $app = new Illuminate\Foundation\Application(
#     dirname(__DIR__)
# );

# $app->withRouting(
#     web: __DIR__ . '/../routes/web.php',
#     api: __DIR__ . '/../routes/api.php',
#     commands: __DIR__ . '/../routes/console.php',
#     health: '/up',
# );

# $app->withMiddleware(function (Middleware $middleware) {
#     $middleware->api(prepend: [
#         \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
#     ]);

#     $middleware->alias([
#         'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
#     ]);
# });

# $app->routeMiddleware([
#     'auth' => \App\Http\Middleware\Authenticate::class,
#     'csrf' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
# ]);

# $app->router->get('/sanctum/csrf-cookie', function () {
#     return response()->json(['csrf_token' => csrf_token()]);
# });

# $app->withExceptions(function (Exceptions $exceptions) {
#     // Itt adhatod meg az egyedi hibakezeléseket
# });

# return $app;