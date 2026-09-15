<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OdbcUserProvider implements UserProvider
{
    /**
     * Database connection name.
     *
     * @var string
     */
    protected $connection = 'odbc';

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 't_users_bphtb';

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $users = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM {$this->table} WHERE id = ?", [$identifier]);

        return !empty($users) ? new OdbcUser($users[0]) : null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $users = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM {$this->table} WHERE id = ? AND remember_token = ?", [$identifier, $token]);

        return !empty($users) ? new OdbcUser($users[0]) : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        DB::connection($this->connection)
            ->statement("UPDATE {$this->table} SET remember_token = ? WHERE id = ?", [$token, $user->getAuthIdentifier()]);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || (count($credentials) === 1 && array_key_exists('password', $credentials))) {
            return null;
        }

        $username = isset($credentials['username']) ? $credentials['username'] : (isset($credentials['email']) ? $credentials['email'] : null);

        if (!$username) {
            return null;
        }

        $users = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM {$this->table} WHERE email = ? OR username = ?", [$username, $username]);

        return !empty($users) ? new OdbcUser($users[0]) : null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        return Hash::check($plain, $user->getAuthPassword());
    }
}
