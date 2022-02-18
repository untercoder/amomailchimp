<?php
declare(strict_types=1);

use \Phpmig\Adapter;
use Illuminate\Database\Capsule\Manager;

$container = new ArrayObject();

$config = require __DIR__.'/config/autoload/database.global.php';
$container['config'] = $config['database']['migration'];

$capsule = new Manager();
$capsule->addConnection($container['config'], $container['config']['connection_name']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = $capsule;

$container['phpmig.adapter'] = new Adapter\Illuminate\Database($container['db'], 'migrations', $container['config']['connection_name'],);
$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;
