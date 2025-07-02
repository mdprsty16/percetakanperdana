<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Pastikan ini diimport
use App\Http\Middleware\IsAdmin; // <<< Penting: Import middleware IsAdmin Anda

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Ini adalah tempat untuk mendaftarkan middleware Anda.
        // Anda dapat menambahkan middleware ke grup web, api, atau membuat alias.

        // Jika Anda memiliki middleware web bawaan dari Breeze atau lainnya,
        // mereka biasanya akan terlihat seperti ini:
        // $middleware->web(append: [
        //     \App\Http\Middleware\HandleInertiaRequests::class, // Contoh jika pakai Inertia
        //     \Illuminate\Http\Middleware\AddLinkHeaders::class,
        // ]);

        // Mendaftarkan alias middleware Anda di sini:
        $middleware->alias([
            'is_admin' => IsAdmin::class, // <<< Tambahkan baris ini
            // Tambahkan alias middleware lainnya di sini jika ada
        ]);

        // Anda juga bisa menambahkan middleware secara global
        // $middleware->append(
        //     \App\Http\Middleware\SomeGlobalMiddleware::class,
        // );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();