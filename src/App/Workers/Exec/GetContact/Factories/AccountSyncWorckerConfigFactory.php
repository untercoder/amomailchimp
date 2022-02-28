<?php

namespace App\Workers\Exec\GetContact\Factories;

use AmoCRM\Client\AmoCRMApiClient;
use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Exec\GetContact\AccountSyncWorkerConfig;
use MailchimpMarketing\ApiClient;
use Psr\Container\ContainerInterface;

class AccountSyncWorckerConfigFactory
{
    public function __invoke(ContainerInterface $container): AccountSyncWorkerConfig
    {
        $config = $container->get('config')['contactWorker'];

        return new AccountSyncWorkerConfig(
            $config['name'],
            $config['queue'],
            $container->get(Beanstalk::class),
            $container->get(AmoCRMApiClient::class),
            $container->get(ApiClient::class)
        );
    }

}