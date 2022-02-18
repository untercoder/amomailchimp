<?php

declare(strict_types=1);

return ['database' =>[
    'migration' => [
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