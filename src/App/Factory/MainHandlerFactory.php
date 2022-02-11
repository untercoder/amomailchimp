<?php

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
        $config = $container->get('config')['keys'];
        $clientId = $config['integrationId'];
        $clientSecret = $config['secretKey'];
        $redirectUri = $config['redirectURI'];
        $amoApiCli = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

        return new MainHandler($amoApiCli);

    }

}