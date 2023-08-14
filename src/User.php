<?php

namespace Bibrokhim\AuthGateway;

use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{

    public function __construct(
        public int $id,
        public string $type,
        public string $platform,
    )
    {
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword()
    {

    }

    public function getRememberToken()
    {

    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName()
    {

    }
}
