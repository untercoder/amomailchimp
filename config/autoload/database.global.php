<?php

declare(strict_types=1);

return ['database' =>[
    'migration' => [
//        'connection_name' => getenv('MYSQL_CONNECTION_NAME'),
//        'driver' => getenv('MYSQL_DRIVER'),
//        'username' => getenv('MYSQL_USERNAME'),
//        'password' => getenv('MYSQL_USER_PASSWORD'),
//        'host' => getenv('MYSQL_HOST_FOR_MIGRATION'),
//        'database' => getenv('MYSQL_DB_NAME='),
//        'port' => (int)getenv('MYSQL_PORT'),
//        'charset' => getenv('MYSQL_CHARSET'),
//        'collation' => getenv('MYSQL_COLLATION'),
//        'prefix' => '',
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
    ],
    'orm' => [
        'connection_name' => getenv('MYSQL_CONNECTION_NAME'),
        'driver' => getenv('MYSQL_DRIVER'),
        'username' => getenv('MYSQL_USERNAME'),
        'password' => getenv('MYSQL_USER_PASSWORD'),
        'host' => getenv('MYSQL_HOST_FOR_ORM'),
        'database' => getenv('MYSQL_DB_NAME'),
        'port' => (int)getenv('MYSQL_PORT'),
        'charset' => getenv('MYSQL_CHARSET'),
        'collation' => getenv('MYSQL_COLLATION'),
        'prefix' => '',
    ]
]
];