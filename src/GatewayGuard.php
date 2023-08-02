<?php

namespace Bibrokhim\AuthGateway;

use Bibrokhim\AuthGateway\GatewayUserProvider;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\HeaderBag;

class GatewayGuard implements Guard
{
    use GuardHelpers;
    private const USER_ID_HEADER = 'X-User-ID';
    private const USER_TYPE_HEADER = 'X-User-Type';
    private HeaderBag $headers;

    public function __construct(HeaderBag $headers)
    {
        $this->headers = $headers;
        $this->provider = new GatewayUserProvider();
    }

    public function user(): ?Authenticatable
    {

        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        if (
            $this->headers->has(self::USER_ID_HEADER)
            && $this->headers->has(self::USER_TYPE_HEADER)
        )
        {
            $user = $this->provider->retrieveByCredentials([
                $this->headers->get(self::USER_ID_HEADER),
                $this->headers->get(self::USER_TYPE_HEADER)
            ]);
        }


        return $this->user = $user;
    }

    public function validate(array $credentials = []): bool
    {
        if (empty($credentials)) {
            return false;
        }

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }
}