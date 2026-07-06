<?php

namespace Bibrokhim\AuthGateway;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    private array $extraAttributes = [];

    public function __construct(
        public readonly int $id,
        private readonly string $type,
        private readonly string $platform,
        array $extraAttributes = []
    )
    {
        $this->extraAttributes = $extraAttributes;
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

    public function getAuthPasswordName()
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function getKey(): int
    {
        return $this->id;
    }

    public function __get($key)
    {
        $headerKey = 'x-' . str_replace('_', '-', strtolower($key));

        if (array_key_exists($headerKey, $this->extraAttributes)) {
            $value = $this->extraAttributes[$headerKey];
            return is_array($value) ? $value[0] : $value;
        }

        return parent::__get($key);
    }
}
