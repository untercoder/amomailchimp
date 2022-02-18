<?php
declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\MainHandler;
use Psr\Container\ContainerInterface;

class MainHandlerFactory
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container) : MainHandler
    {
        return new MainHandler($container->get(AmoCRMApiClient::class));
    }

}
