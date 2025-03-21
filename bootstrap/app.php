<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Console\Scheduling\Schedule; // Change this line
use App\Http\Middleware\CheckSuspended; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware
        $middleware->web(append: [
            // Any additional web middleware you want to add
        ]);
        
        $middleware->api(append: [
            // Any additional API middleware you want to add
        ]);
        
        // Register route middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'check.suspended' => CheckSuspended::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration
    })
    ->withSchedule(function (Schedule $schedule) {
        // Load schedule configuration from bootstrap/schedule.php
        require __DIR__.'/schedule.php';
    })
    ->create();