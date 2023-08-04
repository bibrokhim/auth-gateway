<?php

namespace Bibrokhim\AuthGateway;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        config([
            'auth.guards.gateway' => array_merge([
                'driver' => 'header',
                'provider' => null,
            ], config('auth.guards.gateway', [])),
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::resolved(function ($auth) {
            $auth->extend('header', function (Application $app, string $name, array $config) {
                return new GatewayGuard($app['request']->headers);
            });
        });
    }
}
