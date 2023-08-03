<?php

namespace Bibrokhim\AuthGateway;

class AuthGateway
{
    public static function actingAs(User $user)
    {
        app('auth')->guard('gateway')->setUser($user);
        app('auth')->shouldUse('gateway');

        return $user;
    }
}