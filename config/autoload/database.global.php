<?php

declare(strict_types=1);

return ['database' =>[
    'migration' => [
        'connection_name' => getenv('MYSQL_CONNECTION_NAME') ?: 'default',
        'driver' => getenv('MYSQL_DRIVER') ?: 'mysql',
        'username' => getenv('MYSQL_USERNAME') ?: 'user',
        'password' => getenv('MYSQL_USER_PASSWORD') ?: 'user',
        'host' => getenv('MYSQL_HOST_FOR_ORM') ?: '127.0.0.1',
        'database' => getenv('MYSQL_DB_NAME') ?: 'app_db',
        'port' => (int)getenv('MYSQL_PORT') ?: 3306,
        'charset' => getenv('MYSQL_CHARSET') ?: 'utf8',
        'collation' => getenv('MYSQL_COLLATION') ?: 'utf8_unicode_ci',
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