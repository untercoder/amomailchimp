<?php

use \Phpmig\Adapter;
use Illuminate\Database\Capsule\Manager;

$container = new ArrayObject();

$container['config'] = [
    'connection_name' => 'default',
    'driver' => 'mysql',
    'username' => 'user',
    'password' => 'user',
    'host' => '127.0.0.1',
    'database' => 'app_db',
    'port' => 3306,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];

$capsule = new Manager();
$capsule->addConnection($container['config'], $container['config']['connection_name']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = $capsule;

// replace this with a better Phpmig\Adapter\AdapterInterface
$container['phpmig.adapter'] = new Adapter\Illuminate\Database($container['db'], 'migrations', $container['config']['connection_name'],);


$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

// You can also provide an array of migration files
// $container['phpmig.migrations'] = array_merge(
//     glob('migrations_1/*.php'),
//     glob('migrations_2/*.php')
// );

return $container;