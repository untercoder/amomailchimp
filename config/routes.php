<?php

declare(strict_types=1);

use App\Handler\GetUserNameHandler;
use App\Handler\MainHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;


return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/api/get/username', GetUserNameHandler::class, 'get_username');
    $app -> get('/api/main', MainHandler::class, 'main');
};
