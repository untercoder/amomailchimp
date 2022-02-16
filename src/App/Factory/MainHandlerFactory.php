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
        $config = $container->get('config');
        $config_key = $config['keys'];
        $amoApiCli = new AmoCRMApiClient($config_key['integrationId'], $config_key['secretKey'], $config_key['redirectURI']);
        return new MainHandler($amoApiCli);
    }

}