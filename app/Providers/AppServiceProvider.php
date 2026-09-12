<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::extend('odbc', function ($config, $name) {
            $dsn = isset($config['dsn']) ? $config['dsn'] : 'odbc:simpada';
            $username = isset($config['username']) ? $config['username'] : 'dba';
            $password = isset($config['password']) ? $config['password'] : 'sql';
            $options = isset($config['options']) ? $config['options'] : array();

            $pdo = new \PDO($dsn, $username, $password, $options);

            $database = isset($config['database']) ? $config['database'] : '';
            $prefix = isset($config['prefix']) ? $config['prefix'] : '';

            return new Connection($pdo, $database, $prefix, $config);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
