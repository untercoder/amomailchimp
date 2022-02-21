<?php

namespace App\Workers\Exec\GetContact\Factories;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Exec\GetContact\AccountSyncWorkerConfig;
use Psr\Container\ContainerInterface;

class AccountSyncWorckerConfigFactory
{
    public function __invoke(ContainerInterface $container): AccountSyncWorkerConfig
    {
        $config = $container->get('config')['contactWorker'];

        return new AccountSyncWorkerConfig(
            $config['name'],
            $config['queue'],
            $container->get(Beanstalk::class)
        );
    }

}