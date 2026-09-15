<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class OdbcUser implements Authenticatable
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * OdbcUser constructor.
     *
     * @param array|object $attributes
     */
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        $this->attributes = $attributes;
    }

    /**
     * Magic getter for attributes.
     */
    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    /**
     * Magic setter for attributes.
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Magic isset for attributes.
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Get array representation of user attributes.
     *
     * @return array
     */
    public function toArray()
    {
        $data = $this->attributes;
        unset($data['password_hash']);
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Authenticatable Interface Methods
    |--------------------------------------------------------------------------
    */

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return isset($this->attributes['id']) ? $this->attributes['id'] : null;
    }

    public function getAuthPassword()
    {
        return isset($this->attributes['password_hash']) ? $this->attributes['password_hash'] : '';
    }

    public function getRememberToken()
    {
        return isset($this->attributes['remember_token']) ? $this->attributes['remember_token'] : null;
    }

    public function setRememberToken($value)
    {
        $this->attributes['remember_token'] = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /*
    |--------------------------------------------------------------------------
    | JWTSubject Interface Methods
    |--------------------------------------------------------------------------
    */

    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifier();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => isset($this->attributes['email']) ? $this->attributes['email'] : null,
            'username' => isset($this->attributes['username']) ? $this->attributes['username'] : null,
        ];
    }
}
