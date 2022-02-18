<?php

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\RedirectHandler;
use Psr\Container\ContainerInterface;

class RedirectHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RedirectHandler
    {
        return new RedirectHandler($container->get(AmoCRMApiClient::class));
    }

}