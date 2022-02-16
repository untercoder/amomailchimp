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
        $config = $container->get('config');
        $config_key = $config['keys'];
        $amoApiCli = new AmoCRMApiClient($config_key['integrationId'], $config_key['secretKey'], $config_key['redirectURI']);
        $user = User::latest()->first();

        return new GetUserNameHandler($amoApiCli, $user);
    }

}