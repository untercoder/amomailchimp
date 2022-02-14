<?php

namespace App\Traits;

use Illuminate\Database\Capsule\Manager;

trait TouchEloquentTrait
{
    public function startEloquent() : Manager{
        $options = [
            'connection_name' => 'default',
            'driver' => 'mysql',
            'username' => 'root',
            'password' => 'root',
            'host' => 'mysql',
            'database' => 'app_db',
            'port' => 3306,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ];
        $capsule = new Manager();
        $capsule->addConnection($options, $options['connection_name']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }
}