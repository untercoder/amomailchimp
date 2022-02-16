<?php
declare(strict_types=1);

namespace App\Factory;

use AmoCRM\Client\AmoCRMApiClient;
use App\Handler\GetUserNameHandler;
use App\Models\User;
use Psr\Container\ContainerInterface;

class GetUserNameHandlerFactory
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container) : GetUserNameHandler
    {
        return new GetUserNameHandler($container->get(AmoCRMApiClient::class), User::latest()->first());
    }

}