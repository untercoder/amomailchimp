<?php
declare(strict_types=1);
namespace App\Traits;

use AmoCRM\Client\AmoCRMApiClient;
use Psr\Container\ContainerInterface;

trait MakeAmoClientTrait
{
    public function makeAmoClient(ContainerInterface $container):AmoCRMApiClient
    {
        $config = $container->get('config');
        $config_key = $config['keys'];
        $clientId = $config_key['integrationId'];
        $clientSecret = $config_key['secretKey'];
        $redirectUri = $config_key['redirectURI'];
        return new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
    }

}