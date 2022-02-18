<?php
declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\AuthHandler;
use Psr\Container\ContainerInterface;

class AuthHandlerFactory
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container) : AuthHandler
    {
        return new AuthHandler($container->get(AmoCRMApiClient::class));
    }

}
