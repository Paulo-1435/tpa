<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         * GUIA – Q4 (middleware 'organizador')
         *
         * 1. Crie a classe: php artisan make:middleware EnsureUserIsOrganizador
         *    (o nome da classe é livre; o que é contrato é o apelido)
         * 2. No handle() dela (app/Http/Middleware/...), antes do
         *    "return $next($request);":
         *      if ($request->user()?->tipo !== 'organizador') {
         *          abort(403);
         *      }
         *    O abort(403) mostra a view resources/views/errors/403.blade.php,
         *    que já está pronta.
         * 3. Registre o apelido AQUI, no lugar deste comentário:
         *      $middleware->alias([
         *          'organizador' => \App\Http\Middleware\EnsureUserIsOrganizador::class,
         *      ]);
         * 4. Aplique 'organizador' nas rotas de cadastro em routes/web.php.
         */
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
