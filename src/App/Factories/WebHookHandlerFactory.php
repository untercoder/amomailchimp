<?php

namespace App\Factories;

use App\Handler\WebHookHandler;
use App\Workers\Task\WebHookUpdateTask;
use Psr\Container\ContainerInterface;

class WebHookHandlerFactory
{
    public function __invoke(ContainerInterface $container): WebHookHandler
    {
        return new WebHookHandler($container->get(WebHookUpdateTask::class));
    }

}