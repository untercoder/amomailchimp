<?php

namespace App\Workers\Task\Factories;

use App\Workers\Task\GetContactTask;
use App\Workers\Task\GetContactTaskConfig;
use Psr\Container\ContainerInterface;


class GetContactTaskFactory
{
    public function __invoke(ContainerInterface $container): GetContactTask
    {
        return new GetContactTask($container->get(GetContactTaskConfig::class));
    }

}