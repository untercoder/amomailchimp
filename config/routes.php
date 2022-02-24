<?php

declare(strict_types=1);

use App\Handler\AuthHandler;
use App\Handler\RedirectHandler;
use App\Handler\WebHookHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;


return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', RedirectHandler::class, 'redirect');
    $app->get('/api/auth', AuthHandler::class, 'auth');
    $app->post('/api/webhook/contacts', WebHookHandler::class, 'webhook.contacts');
};
