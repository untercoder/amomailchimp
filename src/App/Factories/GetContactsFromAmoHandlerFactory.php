<?php

namespace App\Factories;

use App\Handler\GetContactsFromAmoHandler;
use App\Workers\Task\GetContactTask;
use App\Workers\Task\GetContactTaskConfig;
use Interop\Container\ContainerInterface;

class GetContactsFromAmoHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetContactsFromAmoHandler
    {
        return new GetContactsFromAmoHandler($container->get(GetContactTask::class));
    }


}