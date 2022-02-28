<?php

namespace App\Factories;

use AmoCRM\Client\AmoCRMApiClient;
use Psr\Container\ContainerInterface;

class AmoApiCliFactory
{
    public function __invoke(ContainerInterface $container) : AmoCRMApiClient
    {
        $config = $container->get('config');
        $config_key = $config['keys'];
        return new AmoCRMApiClient($config_key['integrationId'], $config_key['secretKey'], $config_key['redirectURI']);
    }

}
