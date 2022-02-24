<?php

namespace App\Workers\Task\Factories;

use App\Workers\Task\WebHookUpdateTask;
use App\Workers\Task\WebHookUpdateTaskConfig;
use Psr\Container\ContainerInterface;

class WebHookUpdateTaskFactory
{
    public function __invoke(ContainerInterface $container): WebHookUpdateTask
    {
        return new WebHookUpdateTask($container->get(WebHookUpdateTaskConfig::class));
    }

}